<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use WP_Query;

class FeaturedProject extends Composer
{
    /**
     * List of views served by this composer.
     * Adjust this if your featured projects section is in a specific partial.
     *
     * @var array
     */
    protected static $views = [
        'index', // Assumes featured projects are on the main index page
        // 'partials.featured-projects', // Or if it's in a partial
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'featured_projects' => $this->getFeaturedProjects(),
        ];
    }

    /**
     * Retrieves featured project data.
     *
     * @return array
     */
    protected function getFeaturedProjects()
    {
        $args = [
            'post_type'      => 'featured-project',
            'posts_per_page' => -1, // Adjust limit as needed, -1 for all
            'post_status'    => 'publish',
            'orderby'        => 'meta_value_num',
            'meta_key'       => 'featured_project_order',
            'order'          => 'ASC',
        ];

        $query = new WP_Query($args);
        $projects = [];

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $project_id = get_the_ID();
                $project_data = [];

                $project_data['title'] = get_the_title();
                $project_data['image'] = get_the_post_thumbnail_url($project_id, 'large') ?: ''; // Use theme's placeholder

                // Get custom fields if Meta Box is active
                if (function_exists('rwmb_meta')) {
                    $project_data['category'] = rwmb_meta('featured_project_category', '', $project_id) ?: '';
                    $project_data['description'] = rwmb_meta('featured_project_description', '', $project_id) ?: '';
                    $linked_post_id = rwmb_meta('featured_project_link', '', $project_id);
                    $project_data['link'] = $linked_post_id ? get_permalink($linked_post_id) : '#'; // Get permalink or default to '#'
                } else {
                    // Fallbacks if Meta Box isn't active
                    $project_data['category'] = '';
                    $project_data['description'] = get_the_excerpt(); // Use excerpt as fallback description
                    $project_data['link'] = '#';
                }

                $projects[] = $project_data;
            }
            wp_reset_postdata();
        }

        return $projects;
    }
}