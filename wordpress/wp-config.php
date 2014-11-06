<?php

/**
* Define type of server
*
* Depending on the type other stuff can be configured
* Note: Define them all, don't skip one if other is already defined
*/

define( 'DB_CREDENTIALS_PATH', dirname( ABSPATH ) ); // cache it for multiple use
define( 'WP_LOCAL_SERVER', file_exists( DB_CREDENTIALS_PATH . '/local-config.php' ) );
define( 'WP_DEV_SERVER', file_exists( DB_CREDENTIALS_PATH . '/dev-config.php' ) );
define( 'WP_STAGING_SERVER', file_exists( DB_CREDENTIALS_PATH . '/staging-config.php' ) );

/**
* Load DB credentials
*/

if ( WP_LOCAL_SERVER )
    require DB_CREDENTIALS_PATH . '/local-config.php';
elseif ( WP_DEV_SERVER )
    require DB_CREDENTIALS_PATH . '/dev-config.php';
elseif ( WP_STAGING_SERVER )
    require DB_CREDENTIALS_PATH . '/staging-config.php';
else
    require DB_CREDENTIALS_PATH . '/production-config.php';

/**
* Authentication Unique Keys and Salts.
*
* Change these to different unique phrases!
* You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
* You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
*/

if ( ! defined( 'AUTH_KEY' ) )
    define('AUTH_KEY', '9*W=5&lt;Rw-)c].9}g?^[:!j]h+Efr&lt;y$&lt;YmV0XOo|lOIujEE}+[R}iAQZ :Sy3wN}');
if ( ! defined( 'SECURE_AUTH_KEY' ) )
    define('SECURE_AUTH_KEY', 'APge3~H;g+b0FyNF&amp;e`$=g?qj9@FQwqFe^Q4(@p#kDa=NR? $Z9|@v*a(tOj*B+.');
if ( ! defined( 'LOGGED_IN_KEY' ) )
    define('LOGGED_IN_KEY', '5l0+:WTpj8#[V|;&lt;Iw;%rkB(A}r++HwT|s[LW!.wt.=5J!b%Z{F1/[LxQ*d7J&gt;Cm');
if ( ! defined( 'NONCE_KEY' ) )
    define('NONCE_KEY', 'zO2cmQX`Kc~_XltJR&amp;T !Uc72=5Cc6`SxQ3;$f]#J)p&lt;/wwX&amp;7RTB2)K1Qn2Y*c0');
if ( ! defined( 'AUTH_SALT' ) )
    define('AUTH_SALT', 'je]#Yh=RN DCrP9/N=IX^,TWqvNsCZJ4f7@3,|@L]at .-,yc^-^+?0ZfcHjD,WV');
if ( ! defined( 'SECURE_AUTH_SALT' ) )
    define('SECURE_AUTH_SALT', '^`6z+F!|+$BmIp&gt;y}Kr7]0]Xb@&gt;2sGc&gt;Mk6,$5FycK;u.KU[Tw$345K9qoF}WV,-');
if ( ! defined( 'LOGGED_IN_SALT' ) )
    define('LOGGED_IN_SALT', 'a|+yZsR-k&lt;cSf@PQ~v82a_+{+hRCnL&amp;|aF|Z~yU&amp;V0IZ}Mrz@ND])YD22iUM[%Oc');
if ( ! defined( 'NONCE_SALT' ) )
    define('NONCE_SALT', '|1.e9Tx{fPv8D#IXO6[&lt;WY*,)+7+URp0~|:]uqiCOzu93b8,h4;iak+eIN7klkrW');

/**
* WordPress Database Table prefix.
*
* You can have multiple installations in one database if you give each a unique
* prefix. Only numbers, letters, and underscores please!
*/

$table_prefix = 'wp_';

/**
* WordPress Localized Language, defaults to English.
*
* Change this to localize WordPress. A corresponding MO file for the chosen
* language must be installed to wp-content/languages. For example, install
* de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
* language support.
*/

define( 'WPLANG', '' );

/**
* For developers: WordPress debugging mode.
*
* Change this to true to enable the display of notices during development.
* It is strongly recommended that plugin and theme developers use WP_DEBUG
* in their development environments.
*/

if ( WP_LOCAL_SERVER || WP_DEV_SERVER ) {

    define( 'WP_DEBUG', true );
    define( 'WP_DEBUG_LOG', true ); // Stored in wp-content/debug.log
    define( 'WP_DEBUG_DISPLAY', true );

    define( 'SCRIPT_DEBUG', true );
    define( 'SAVEQUERIES', true );

} else if ( WP_STAGING_SERVER ) {

    define( 'WP_DEBUG', true );
    define( 'WP_DEBUG_LOG', true ); // Stored in wp-content/debug.log
    define( 'WP_DEBUG_DISPLAY', false );

} else {

    define( 'WP_DEBUG', false );
}


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
