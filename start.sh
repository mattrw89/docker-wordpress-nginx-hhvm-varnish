#!/bin/bash

# if [ -f /.mysql_db_created ]; then
#         exec supervisord -n
#         exit 1
# fi

DB_HOST=${DB_PORT_3306_TCP_ADDR:-${DB_HOST}}
DB_HOST=${DB_1_PORT_3306_TCP_ADDR:-${DB_HOST}}
DB_PORT=${DB_PORT_3306_TCP_PORT:-${DB_PORT}}
DB_PORT=${DB_1_PORT_3306_TCP_PORT:-${DB_PORT}}

DB_NAME=$DB_1_ENV_DB_NAME
DB_USER=$DB_1_ENV_DB_USER

printenv

DB_PASS="$DB_1_ENV_MYSQL_PASS"

echo "=> Trying to connect to MySQL/MariaDB using:"
echo "========================================================================"
echo "      Database Host Address:  $DB_HOST"
echo "      Database Port number:   $DB_PORT"
echo "      Database Name:          $DB_NAME"
echo "      Database Username:      $DB_USER"
echo "      Database Password:      $DB_PASS"
echo "========================================================================"

for ((i=0;i<10;i++))
do
    DB_CONNECTABLE=$(mysql -u$DB_USER -p$DB_PASS -h$DB_HOST -P$DB_PORT -e 'status' >/dev/null 2>&1; echo "$?")
    if [[ DB_CONNECTABLE -eq 0 ]]; then
        break
    fi
    echo "FAILED TO CONNECT TO MYSQL DB... attempt $i"
    sleep 5
done

if [[ $DB_CONNECTABLE -eq 0 ]]; then
    DB_EXISTS=$(mysql -u$DB_USER -p$DB_PASS -h$DB_HOST -P$DB_PORT -e "SHOW DATABASES LIKE '"$DB_NAME"';" 2>&1 |grep "$DB_NAME" > /dev/null ; echo "$?")

    if [[ DB_EXISTS -eq 1 ]]; then
        echo "=> Creating database $DB_NAME"
        RET=$(mysql -u$DB_USER -p$DB_PASS -h$DB_HOST -P$DB_PORT -e "CREATE DATABASE $DB_NAME")
        if [[ RET -ne 0 ]]; then
            echo "Cannot create database for wordpress"
            exit RET
        fi
        echo "=> Done!"    
    else
        echo "=> Skipped creation of database $DB_NAME – it already exists."
    fi
else
    echo "Cannot connect to Mysql"
    exit $DB_CONNECTABLE
fi

touch /.mysql_db_created
mkdir /home/wordpress/builtin_wordpress
mkdir /home/wordpress/live_wordpress

LATEST_WP_VERSION=$(python /home/wordpress/scripts/wp_version_checker.py)
BUILTIN_WP_VERSION=$(head -n 1 /home/wordpress/builtin_wordpress/wp_version.txt)
echo $LATEST_WP_VERSION
echo $BUILTIN_WP_VERSION


if [ ! -a "/home/wordpress/live_wordpress/wp_version.txt" ]; then

  if [ "$CURR_BUILTIN_WP_VERSION" == "$BUILTIN_WP_VERSION" ]
  then
    mv /home/wordpress/builtin_wordpress/wp_version.txt /home/wordpress/live_wordpress/wp_version.txt
    cp -r /home/wordpress/builtin_wordpress/wordpress/* /home/wordpress/live_wordpress
  fi

  if [ "$CURR_BUILTIN_WP_VERSION" != "$BUILTIN_WP_VERSION" ]
  then
    mkdir /home/wordpress/temp
    cd /home/wordpress/temp; wget $(python ../scripts/wp_version_writer.py) -O latest.tar.gz; tar -xvzf latest.tar.gz; rm latest.tar.gz
    mv /home/wordpress/temp/wp_version.txt /home/wordpress/live_wordpress/wp_version.txt
    cp -r /home/wordpress/temp/wordpress/* /home/wordpress/live_wordpress
    rm -rf /home/wordpress/temp
  fi
fi



cd /home/wordpress/live_wordpress

if ! grep -Fxq "define( 'Object', 'OBJECT', true );" wp-includes/wp-db.php
then
  sed -i -r "/define\(\s*'OBJECT',\s+'OBJECT',\s+true\s*\);/a define( 'Object', 'OBJECT' );" wp-includes/wp-db.php
fi
if ! grep -Fxq "define( 'object', 'OBJECT', true );" wp-includes/wp-db.php
then
  sed -i -r "/define\(\s*'OBJECT',\s+'OBJECT',\s+true\s*\);/a define( 'object', 'OBJECT' );" wp-includes/wp-db.php
fi
sed -i -r "s/define\(\s*'OBJECT',\s+'OBJECT',\s+true\s*\);/define( 'OBJECT', 'OBJECT' );/" wp-includes/wp-db.php

mv ../_config/wp-config.php ./wp-config.php
mv ../_config/production-config.php ../production-config.php

chown wordpress:wordpress wp-config.php ../production-config.php
chown wordpress:wordpress /home/wordpress/live_wordpress/*

pwd
ls -la

/usr/bin/hhvm --config /etc/hhvm/server.ini --user www-data --mode daemon &
service nginx start
/usr/sbin/varnishd -f /etc/varnish/default.vcl -s malloc,100M -a 0.0.0.0:80
varnishlog -w /home/wordpress/varnish.log -i Timestamp,Begin,ReqMethod,ReqUrl,ReqHeader -d
tail -f /var/log/hhvm/error.log -f /var/log/nginx/error.log -f /var/log/nginx/access.log -f /home/wordpress/varnish.log

# exec supervisord -n
