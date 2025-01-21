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
define( 'DB_NAME', 'system' );

/** Database username */
define( 'DB_USER', 'system_admin' );

/** Database password */
define( 'DB_PASSWORD', 'system' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3307' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

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
define( 'AUTH_KEY',         'ZY%Z;l)2h Eb@d4bdt7btN^`q!]rpGNQ!5HkR5`ub2_a>D0^O,sccYtHP*%&`R2X' );
define( 'SECURE_AUTH_KEY',  '%f-5Ic!;CL*#s*Y<}aPKu,=5&/9kgzMY]r `d!Krd2z<FKx(0a^K8bP/37mQEj:}' );
define( 'LOGGED_IN_KEY',    'jmn<=-Z{eGP) C<X6b@mW} k5j*t*-JH)=8p[S=D x7g$LU}1/Mpdik1[5?3Ms$5' );
define( 'NONCE_KEY',        'czjB{LPNzM/!&oJ9|g@0|p!oiV2gBt!RZ*B/L70LIyR8U#Zylls&x^z`h~|skX{.' );
define( 'AUTH_SALT',        'KV!ED6V%I+#|l>&RasIZRXX7@}VC}I6UKM$?4r&Ut.[q}Co@U3gZ~.z21r{g=5t5' );
define( 'SECURE_AUTH_SALT', '^YvH{.kFW4$u% tUt+R|uCY{F76_j+dp{;:0@foC)?(F^nNLpOp1Q:jx--]O$-D6' );
define( 'LOGGED_IN_SALT',   'IVPRm=j/]olG6IApCxljw1Dn>z9:~[s^MO5}b55><wBnowp-RM9Jg,2pl-(<S=O#' );
define( 'NONCE_SALT',       '$Ljy=,s2sJJs>h d_0Rg+{dcz(_<=OEj/NdcwL/h!gwmJ#O 0NqTME*}ddrqySJd' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define('WP_DEBUG', false);


/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (! defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}


/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
