<?php
//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL cookie settings

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'rjc_wp7' );

/** Database username */
define( 'DB_USER', 'rjc_wp7' );

/** Database password */
define( 'DB_PASSWORD', 'B,h29jUrrun~tQZM2a(90.[4' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'IZzi3TaUpJzVxw9jJyUNpSCJ0z3NP6r4KISqnzwb2Oy9DIxdQou7DBJTAKxhq4Eo');
define('SECURE_AUTH_KEY',  'pItLnalN7zVhGxX8cmiRzuLAsaYDYUBK11yllBeyQOqpZePl1Yq2MOfNTAHgZ44L');
define('LOGGED_IN_KEY',    '8916FXi3MmwULW1wwUOFYul9bwF4DCldSey6DDreWa7u2GLR8hNgu9fcLTU89zMY');
define('NONCE_KEY',        'RHfOxQgqFUjtJMiPXW6iOrMW42ENVCO8A8l5OqscBfCRhyZHmmeyr71pcZQdf7Nb');
define('AUTH_SALT',        '2QkVCSefxUu3NZ23NITF0fvuQ0KAfC4d50gMrzJAgJAd2pzwGw5mH2x0Md0mnzha');
define('SECURE_AUTH_SALT', 'Z4w80NHRjZaq5QyeiFW8ubmMgGNpCW2dlX2fNf9wubDEEGQi5xTbm6fhKEdPRpnR');
define('LOGGED_IN_SALT',   'xal8x7d9ZKlmoUzhvb7e7UYwwbkouCjJy72GSFickZkXYsJWFDzV6YGX67qfULqY');
define('NONCE_SALT',       'BGYqkkslroTryrb02ks44tyRaVFHicgg4U1gnfhi9amfkSYtQBg0qqR8Z58krcFt');

/**
 * Other customizations.
 */
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpstg0_'; // Changed by WP STAGING

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
define('WP_LANG_DIR', __DIR__ . '/wp-content/languages');
define('WP_HOME', 'https://www.kyokasugu.com/kyokasugu-test');
define('WP_SITEURL', 'https://www.kyokasugu.com/kyokasugu-test');
define('WP_CACHE', false);
define('DISABLE_WP_CRON', false);
if ( ! defined( 'WP_ENVIRONMENT_TYPE' ) ) {
    define('WP_ENVIRONMENT_TYPE', 'staging');
}
define('WP_DEVELOPMENT_MODE', 'all');
if ( ! defined( 'WPSTAGING_DEV_SITE' ) ) {
    define('WPSTAGING_DEV_SITE', true);
}
define('UPLOADS', 'wp-content/uploads');
define('WP_PLUGIN_DIR', __DIR__ . "/wp-content/plugins");
define('WP_PLUGIN_URL', 'https://www.kyokasugu.com/kyokasugu-test/wp-content/plugins');
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
