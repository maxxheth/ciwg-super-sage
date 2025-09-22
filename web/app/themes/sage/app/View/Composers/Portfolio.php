<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use WP_Query;
use Illuminate\Support\Facades\Vite;

class Portfolio extends Composer
{
    protected static $views = [
        'template-portfolio',
    ];

    public function with()
    {
        return [
            'pageData' => $this->getPortfolioPageData(),
            'categories' => $this->getPortfolioCategories(),
            'projects' => $this->getPortfolioProjects(),
            'featuredProject' => $this->getFeaturedProject(),
            'testimonials' => $this->getTestimonials(),
        ];
    }

    protected function getPortfolioPageData()
    {
        $post = get_post();

        // Default data
        $pageData = [
            'hero' => [
                'title'           => 'Our Portfolio',
                'subtitle'        => 'Showcasing excellence in landscape design and installation across Dallas-Fort Worth',
                'button_text'     => 'Request a Consultation',
                'button_url'      => '/contact',
                // 'background_image'=> '@asset("images/portfolio-hero-bg.jpg")',
                'background_image' => Vite::asset('resources/images/portfolio-hero-bg.jpg'),
            ],
            'intro' => [
                'title'    => 'Transforming Outdoor Spaces',
                'subtitle' => 'Browse our collection of commercial and residential landscaping projects',
                'content'  => '<p>For over three decades, Sandoval Landscaping has been creating exceptional outdoor environments 
                    across the Dallas-Fort Worth metroplex. Our portfolio showcases our commitment to quality, 
                    creativity, and sustainable landscape practices. Each project tells a unique story of 
                    collaboration with our clients to bring their vision to life.</p>',
            ],
        ];

        if ($post && function_exists('rwmb_meta')) {
            // Hero section fields
            $hero_title = rwmb_meta('hero_title', '', $post->ID);
            if (!empty($hero_title)) {
                $pageData['hero']['title'] = $hero_title;
            }
            
            $hero_subtitle = rwmb_meta('hero_subtitle', '', $post->ID);
            if (!empty($hero_subtitle)) {
                $pageData['hero']['subtitle'] = $hero_subtitle;
            }
            
            $hero_button_text = rwmb_meta('hero_button_text', '', $post->ID);
            if (!empty($hero_button_text)) {
                $pageData['hero']['button_text'] = $hero_button_text;
            }
            
            $hero_button_url = rwmb_meta('hero_button_url', '', $post->ID);
            if (!empty($hero_button_url)) {
                $pageData['hero']['button_url'] = $hero_button_url;
            }
            
            $hero_images = rwmb_meta('hero_background_image', ['size' => 'full'], $post->ID);
            if (!empty($hero_images) && is_array($hero_images)) {
                $hero_image = reset($hero_images);
                $pageData['hero']['background_image'] = $hero_image['url'];
            }

            // Introduction section fields
            $intro_title = rwmb_meta('intro_title', '', $post->ID);
            if (!empty($intro_title)) {
                $pageData['intro']['title'] = $intro_title;
            }
            
            $intro_subtitle = rwmb_meta('intro_subtitle', '', $post->ID);
            if (!empty($intro_subtitle)) {
                $pageData['intro']['subtitle'] = $intro_subtitle;
            }
            
            $intro_content = rwmb_meta('intro_content', '', $post->ID);
            if (!empty($intro_content)) {
                $pageData['intro']['content'] = $intro_content;
            }
        }

        return $pageData;
    }

    protected function getPortfolioCategories()
    {
        $terms = get_terms([
            'taxonomy' => 'category',
            'hide_empty' => true,
            'object_ids' => $this->getPortfolioItemIds(),
        ]);

        $categories = [
            'all' => 'All Projects'
        ];

        if (!is_wp_error($terms) && !empty($terms)) {
            foreach ($terms as $term) {
                $categories[$term->slug] = $term->name;
            }
        }

        return $categories;
    }

    protected function getPortfolioProjects()
    {
        $args = [
            'post_type' => 'portfolio-project',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
        ];

        // Exclude featured project if we have one set
        $featured_id = $this->getFeaturedProjectId();
        if ($featured_id) {
            $args['post__not_in'] = [$featured_id];
        }

        $query = new WP_Query($args);
        $projects = [];

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();
                
                // Get categories
                $categories = get_the_category();
                $category = !empty($categories) ? $categories[0]->name : '';
                $category_slug = !empty($categories) ? $categories[0]->slug : '';
                
                // Get meta data if Meta Box is being used
                $location = '';
                $description = get_the_excerpt();
                $url = get_permalink();
                $image = get_the_post_thumbnail_url($post_id, 'large') ?: '@asset("images/projects/placeholder.jpg")';
                $completion_date = '';
                $client = '';
                $project_size = '';
                
                if (function_exists('rwmb_meta')) {
                    $location = rwmb_meta('project_location', '', $post_id) ?: '';
                    
                    // If a custom description field exists
                    $custom_description = rwmb_meta('project_short_description', '', $post_id);
                    if (!empty($custom_description)) {
                        $description = $custom_description;
                    }
                    
                    // Get completion date
                    $completion_date = rwmb_meta('project_completion_date', '', $post_id) ?: '';
                    
                    // Get client name
                    $client = rwmb_meta('project_client', '', $post_id) ?: '';
                    
                    // Get project size
                    $project_size = rwmb_meta('project_size', '', $post_id) ?: '';
                }
                
                $projects[] = [
                    'title' => get_the_title(),
                    'category' => $category,
                    'category_slug' => $category_slug,
                    'location' => $location,
                    'description' => $description,
                    'image' => $image,
                    'url' => $url,
                    'completion_date' => $completion_date,
                    'client' => $client, 
                    'project_size' => $project_size,
                ];
            }
            wp_reset_postdata();
        }

        return $projects;
    }

    protected function getFeaturedProject()
    {
        $featured_id = $this->getFeaturedProjectId();
        
        if (!$featured_id) {
            // Return default featured project if none is set
            return [
                'title' => 'Legacy West Corporate Campus',
                'category' => 'Corporate',
                'location' => 'Plano, TX',
                'description' => 'A comprehensive landscape redesign for this 15-acre corporate headquarters featuring sustainable native plantings, water-efficient irrigation systems, and custom outdoor collaboration spaces.',
                'services' => ['Landscape Design', 'Installation', 'Irrigation', 'Ongoing Maintenance'],
                'image' => '@asset("images/projects/legacy-west-feature.jpg")',
                'gallery' => [
                    '@asset("images/projects/legacy-west-1.jpg")',
                    '@asset("images/projects/legacy-west-2.jpg")',
                    '@asset("images/projects/legacy-west-3.jpg")',
                    '@asset("images/projects/legacy-west-4.jpg")'
                ],
                'url' => '#',
                'completion_date' => '',
                'client' => '',
                'project_size' => '',
            ];
        }
        
        // Get the featured project data
        $post = get_post($featured_id);
        
        if (!$post) {
            return [];
        }
        
        // Get categories
        $categories = get_the_category($featured_id);
        $category = !empty($categories) ? $categories[0]->name : '';
        
        // Default values
        $featured = [
            'title' => $post->post_title,
            'category' => $category,
            'location' => '',
            'description' => $post->post_excerpt ?: wp_trim_words($post->post_content, 30),
            'services' => [],
            'image' => get_the_post_thumbnail_url($featured_id, 'large') ?: '@asset("images/projects/placeholder.jpg")',
            'gallery' => [],
            'url' => get_permalink($featured_id),
            'completion_date' => '',
            'client' => '',
            'project_size' => '',
        ];
        
        // Get custom fields if Meta Box is being used
        if (function_exists('rwmb_meta')) {
            $featured['location'] = rwmb_meta('project_location', '', $featured_id) ?: '';
            
            // Get custom description if available
            $custom_description = rwmb_meta('project_description', '', $featured_id);
            if (!empty($custom_description)) {
                $featured['description'] = $custom_description;
            }
            
            // Get services provided
            $services = rwmb_meta('project_services', '', $featured_id);
            if (!empty($services) && is_array($services)) {
                $featured['services'] = $services;
            }
            
            // Get gallery images
            $gallery_images = rwmb_meta('project_gallery', ['size' => 'large'], $featured_id);
            if (!empty($gallery_images) && is_array($gallery_images)) {
                foreach ($gallery_images as $image) {
                    $featured['gallery'][] = $image['url'];
                }
            }
            
            // Get additional fields
            $featured['completion_date'] = rwmb_meta('project_completion_date', '', $featured_id) ?: '';
            $featured['client'] = rwmb_meta('project_client', '', $featured_id) ?: '';
            $featured['project_size'] = rwmb_meta('project_size', '', $featured_id) ?: '';
        }
        
        return $featured;
    }

    protected function getFeaturedProjectId()
    {
        // First check if a project is set as featured in the portfolio page
        $portfolio_page = get_page_by_path('portfolio');
        $featured_id = 0;
        
        if ($portfolio_page && function_exists('rwmb_meta')) {
            $featured_id = rwmb_meta('featured_project', '', $portfolio_page->ID);
        }
        
        // If no project is explicitly set as featured on the page, 
        // get the most recent portfolio item with a "featured" flag
        if (!$featured_id) {
            $args = [
                'post_type' => 'portfolio-project',
                'posts_per_page' => 1,
                'post_status' => 'publish',
                'meta_key' => 'is_featured',
                'meta_value' => '1',
            ];
            
            $query = new WP_Query($args);
            
            if ($query->have_posts()) {
                $query->the_post();
                $featured_id = get_the_ID();
                wp_reset_postdata();
            } else {
                // If no featured project found, get the most recent one
                $args = [
                    'post_type' => 'portfolio-project',
                    'posts_per_page' => 1,
                    'post_status' => 'publish',
                ];
                
                $query = new WP_Query($args);
                
                if ($query->have_posts()) {
                    $query->the_post();
                    $featured_id = get_the_ID();
                    wp_reset_postdata();
                }
            }
        }
        
        return $featured_id;
    }

    protected function getPortfolioItemIds()
    {
        $args = [
            'post_type' => 'portfolio-project',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'post_status' => 'publish',
        ];
        
        $query = new WP_Query($args);
        return $query->posts;
    }

    protected function getTestimonials()
    {
        $post = get_post();
        $testimonials = [
            [
                'quote' => 'Sandoval Landscaping transformed our corporate campus into an inspiring outdoor environment that our employees love. Their attention to detail and commitment to sustainability aligned perfectly with our company values.',
                'author' => 'Jennifer Richards',
                'position' => 'Facilities Director, Tech Innovations Inc.'
            ],
            [
                'quote' => 'The team at Sandoval exceeded our expectations for our municipal park renovation. They completed the project on time and on budget, and the public response has been overwhelmingly positive.',
                'author' => 'Michael Torres',
                'position' => 'Parks & Recreation Director, City of Dallas'
            ]
        ];

        if ($post && function_exists('rwmb_meta')) {
            $quotes = rwmb_meta('testimonial_quote', '', $post->ID);
            if (!empty($quotes) && is_array($quotes)) {
                $testimonials = [];
                foreach ($quotes as $index => $quote) {
                    $testimonials[] = [
                        'quote' => $quote,
                        'author' => rwmb_meta('testimonial_author', '', $post->ID)[$index] ?? '',
                        'position' => rwmb_meta('testimonial_position', '', $post->ID)[$index] ?? '',
                    ];
                }
            }
        }

        return $testimonials;
    }
}