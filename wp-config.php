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
define('DB_NAME', 'tradehouse');

/** MySQL database username */
define('DB_USER', 'lead_sharad');

define('FS_METHOD', 'direct');

/** MySQL database password */
define('DB_PASSWORD', 's_Q6W4&+d]JjWxh[');

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
define('AUTH_KEY',         '<xj(zr+5,uY{:hc?a8bT%:]qQBAIA:jj$I8k6Myt:nili`ZQcbXTq+*`lqO;Q| t');
define('SECURE_AUTH_KEY',  'Gcrwo` 8+rV/Q`p&dkkE[Aj1kfi4L.v+s{Nxt8!<CX7,}(A]n2eD>)1l_J%l+/z=');
define('LOGGED_IN_KEY',    'Mq6@nz%(bk^zf%&;)UhP+bvzidkH@ex9U$2h8 fyaWe|2%+TFCE.=S<p|?A|#elM');
define('NONCE_KEY',        '|/4h<`z^Fs:8-7tJEaHLEx6zI[#g_hr*~>{a5Sc<:u`s_},2t?6-rRTf)+Nz0v#(');
define('AUTH_SALT',        'iTPrjeAxdkP2K!Gp],T0GouxBh;3IP>/+<V/Fd2hn9;8>.CWB(Tb9Um )c&xApG ');
define('SECURE_AUTH_SALT', ')lnt8*DQXgQ^q-]T_`^&<M#_MZly:j|.([-]_-)o.2X->s&^?B`hR]GzA){9Bw%-');
define('LOGGED_IN_SALT',   'NzN`v.nC+?>9L}AN~MNcOGiZ=QoIk,A>pv|l2S$fXUDr~h6o~e8+zu~u~+uvr$s=');
define('NONCE_SALT',       '8,HChXG9pfcgWF0(>esCE>@*7!3=s%mMox rJ>{$cg<)HU$L<8PE`YAT1s1+8ZbH');

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
