<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use WP_Query;

class PortfolioProject extends Composer
{
    protected static $views = [
        'template-portfolio-project',
    ];

    public function with()
    {
        return [
            'project' => $this->getProjectData(),
            'related_projects' => $this->getRelatedProjects(),
        ];
    }

    protected function getProjectData()
    {
        $post = get_post();
        
        if (!$post) {
            return [];
        }

        // Get categories
        $categories = get_the_category($post->ID);
        $category = !empty($categories) ? $categories[0]->name : '';
        $category_slug = !empty($categories) ? $categories[0]->slug : '';
        
        // Set up default project data
        $project = [
            'title' => $post->post_title,
            'category' => $category,
            'category_slug' => $category_slug,
            'description' => get_the_content(),
            'image' => get_the_post_thumbnail_url($post->ID, 'large') ?: '@asset("images/projects/placeholder.jpg")',
            'gallery' => [],
            'location' => '',
            'services' => [],
            'client' => '',
            'project_size' => '',
            'completion_date' => '',
            'challenges' => '',
            'solutions' => '',
            'design_approach' => '',
            'materials' => '',
            'results' => '',
            'client_testimonial' => '',
            'client_testimonial_author' => '',
            'client_testimonial_position' => '',
        ];
        
        // Get custom fields if Meta Box is being used
        if (function_exists('rwmb_meta')) {
            // Basic project information
            $project['location'] = rwmb_meta('project_location', '', $post->ID) ?: '';
            $project['client'] = rwmb_meta('project_client', '', $post->ID) ?: '';
            $project['project_size'] = rwmb_meta('project_size', '', $post->ID) ?: '';
            $project['completion_date'] = rwmb_meta('project_completion_date', '', $post->ID) ?: '';
            
            // Services provided
            $services = rwmb_meta('project_services', '', $post->ID);
            if (!empty($services) && is_array($services)) {
                $project['services'] = $services;
            }
            
            // Gallery images
            $gallery_images = rwmb_meta('project_gallery', ['size' => 'large'], $post->ID);
            if (!empty($gallery_images) && is_array($gallery_images)) {
                foreach ($gallery_images as $image) {
                    $project['gallery'][] = $image['url'];
                }
            }
            
            // Project details sections
            $project['challenges'] = rwmb_meta('project_challenges', '', $post->ID) ?: '';
            $project['solutions'] = rwmb_meta('project_solutions', '', $post->ID) ?: '';
            $project['design_approach'] = rwmb_meta('project_design_approach', '', $post->ID) ?: '';
            $project['materials'] = rwmb_meta('project_materials', '', $post->ID) ?: '';
            $project['results'] = rwmb_meta('project_results', '', $post->ID) ?: '';
            
            // Client testimonial
            $project['client_testimonial'] = rwmb_meta('project_testimonial', '', $post->ID) ?: '';
            $project['client_testimonial_author'] = rwmb_meta('project_testimonial_author', '', $post->ID) ?: '';
            $project['client_testimonial_position'] = rwmb_meta('project_testimonial_position', '', $post->ID) ?: '';
        }
        
        return $project;
    }

    protected function getRelatedProjects($limit = 3)
    {
        $post = get_post();
        
        if (!$post) {
            return [];
        }
        
        // Get current project's categories
        $categories = get_the_category($post->ID);
        $category_ids = [];
        
        if (!empty($categories)) {
            foreach ($categories as $category) {
                $category_ids[] = $category->term_id;
            }
        }
        
        // Query arguments
        $args = [
            'post_type' => 'portfolio-project',
            'posts_per_page' => $limit,
            'post_status' => 'publish',
            'post__not_in' => [$post->ID], // Exclude current project
            'orderby' => 'rand', // Randomize results
        ];
        
        // Add category filter if we have categories
        if (!empty($category_ids)) {
            $args['category__in'] = $category_ids;
        }
        
        $query = new WP_Query($args);
        $related_projects = [];
        
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $related_id = get_the_ID();
                
                // Get categories
                $project_categories = get_the_category();
                $category = !empty($project_categories) ? $project_categories[0]->name : '';
                
                $related_projects[] = [
                    'title' => get_the_title(),
                    'category' => $category,
                    'location' => function_exists('rwmb_meta') ? rwmb_meta('project_location', '', $related_id) : '',
                    'description' => get_the_excerpt(),
                    'image' => get_the_post_thumbnail_url($related_id, 'large') ?: '@asset("images/projects/placeholder.jpg")',
                    'url' => get_permalink(),
                ];
            }
            wp_reset_postdata();
        }
        
        return $related_projects;
    }
}