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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

include_once dirname( __FILE__ ).'/wp-configs/'.$_SERVER['HTTP_HOST'].'.php';

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'j<I@_YDdFNJr!d=85B&G,mYiPHvX10>DaF&;:~D[(TnsU@Csl.}NPJq(Wl(GZ}10' );
define( 'SECURE_AUTH_KEY',  '>,2M7}z`N(FLFOS?e3?|N$,K<0>/*ufK3s^|*B2h9!w(twiOZTO{:e(x<u1y/)y>' );
define( 'LOGGED_IN_KEY',    'e`SGO<oM>Ga^8EB0A1En/pNm(;Ar9i=_(%?3).u6Msh5jv=[?v6wD-WdYIk&5>_n' );
define( 'NONCE_KEY',        'E!nXRDM[+l` ad@s/m7:;/;(d{G35<n,]R:U{Is>F(S8[*GtuKYkDf_*#K2^$q%1' );
define( 'AUTH_SALT',        'Liy#)`A,:|;Eu``-cklZ$ .tzyIJxB4%pJs1;%8l4%CW^xfv!V,Uqgup^iD]8K1l' );
define( 'SECURE_AUTH_SALT', 'cyp]~VJHgcjS|#!p?6G#`AkkUf`0BN}TM|#4Ul*{$wo{e7JLgl(Cg[m_|lO2~M+]' );
define( 'LOGGED_IN_SALT',   'A*nH<D$e`-sMlkJ*hYk_ftG_W1sg&^$wS8(/JZP9fU^OA,Faih>?am?=vya]NI8)' );
define( 'NONCE_SALT',       'It(%zB%!w3>lhawUy%k5a%hU.,/!Hl5pdHIYV}r4M/Ane@_Am4qQI5u(HLCr5wHH' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
