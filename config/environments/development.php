<?php

/**
 * Configuration overrides for WP_ENV === 'development'
 */

use Roots\WPConfig\Config;

use function Env\env;

Config::define('SAVEQUERIES', true);
Config::define('WP_DEBUG', true);
Config::define('WP_DEBUG_DISPLAY', true);
Config::define('WP_DEBUG_LOG', env('WP_DEBUG_LOG') ?? true);
Config::define('WP_DISABLE_FATAL_ERROR_HANDLER', true);
Config::define('SCRIPT_DEBUG', true);
Config::define('DISALLOW_INDEXING', true);

ini_set('display_errors', '1');

// Enable plugin and theme updates and installation from the admin
Config::define('DISALLOW_FILE_MODS', false);

// Increase memory limit for WordPress

Config::define('WP_MEMORY_LIMIT', '256M'); // Increase memory limit for WordPress
Config::define('WP_MAX_MEMORY_LIMIT', '512M'); // Increase max memory limit for admin tasks
Config::define('BIG_IMAGE_SIZE_THRESHOLD', false); // Disable WordPress image size limit
