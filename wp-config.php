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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         '/>!kFLMNc.XUFp@QFi0kk%5$/HZG/}iPP-<hUy4,iOPFQcpuo@e$ss%r/?4YVSRC');
define('SECURE_AUTH_KEY',  '{0H`L[a-. 1;,C>5o&KP.CdzMiWd}NX1.nX*a?Od)7&x0;l|TII1W^uts@zdU, 9');
define('LOGGED_IN_KEY',    'YB^9{@wh5ONMI4:~D.,`k[2]6<L<*D`b=s(&b!u*0>QJM)Bl91xH67Iu)02tsn<^');
define('NONCE_KEY',        '3%/@L$r#2A.<-F@xKtuMLa.|%ow<bc1!]r [t:d_ha*5%z^zaN?>8zd*-7ahN?j<');
define('AUTH_SALT',        '`.,qd@bx!^y%b2z3L78+wk%khf2e*LM89i&z6{1R-8ai`r8I~foiMU<4Rv.sJ!<z');
define('SECURE_AUTH_SALT', 'GdZ0z2P._|,]mZ/CV@pzvwdx_F%_<UxsqYgv,wH;K9}_StmLPwaV&ja)eli te}O');
define('LOGGED_IN_SALT',   ']HjT2~kSnr-=?(T;C*5oXR5nNgJzUtIQgE}}:SQ6V[GRWe(dE>lL*^rB=w,^GUI.');
define('NONCE_SALT',       'IDC% =5V@m],yjiA4Weo5F!1yb_B*H8X[0%w7o_MaFZVC9jdoV /=Wlha<k@sll_');

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
