<?php

/**
 * Configuration overrides for WP_ENV === 'staging'
 */

use Roots\WPConfig\Config;

use function Env\env;
/**
 * You should try to keep staging as close to production as possible. However,
 * should you need to, you can always override production configuration values
 * with `Config::define`.
 *
 * Example: `Config::define('WP_DEBUG', true);`
 * Example: `Config::define('DISALLOW_FILE_MODS', false);`
 */

Config::define("DISALLOW_INDEXING", true);
Config::define("FORCE_SSL_ADMIN", env("FORCE_SSL_ADMIN"));
Config::define("FORCE_SSL_LOGIN", env("FORCE_SSL_LOGIN"));

// Increase memory limit for WordPress

Config::define('WP_MEMORY_LIMIT', '256M'); // Increase memory limit for WordPress
Config::define('WP_MAX_MEMORY_LIMIT', '512M'); // Increase max memory limit for admin tasks
Config::define('BIG_IMAGE_SIZE_THRESHOLD', false); // Disable WordPress image size limit
