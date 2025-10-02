<?php
/**
 * @package WPSEO\Frontend
 */

/**
 * Main frontend class for Yoast SEO, responsible for the SEO output as well as removing
 * default WordPress output.
 */
class WPSEO_Frontend_To_REST_API extends WPSEO_Frontend {
    /**
     * Hold the instance of this class
     * @var WPSEO_Frontend_To_REST_API
     */
    private static $local_instance = null;

    /**
     * Get the singleton instance of this class
     *
     * @return WPSEO_Frontend_To_REST_API
     */
    public static function get_instance() {
        if (self::$local_instance === null) {
            self::$local_instance = new self();
        }
        return self::$local_instance;
    }

    /**
     * Constructor
     */
    protected function __construct() {
        parent::__construct();
    }
}