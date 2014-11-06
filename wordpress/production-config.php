<?php

/**
 *  * WordPress config file to use one directory above WordPress root, when awesome version of wp-config.php is in use.
 *   *
 *    * Awesome wp-config.php file - https://gist.github.com/1923821
 *     */

/* WordPress Local Environment DB credentials */

define('DB_NAME', getenv("DB_1_ENV_DB_NAME"));
define('DB_USER', getenv("DB_1_ENV_DB_USER"));
define('DB_PASSWORD', getenv("DB_1_ENV_MYSQL_PASS"));
define('DB_HOST', getenv("DB_1_PORT_3306_TCP_ADDR"));
define('DB_PORT', getenv("DB_1_PORT_3306_TCP_PORT"));
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

define("WP_SITEURL", "http://" . $_SERVER['HTTP_HOST'] );
define("WP_HOME", "http://" . $_SERVER['HTTP_HOST'] );

/* Keys & Salts */

define('AUTH_KEY',         '(Xpj=vz$-*,Q$FG0YPz%38PJhMUF0#><bMhRcd+#U=Js=jSL9`__1eJh^F%-/eE0');
define('SECURE_AUTH_KEY',  'bA-_-76;)*bQ5*/dF7bGM+J^-S+vs#nCs3V;T-&hR6FG~XmFs^hi~*Z4e=7R]z^.');
define('LOGGED_IN_KEY',    '`4%jOoK/.UmF8k0N^BoSX?-o+Em@$wVkM}USh+YFbCL/kQyfR6fO{?GcJINK4-{M');
define('NONCE_KEY',        '[5&3xHi20-A`J9RmNJJxqx UGmy|[f$jdi)JV)p:kn9.( T7vY;?gl #&ww17(p<');
define('AUTH_SALT',        '} 5gvx=?2^nEeR*Xj)#ucZS<gM~|+cL,s07n8lY&:Ki(7-z;.)]Dr_wbcx.?;l=3');
define('SECURE_AUTH_SALT', 'r8%VZ0|eJ|N|*@G?,j&USb>OF7C;@rpy 3slF9p;:(jn1=+RM9v3(J~q@+ef(td:');
define('LOGGED_IN_SALT',   'LKSJ*JEv!9T@A?9AfFu@ |JXEBb{+7Wql~T}D3B} 5<oyDq7.|WurvEz{Eu1-IcG');
define('NONCE_SALT',       'Aws^dqG@gtYB0F$t$R/CXt|G||+(<QU|Z@*jcYsMhLr],.*rTx7zBl~;q{,tQpg7');
