<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * This has been slightly modified (to read environment variables) for use in Docker.
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// IMPORTANT: this file needs to stay in-sync with https://github.com/WordPress/WordPress/blob/master/wp-config-sample.php
// (it gets parsed by the upstream wizard in https://github.com/WordPress/WordPress/blob/f27cb65e1ef25d11b535695a660e7282b98eb742/wp-admin/setup-config.php#L356-L392)

// a helper function to lookup "env_FILE", "env", then fallback
if (!function_exists('getenv_docker')) {
    // https://github.com/docker-library/wordpress/issues/588 (WP-CLI will load this file 2x)
    function getenv_docker($env, $default) {
        if ($fileEnv = getenv($env . '_FILE')) {
            return rtrim(file_get_contents($fileEnv), "\r\n");
        }
        else if (($val = getenv($env)) !== false) {
            return $val;
        }
        else {
            return $default;
        }
    }
}

# Database Configuration
define( 'DB_NAME', getenv_docker('WORDPRESS_DB_NAME', 'wordpress') );
define( 'DB_USER', getenv_docker('WORDPRESS_DB_USER', 'wordpress') );
define( 'DB_PASSWORD', getenv_docker('WORDPRESS_DB_PASSWORD', 'wordpress') );
define( 'DB_HOST', getenv_docker('WORDPRESS_DB_HOST', 'localhost') );
define( 'DB_CHARSET', 'utf8');
define( 'DB_COLLATE', '');

# Redis Caching
define('WP_REDIS_HOST', 'redis');
define('WP_REDIS_PORT', 6379);
define('WP_REDIS_DATABASE', getenv_docker('REDIS_DB_INDEX', 0));
define('WP_REDIS_PREFIX', 'site_' . getenv_docker('WORDPRESS_DB_NAME', '') . '_');


$table_prefix = getenv_docker('WORDPRESS_DB_PREFIX', 'wp_');

# Security Salts, Keys, Etc
define('AUTH_KEY',         'XPtNAVTl(Dk~_a=F5$AaCL9}P~*y.!yqQxJst<GM7#$?]<:~.ZxcW<t/6&Wwa#L|');
define('SECURE_AUTH_KEY',  'Za00emj4`bWOX )U:GgB.9,q}+qjLvp Zdj]t{+D_DF7/jRsS&+DjnmiSrd<Wyey');
define('LOGGED_IN_KEY',    'iyU$^RlQ=~_o{oNN1.teU[@A+.5!|F:<st/#7P=i%cqL~wTw2(?E$M{sUE9gDjuf');
define('NONCE_KEY',        '-9_pX[kn_H+x-f<1RHK0|7GL1D|YnzcEpl?NtF475J/}:1hc-(^FW3|pwE+O!o.]');
define('AUTH_SALT',        'O+3tB=e tZ>w@ygxybsyP~oa}Cj&e/@m%6$}k YFG1]7`K+;xSyBn6Nrhln6w#cF');
define('SECURE_AUTH_SALT', 'T-A9HoK z57LgD!}?>&Y)wWnjHqjl+Vh$Cp$p<rQBMD[`MKY,edOf-no-F9P>tA{');
define('LOGGED_IN_SALT',   'cV{f#Y~- *4`-<1=osabFEz!s6woUIEX+(,WPl(T-Xq}LSnAt|e7T(|WSLo[tD3r');
define('NONCE_SALT',       'Ku)pb5}p+C]NG_[]NlTq@dpNX-]$KI%|rvs551-Y=|Wgis)IFuWH7>/kUxhGqy3O');

define('WP_HOME', getenv_docker('WP_HOME', 'http://localhost:8080'));
define('WP_SITEURL', getenv_docker('WP_HOME', 'http://localhost:8080'));


// If we're behind a proxy server and using HTTPS, we need to alert WordPress of that fact
// see also https://wordpress.org/support/article/administration-over-ssl/#using-a-reverse-proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
    $_SERVER['HTTPS'] = 'on';
}
// (we include this by default because reverse proxying is extremely common in container environments)

if ($configExtra = getenv_docker('WORDPRESS_CONFIG_EXTRA', '')) {
    eval($configExtra);
}

# Localized Language Stuff
define('WP_DEBUG', (getenv_docker('WP_DEBUG', 'true') === 'false' ? false : true) );
define('WP_CACHE', (getenv_docker('WP_CACHE', 'true') === 'true' ? true : false) );
define('WP_DEBUG_LOG', (getenv_docker('WP_DEBUG_LOG', 'true') === 'false' ? false : true) );
define('WP_DEBUG_DISPLAY', (getenv_docker('WP_DEBUG_DISPLAY', 'false') === 'false' ? false : true) );
define('SCRIPT_DEBUG', (getenv_docker('SCRIPT_DEBUG', 'true') === 'false' ? false : true) );

define('WP_MEMORY_LIMIT', getenv_docker('MEMORY_LIMIT', '1.5G'));
define('MEMORY_LIMIT', getenv_docker('MEMORY_LIMIT', '1.5G'));

error_reporting(E_WARNING | E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR | E_RECOVERABLE_ERROR);


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}


require_once(ABSPATH . 'wp-settings.php');
