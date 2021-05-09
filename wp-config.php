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
define( 'DB_NAME', 'wordpressdb' );

/** MySQL database username */
define( 'DB_USER', 'wordpress' );

/** MySQL database password */
define( 'DB_PASSWORD', 'ipsec400' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          ')?Oi:xed/BXh&%?=tv@apjVQMg(-g# 5@O@-SlLfLqbH1CV3,fY<@u0uN 2)g  I' );
define( 'SECURE_AUTH_KEY',   'B(X9*}QgD~b0xf=_u%eF2<97p_pyqC)@a|n,)w]=0 WZR?R1*=rkPCqQFjXkXL-&' );
define( 'LOGGED_IN_KEY',     '%Zx3{|jQAc>RY-p.$rYpd*=F5EZ+-gv]]mCx4Nmyc}?Z&BV2?6$`x%}ZG]kxbN=;' );
define( 'NONCE_KEY',         'DlE[rGhz#EeH:hV$D~]G0LXA/GP*k3O_H*,k{1Q(vl2jTC)EqG_/a%_x_}:|G&R>' );
define( 'AUTH_SALT',         'u>U:.*CD9rn(.l#<Zo<G=jf-q!dxv.mW7eLu1K$yo|Op@#(~[iaj`1Rn{PQ3_1w+' );
define( 'SECURE_AUTH_SALT',  'XvMBRC[&l7pL8lNk7vf7([nOoDB)IqFY3dAY+`{S*A`lm?if;,^!;^Ur%s;Ed/+z' );
define( 'LOGGED_IN_SALT',    '9VSFDB&lgPndk ,;345ZmIBLBdr{?elxC:Kes]ROt;DYb27I.|xJy~5o]bU2:]nU' );
define( 'NONCE_SALT',        'n1UT|583K#tg;y2Ry<c)bTFj_&FzP0A.v4l!m3G`6sFE3yxwu.CLs_}K#thkzXf^' );
define( 'WP_CACHE_KEY_SALT', '!Gwq38}dx[/,69s$pq)I)5@C`)&g5i|{E;nyBWWnVEPvi+)Xjuv9~VdWKg~fW-K@' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
