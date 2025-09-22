<?php

namespace App\PostTypes;

use App\Contracts\PostTypeTemplate;

class LocationService implements PostTypeTemplate
{
    public function __construct()
    {
        add_filter('post_type_link', [$this, 'customPostTypeLink'], 10, 2);
        add_action('init', [$this, 'addRewriteRules']);
        add_filter('theme_location_service_templates', [$this, 'addCustomTemplates'], 10, 4);
    }

    public function addCustomTemplates($post_templates, $wp_theme, $post, $post_type)
    {
        $theme_dir = $wp_theme->get_template_directory();
        $template_dir = $theme_dir . '/resources/views';
        $service_templates = [
            "$template_dir/template-location-service.blade.php" => 'Location Service',
        ];

        $merged_data = array_merge($post_templates, $service_templates);
        var_dump(['merged_data' => $merged_data]);
        return $merged_data;
    }

    public function addRewriteRules()
    {
        add_rewrite_tag('%location%', '([^/]+)');
        // add_rewrite_tag('%service%', '([^/]+)');
        add_rewrite_rule('^([^/]+)/?$', 'index.php?location=$matches[1]', 'top');
    }

    public function customPostTypeLink($link, $post)
    {
        if ('location_service' === $post->post_type) {
            $location_id = get_post_meta($post->ID, 'related_location', true);
            if ($location_id) {
                $location = get_post($location_id);
                if ($location) {
                    $link = str_replace('%location%', $location->post_name, $link);
                }
            }
            // Use the location_service slug for the service part
            // $link = str_replace('%service%', $post->post_name, $link);
        }
        return $link;
    }

    public function getPostType(): string
    {
        return 'location_service';
    }

    public function getConfig(): array
    {
        return [
            'label'               => esc_html__('Location Services', 'sage'),
            'public'              => true,
            'hierarchical'        => false,
            'show_in_rest'        => true,
            'has_archive'         => false,
            'rewrite'             => ['slug' => '%location%', 'with_front' => false],
            'menu_icon'           => 'dashicons-admin-site-alt3',
            'supports'            => ['title', 'editor', 'thumbnail', 'template'],
            'taxonomies'          => [],
        ];
    }
}