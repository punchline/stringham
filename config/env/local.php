<?php

define('WP_HOME', 'http://localhost/stringham');
define('WP_SITEURL', WP_HOME.'/wordpress');

define('WP_CONTENT_DIR', APP_ROOT.'/content');
define('WP_CONTENT_URL', WP_HOME.'/content');


// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'stringham');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost:3306');

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
define('AUTH_KEY',         'lij;8|i*,PcvtlXsSit8@<uP?9:On3k|a#8^/q-9k?kG!yq;Tm#{C}px&ie^Xg}t');
define('SECURE_AUTH_KEY',  ' f{PRu0fuh>V-6(gnim/3}<O;BzeKVuuZ(i=VSK|Kcfq:Wa{;,e&U!jkqznTGi-$');
define('LOGGED_IN_KEY',    'B=O|I+7A(lxRf{tiYhSK&ApOfrlM?%` UV~%99FG(edB{KuXCKe(@![A7He=-F|[');
define('NONCE_KEY',        '1)a&5%@C^/&1+2X2>%Jln5/xGJEP*0-.Cxh2S^u0tn&!,NvZ1;AHra|o9,vjqE_E');
define('AUTH_SALT',        'O?/gC1%(QJ{|2m7NoPf2e14`mu*.UZ&u]Q#;+fo-h:~WcX+ FvZnNFL4.zY~P66<');
define('SECURE_AUTH_SALT', '@~Z)Si6D8a-~b;^vNJ|Ml(2:(Nn%<D@~WlHj3M+]X#Dlql@NUB@km}0{{`)s,*}V');
define('LOGGED_IN_SALT',   'P-d%A.ij/k)x+s)+~rL>e-*KcV> 8R}`D=Pyf/k!AR<;vP/e(`j4;lL>G)~*QO,N');
define('NONCE_SALT',       '>6+AkM {ic{BA~@c _KjI-9e-ZZ-4AnwMrOBw>-JV^<,+;KkNZ1O@HoyJLMbUWL+');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/** Increase PHP Memory Limit **/
define( 'WP_MEMORY_LIMIT', '64M' );

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG',false);
