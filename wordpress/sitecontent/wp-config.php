<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'wordpress');

/** MySQL database password */
define('DB_PASSWORD', 'ge6y56yz');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'xieFae4OhM5iejooch1ieb8iev6raijo7boaC8phaikiShoHe4Iu5eCohngahsu2n');
define('SECURE_AUTH_KEY',  'ritigoht2Thahgighebu9thieg0ahtaichai9eiWah9theeghaidoveephi8ahv6O');
define('LOGGED_IN_KEY',    'cooxohJaiShahloo1pegei9yuing1moaF8eech3aequaekaegai1ieg4ooTh0phie');
define('NONCE_KEY',        'Eechi0zah0ohg8aiW8oohae4eNaox1eiba7aumevahghie7ooSahthohnahquaita');
define('AUTH_SALT',        'midahbee1shieyeihoovuNg2Ohkievailae6ahQuiequ8ahme1chie7bophee7af4');
define('SECURE_AUTH_SALT', 'Eexii8gi9eguu1ethahn1choonaerai6Jacai2liiCoo2ahkaiyahboo8xaeSheiz');
define('LOGGED_IN_SALT',   'ohng6eizai1muujijenooGhi9Foh8Iediek9Pha9geenee7oox7aetee3Up4if7ce');
define('NONCE_SALT',       'too6BieSheichei3ieteheeTheoc3Aixaith6EishaicohPhohloof8aid9shienu');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
