<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use Illuminate\Support\Facades\Vite;

class Services extends Composer
{
    protected static $views = [
        'template-services',
    ];

    public function with()
    {
        return [
            'pageData' => $this->getServicesPageData(),
            'serviceCategories' => $this->getServiceCategories(),
            'detailedServices' => $this->getDetailedServices(),
            'testimonials' => $this->getTestimonials(),
            'faqs' => $this->getFaqs(),
        ];
    }

    protected function getServicesPageData()
    {
        $post = get_post();

        // Default data
        $pageData = [
            'hero' => [
                'title'           => 'Our Landscaping Services',
                'subtitle'        => 'Professional solutions for your residential and commercial landscaping needs',
                'button_text'     => 'Our Services',
                'button_url'      => '#services',
                'background_image' => Vite::asset('resources/images/skyline-terrace-rooftop-garden.webp'),
            ],
            'intro' => [
                'title'    => 'Comprehensive Landscaping Solutions',
                'subtitle' => 'At Sandoval Landscaping, we offer a complete range of services to transform and maintain your outdoor spaces.',
                'content'  => '<p>For over three decades ...</p>',
                'image'    => Vite::asset('resources/images/prepared-yard.webp'),
            ],
        ];

        if ($post && function_exists('rwmb_meta')) {
            // Hero section fields (flattened)
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

            // Introduction section fields (flattened)
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
            $intro_images = rwmb_meta('intro_image', ['size' => 'full'], $post->ID);
            if (!empty($intro_images) && is_array($intro_images)) {
                $intro_image = reset($intro_images);
                $pageData['intro']['image'] = $intro_image['url'];
            }
        }

        return $pageData;
    }

    protected function getServiceCategories()
    {
        $post = get_post();
        // Default service categories
        $categories = [
            [
                'title'    => 'Design Services',
                'subtitle' => 'Professional landscape design to realize your vision',
                'description' => 'Our design services create the foundation for beautiful landscapes …',
                'url'      => '/services/design',
                'image'    => '@asset("images/service-design.jpg")',
            ],
            // ...additional defaults
        ];

        if ($post && function_exists('rwmb_meta')) {
            // Now using flattened field keys (for example, using clone if multiple entries)
            // If you saved multiple categories using cloned fields, they would be returned as arrays.
            $cat_titles = rwmb_meta('service_category_title', '', $post->ID);
            if (!empty($cat_titles) && is_array($cat_titles)) {
                $categories = [];
                foreach ($cat_titles as $index => $title) {
                    $categories[] = [
                        'title'       => $title,
                        'subtitle'    => rwmb_meta('service_category_subtitle', '', $post->ID)[$index] ?? '',
                        'description' => rwmb_meta('service_category_description', '', $post->ID)[$index] ?? '',
                        'url'         => rwmb_meta('service_category_url', '', $post->ID)[$index] ?? '',
                        'image'       => (function() use ($post, $index) {
                            $imgs = rwmb_meta('service_category_image', ['size' => 'full'], $post->ID);
                            if (!empty($imgs) && isset($imgs[$index]) && !empty($imgs[$index])) {
                                return reset($imgs[$index])['url'] ?? '@asset("images/service-placeholder.jpg")';
                            }
                            return '@asset("images/service-placeholder.jpg")';
                        })(),
                    ];
                }
            }
        }

        return $categories;
    }

    protected function getDetailedServices()
    {
        // Default detailed services (fallback)
        $default_services = [
            [
                'title'       => 'Landscape Design',
                'subtitle'    => 'Transform your outdoor space',
                'description' => 'Comprehensive design plans tailored to your property and preferences.',
                'url'         => '/services/landscape-design',
                'image'       => Vite::asset('resources/images/manicured-front-yard.webp'),
            ],
            [
                'title'       => 'Garden Installation',
                'subtitle'    => 'Bring your landscape to life',
                'description' => 'Expert planting and installation services for gardens of all sizes.',
                'url'         => '/services/garden-installation',
                'image'       => Vite::asset('resources/images/residential-garden.webp'),
            ],
        ];

        // Query actual Service post type entries
        $args = [
            'post_type'      => 'service',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ];

        $query = new \WP_Query($args);
        
        if (!$query->have_posts()) {
            // Return default services if no service posts found
            return $default_services;
        }

        // Convert service posts to array format
        $services = [];
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            
            // Get service subtitle (from meta field if available)
            $subtitle = '';
            if (function_exists('rwmb_meta')) {
                $subtitle = rwmb_meta('service_subtitle', '', $post_id);
            }
            
            // Get service description (either excerpt or truncated content)
            $description = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 30);
            
            // Get featured image
            $image = rwmb_meta('service_hero_image', '', $post_id);

            $flattened_image_array = array_values($image)[0] ?? [];
            
            if (has_post_thumbnail()) {
                $image_id = get_post_thumbnail_id();
                $image_data = wp_get_attachment_image_src($image_id, 'large');
                if ($image_data) {
                    $image = $image_data[0];
                }
            }
            
            $services[] = [
                'id'          => $post_id,
                'title'       => get_the_title(),
                'subtitle'    => $subtitle,
                'description' => $description,
                'url'         => get_permalink(),
                'image'       => $flattened_image_array['full_url'] ?? '@asset("images/service-placeholder.jpg")',
            ];
        }
        wp_reset_postdata();
        
        return !empty($services) ? $services : $default_services;
    }

    protected function getTestimonials()
    {
        $post = get_post();
        $testimonials = [
            [
                'quote'    => 'The team at Sandoval completely transformed our backyard …',
                'author'   => 'Rebecca Thompson',
                'position' => 'Residential Client',
            ],
            // ...additional defaults
        ];

        if ($post && function_exists('rwmb_meta')) {
            $quotes = rwmb_meta('testimonial_quote', '', $post->ID);
            if (!empty($quotes) && is_array($quotes)) {
                $testimonials = [];
                foreach ($quotes as $index => $quote) {
                    $testimonials[] = [
                        'quote'    => $quote,
                        'author'   => rwmb_meta('testimonial_author', '', $post->ID)[$index] ?? '',
                        'position' => rwmb_meta('testimonial_position', '', $post->ID)[$index] ?? '',
                    ];
                }
            }
        }

        return $testimonials;
    }


    protected function getFaqs()
    {
        // Query for service-faq post type
        $args = [
            'post_type' => 'service-faq',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
        ];
        
        // If we're on a single service page, filter FAQs by related service
        $post = get_post();
        if ($post && $post->post_type === 'service') {
            // Add meta_query to filter by service-specific FAQs
            $service_id = $post->ID;
            
            // Check if there are service-specific FAQs first
            $specific_args = $args;
            $specific_args['meta_query'] = [
                [
                    'key' => 'related_service',
                    'value' => $service_id,
                    'compare' => '='
                ]
            ];
            
            $specific_query = new \WP_Query($specific_args);
            
            // Only apply the filter if there are service-specific FAQs
            if ($specific_query->have_posts()) {
                $args = $specific_args;
            }
            wp_reset_postdata();
        }
        
        $query = new \WP_Query($args);
        
        if (!$query->have_posts()) {
            // Return default FAQs if none found
            return [
                [
                    'question' => 'How much does a landscape design cost?',
                    'answer' => 'Design fees vary based on property size and project complexity. For residential properties, designs typically range from $1,500-$5,000.'
                ],
                [
                    'question' => 'How long does the design process take?',
                    'answer' => 'Most landscape designs are completed within 3-6 weeks from initial consultation to final design. Complex projects may take longer.'
                ],
                [
                    'question' => 'Do I need a design before installation?',
                    'answer' => 'While not required for small projects, a professional design is highly recommended for comprehensive landscape renovations.'
                ],
                [
                    'question' => 'Can you work with my existing landscape?',
                    'answer' => 'Absolutely. We can create designs that incorporate existing elements you wish to keep, gradually transforming your landscape in phases.'
                ]
            ];
        }
        
        // Convert posts to FAQ array
        $faqs = [];
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            
            // Get related services if available (for debugging/filtering)
            $related_service_id = null;
            if (function_exists('rwmb_meta')) {
                $related_service_id = rwmb_meta('related_service', '', $post_id);
            }
            
            // Get FAQ categories
            $categories = wp_get_post_terms($post_id, 'service-faq-category', ['fields' => 'all']);
            $category_names = !is_wp_error($categories) ? wp_list_pluck($categories, 'name') : [];
            
            $faqs[] = [
                'id' => $post_id,
                'question' => get_the_title(),
                'answer' => get_the_content(),
                'categories' => $category_names,
                'related_service_id' => $related_service_id
            ];
        }
        wp_reset_postdata();
        
        // Sort FAQs by categories if needed
        if (!empty($faqs)) {
            // Optional: Sort by specific category order
            // This example sorts general questions first, then specific categories
            usort($faqs, function($a, $b) {
                // Check if 'General' category exists in both
                $a_has_general = in_array('General', $a['categories']);
                $b_has_general = in_array('General', $b['categories']);
                if ($a_has_general && !$b_has_general) {
                    return -1;
                } elseif (!$a_has_general && $b_has_general) {
                    return 1;
                }
                
                // Default to keeping original order
                return 0;
            });
        }
        
        return $faqs;
    }
}