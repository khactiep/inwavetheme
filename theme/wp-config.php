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
define('DB_NAME', 'khactiepblog');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'w-As)Q/ba&yQ0;^AP5vN!QVXu_gD!EG(0S+A`[y=!,/_ y}kh@UuK}0K*-#b]:4~');
define('SECURE_AUTH_KEY',  'u2%Uy(,fsM[E!eunOHG#56Z5tVO?LmV)0gyGP|LWHT>CTe#YM)qRXIVaZ6}ifT;p');
define('LOGGED_IN_KEY',    ';[=g04RR}XJJrD0xE2H4Y}oc7E$c`(|*Pxr(Ll>*fYnbc+/QvWy QivkIt(xL3S3');
define('NONCE_KEY',        '3A9#G|V21TNw)Isc{_GN59HMJx9U@U#Sn`8Az[.{&dzQ3.CXoa.dF/K dpaFv^:i');
define('AUTH_SALT',        '>!s^B8l&/b=?YfsgUsOG89{YL0 :0l@QD+e<<y~B0*`+4=&,cjbPW7Pyyf+WjF?6');
define('SECURE_AUTH_SALT', 'P3nV|{GW@-/6x)~.E?([U2Oorc@LgK(i&5_QQuz;_aGSmMq@Z|1Dzy<oA[gLR`fQ');
define('LOGGED_IN_SALT',   'SM*tRGlZ?%;]4%{Y~&hh>-md/ CuL]a,Q}r4[.2;*0E]9{etpe}, AcXEJV&?/#z');
define('NONCE_SALT',       'qg_x^i%W(W&Ny^ZTr[T)UKX9g[p4,e!O ;%h4vM1[{73,-9bI~(o+aF{/(ihn.l2');

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
