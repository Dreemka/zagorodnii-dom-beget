<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'dadonou8_chs');

/** MySQL database username */
define('DB_USER', 'dadonou8_chs');

/** MySQL database password */
define('DB_PASSWORD', 'dadonou8_chs!2018');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'ncYp{].8&:xIJy&sB9SAj?*Z` rFcQRH4w6!kYb~[cr!#f9oHIrVs@*.I&>r{2.^');
define('SECURE_AUTH_KEY',  'B=V(,W[Y9|E_9e+Il9bGz@[/g&_!{[aiSz5?%>d d8r`=u?-H,6C%lYz8_flPtaH');
define('LOGGED_IN_KEY',    'N(>-J6P!h>jWrq%GpZRS;+2?t#6&&[IgAiyQwM#uhW*0?Ch%oCV<d6!  @Vt,aL`');
define('NONCE_KEY',        'sPQ~tD;?70fD~#/nVtu~I3>{/@ukH4)AsORj[om#_G*a_DD%^J2b>:oH-X:6Gm>Q');
define('AUTH_SALT',        'eX!S]^ElXuXj@v>Ch%n+X=|q4+W./bL?WYKEK#R[A_Qo6:R|=yF5$&tD0cpUnl]m');
define('SECURE_AUTH_SALT', 'A7BZ)nXV&AlPVCW[)6pj2rs:!ZSbW2O&U2Sv4J!q-@nIw,XZ=^%G#0u}1)a%BA6+');
define('LOGGED_IN_SALT',   '&8xhTCGdGxO7l3%^;ftA{v*0bwN5&7xH,NvI%)nwO&ZOovoGY EAB}!6 ,~~c8+2');
define('NONCE_SALT',       'Yvco%j44.IoNs^jS+<(qo{^7wq8-w[xtx5M|#7Hcy|>|X%Pml&{$7@9+0!q[*P1;');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);
define('WP_HOME', 'http://'. $_SERVER['HTTP_HOST']);
define('WP_SITEURL', 'http://'. $_SERVER['HTTP_HOST']);
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
