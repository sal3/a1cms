<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', '7788');

/** MySQL database username */
define('DB_USER', 'zzzz1');

/** MySQL database password */
define('DB_PASSWORD', 'KylwwBqD');

/** MySQL hostname */
define('DB_HOST', 's2.tcphost.net');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '1yGw?|.(<)o]Fr(Q;w&lgRF$soO<j0~FA-6I?713G6Iu3aySn<4b8(pQe F^uO[F');
define('SECURE_AUTH_KEY',  '%g36[,v^hMQFqd[fIa14ux)5#9cZryc08WJAM531N =gF]JLqb@4Z8JqG.;J1F(w');
define('LOGGED_IN_KEY',    'Hv*C`qP*:b;2E&F_F=Ui{vHR;pL9[~J5X*r@s|>! 6f`S=?+/W-sR!%*?kq)+Nhw');
define('NONCE_KEY',        'z45+?a^l?i~~r6a/OWCh+O+,-|P*P3/8O;F_-ARy?;|0QtG2j,s^Sb&477q>87#d');
define('AUTH_SALT',        'LxaqJCK6#s[Q!w<^@DR3(Ph8?/U?WKnGuzq0Glbw5AmQbBuDYmk/`O!eUCMx:(oX');
define('SECURE_AUTH_SALT', '=e#KEeXVbw} O)9j,2t}UXf7pbo@42@-=@IPEO;Sx>[yP;|kW#yHKwD p=<-ecTW');
define('LOGGED_IN_SALT',   ':*+A; Cu/d&Wx0~GQ$qKN0O~]j9-u.z&|^}1`^&/%_tKHA!~7M(@PO6*m,?):~f/');
define('NONCE_SALT',       'H &Pr5]llLZ%hx<,KKruXZzBxfd:gW;,@d?+*?HqeB~U>!7J;F9|HVuA`]XzCh.N');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
