<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (file_exists( WPMU_PLUGIN_DIR . '/malcare-security/malcare.php' ) ) {
	// Load MalCare Security plugin if it exists.
	require_once WPMU_PLUGIN_DIR . '/malcare-security/malcare.php';
}