<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'evertech__blog__' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '/qWCskr,?)JDYfT bkl>[YDr)]2_c7+4,B(zo!SYpEc8?qgI3R%sub7PU@=@Kx.h' );
define( 'SECURE_AUTH_KEY',  'TeKk(d@<z!)6{*U?s1jcDIH*Ld<TO3~3gt2i+T(Ke3LI:jS~F-aqQlFrFBY6A=GP' );
define( 'LOGGED_IN_KEY',    'J)_t!V_|F,u*iqbrhNr>ooG#b_6vpm@A^uY3AK_1oYy/EQ1&%gb@MlwE._^V+6np' );
define( 'NONCE_KEY',        '>Mlk*bl3&<5c:,~VbrpW]1MtRps&Gcq#@B>u/D?e4$EPJDtZCn2(d->lw9r<L62&' );
define( 'AUTH_SALT',        '[ux{G-~LXp#G-l${ IIb&ERVWI0Q2.$KcpfWMEQ+&>~)wpJzO1JIA]/iaBfFYY):' );
define( 'SECURE_AUTH_SALT', 'ObFujSDZed<}D(e:M|o37LO{JZHiDxs<3c9R{i<%p6`#C/Fww<g6M =6h1QkXZrD' );
define( 'LOGGED_IN_SALT',   'W6c2hcwUFlXs:rf$UX)c8*L^_0U%V}ydJva;#k(D{`+[>l45urlDS,U-!C :9..F' );
define( 'NONCE_SALT',       'H+aJ:00fhMt>`[?k{bdBI,u:[/$iG_ZR?w~>G{cHPpc|[y|G4|ci!IY#la>+[OQP' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpevt_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
