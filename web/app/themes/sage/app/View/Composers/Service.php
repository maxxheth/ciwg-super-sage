<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use WP_Query;

class Service extends Composer
{
    protected static $views = [
        'template-service',
    ];

    public function with()
    {
        return [
            'service'           => $this->getServiceData(),
            'metaBox'           => $this->getMetaBoxData(),
            'serviceCategories' => $this->getServiceCategories(),
            'detailedServices'  => $this->getDetailedServices(),
            'testimonials'      => $this->getTestimonials(),
            'faqs'              => $this->getFaqs(),
        ];
    }

    protected function getServiceData()
    {
        $post = get_post();

        $serviceData = [
            'title'       => 'Landscape Design',
            'hero_image'  => asset('images/service-design-hero.webp'),
            'description' => 'Professional landscape design services …',
            'content'     => 'Our landscape design service creates …',
            'features'    => [
                [
                    'title'       => 'Custom Site Planning',
                    'description' => 'Comprehensive analysis …'
                ],
            ],
            'gallery'         => [
                '@asset("images/service-gallery-1.jpg")',
                '@asset("images/service-gallery-2.jpg")'
            ],
            'benefits'        => [
                'Increased property value',
                'Enhanced outdoor living'
            ],
            'related_services' => [
                [
                    'title' => 'Garden Planning',
                    'url'   => '/services/garden-planning',
                    'image' => '@asset("images/related-garden.jpg")'
                ],
            ],
            'type' => 'default',
            'process' => [
                'section_title' => 'Our Design Process',
                'section_subtitle' => 'How we create your perfect landscape design',
                'steps' => []
            ]
        ];

        if ($post && function_exists('rwmb_meta')) {
            $title = get_the_title($post);
            if ($title) {
                $serviceData['title'] = $title;
            }
            $description = rwmb_meta('service_description', '', $post->ID);
            if ($description) {
                $serviceData['description'] = $description;
            }
            $content = rwmb_meta('service_content', '', $post->ID);
            if ($content) {
                $serviceData['content'] = $content;
            }

            // Hero image (flattened)
            $hero_images = rwmb_meta('service_hero_image', ['size' => 'full'], $post->ID);
            if (!empty($hero_images) && is_array($hero_images)) {
                $hero_image = reset($hero_images);
                $serviceData['hero_image'] = $hero_image['url'];
            }

            // Replace the feature retrieval code with this:
            $service_features = rwmb_meta('service_features', '', $post->ID);
            if (!empty($service_features) && is_array($service_features)) {
                $serviceData['features'] = [];
                foreach ($service_features as $feature) {
                    $serviceData['features'][] = [
                        'title'       => $feature['title'] ?? '',
                        'description' => $feature['description'] ?? '',
                        'type'        => $feature['type'] ?? ''
                    ];
                }
            } else {
                // Fallback to default feature if no custom features are set
                $serviceData['features'] = [
                    [
                        'title'       => 'Custom Site Planning',
                        'description' => 'Comprehensive analysis of your property to create a tailored landscape design.'
                    ]
                ];
            }

            // Gallery
            $gallery_images = rwmb_meta('service_gallery', ['size' => 'large'], $post->ID);
            if (!empty($gallery_images) && is_array($gallery_images)) {
                $serviceData['gallery'] = array_map(function ($image) {
                    return $image['url'];
                }, $gallery_images);
            }

            // Benefits (assuming benefits are stored as a cloned text field)
            $benefits = rwmb_meta('service_benefits', '', $post->ID);
            if (!empty($benefits) && is_array($benefits)) {
                $serviceData['benefits'] = $benefits;
            }

            // Related services (using relationship field with flattened fields)
            $related_ids = rwmb_meta('related_services', '', $post->ID);
        
            if (!empty($related_ids) && is_array($related_ids)) {
                $serviceData['related_services'] = array_map(function ($related_id) {
                    $related_image = rwmb_meta('service_featured_image', ['size' => 'medium'], $related_id);
                    $image_url = (!empty($related_image) && is_array($related_image))
                        ? reset($related_image)['url']
                        : '@asset("images/placeholder.jpg")';

                    $image = null;
                    $hero_images = rwmb_meta('service_hero_image', ['size' => 'full'], $related_id);
                    if (!empty($hero_images) && is_array($hero_images)) {
                        $hero_image = reset($hero_images);
                        $image = $hero_image['url'];
                    }
                    return [
                        'title' => get_the_title($related_id),
                        'url'   => get_permalink($related_id),
                        'image' => !is_null($image) ? $image : $image_url,
                    ];
                }, $related_ids);

            }

            // Process section data
            $process_section_title = rwmb_meta('process_section_title', '', $post->ID);
            $process_section_subtitle = rwmb_meta('process_section_subtitle', '', $post->ID);
            
            if ($process_section_title) {
                $serviceData['process']['section_title'] = $process_section_title;
            }
            
            if ($process_section_subtitle) {
                $serviceData['process']['section_subtitle'] = $process_section_subtitle;
            }
            
            // Get steps directly from the service post
            $steps = rwmb_meta('process_steps', '', $post->ID);
            if (!empty($steps) && is_array($steps)) {
                $formattedSteps = [];
                
                foreach ($steps as $index => $step) {

                    $formattedSteps[] = [
                        'step_number' => array_key_exists('step_number', $step) ? (int) $step['step_number'] : ((int) $index + 1),
                        'title' => $step['step_title'] ?? '',
                        'description' => $step['step_description'] ?? '',
                        'icon_type' => $step['icon_type'] ?: 'default'
                    ];
                }
                
                // Sort steps by step number
                usort($formattedSteps, function ($a, $b) {
                    return $a['step_number'] - $b['step_number'];
                });
                
                $serviceData['process']['steps'] = $formattedSteps;
            } else {
                // Use default steps if none found
                $serviceData['process']['steps'] = [
                    [
                        'step_number' => 1,
                        'title' => 'Initial Consultation',
                        'description' => 'We meet with you to discuss your goals, preferences, and budget for your landscape project.',
                        'icon_type' => 'consultation'
                    ],
                    [
                        'step_number' => 2,
                        'title' => 'Site Analysis',
                        'description' => 'We thoroughly assess your property, including soil conditions, drainage, sun exposure, and existing features.',
                        'icon_type' => 'analysis'
                    ],
                    [
                        'step_number' => 3,
                        'title' => 'Concept Development',
                        'description' => 'Our designers create initial concepts based on your input and our site analysis.',
                        'icon_type' => 'design'
                    ],
                    [
                        'step_number' => 4,
                        'title' => 'Design Presentation',
                        'description' => 'We present detailed designs, including plans, 3D renderings, and plant selections for your review.',
                        'icon_type' => 'presentation'
                    ],
                    [
                        'step_number' => 5,
                        'title' => 'Refinement',
                        'description' => 'We incorporate your feedback and make revisions until the design perfectly matches your vision.',
                        'icon_type' => 'refinement'
                    ],
                    [
                        'step_number' => 6,
                        'title' => 'Final Design & Implementation',
                        'description' => 'We deliver complete design documents and can seamlessly transition to the installation phase.',
                        'icon_type' => 'implementation'
                    ]
                ];
            }

            
        }

        return $serviceData;
    }

    protected function getMetaBoxData()
    {
        $post = get_post();
        $metaBoxData = [
            'enabled'     => true,
            'heading'     => 'Expert Landscape Design Services',
            'content'     => 'Our award-winning design team …',
            'image'       => '@asset("images/design-team-at-work.jpg")',
            'button_text' => 'Meet Our Designers',
            'button_url'  => '/about-us#team',
            'background'  => 'bg-green-50',
            'text_color'  => 'text-green-800'
        ];

        if ($post && function_exists('rwmb_meta')) {
            $metaBoxData['enabled']     = rwmb_meta('meta_box_enabled', '', $post->ID) ?? true;
            $metaBoxData['heading']     = rwmb_meta('meta_box_heading', '', $post->ID) ?? $metaBoxData['heading'];
            $metaBoxData['content']     = rwmb_meta('meta_box_content', '', $post->ID) ?? $metaBoxData['content'];
            $images = rwmb_meta('meta_box_image', ['size' => 'full'], $post->ID);
            if (!empty($images) && is_array($images)) {
                $image = reset($images);
                $metaBoxData['image'] = $image['url'];
            }
            $metaBoxData['button_text'] = rwmb_meta('meta_box_button_text', '', $post->ID) ?? $metaBoxData['button_text'];
            $metaBoxData['button_url']  = rwmb_meta('meta_box_button_url', '', $post->ID) ?? $metaBoxData['button_url'];
            $metaBoxData['background']  = rwmb_meta('meta_box_background', '', $post->ID) ?? $metaBoxData['background'];
            $metaBoxData['text_color']  = rwmb_meta('meta_box_text_color', '', $post->ID) ?? $metaBoxData['text_color'];
        }

        return $metaBoxData;
    }

    protected function getServiceCategories()
    {
        // Get categories that are assigned to service posts
        $service_categories = [];

        // First get all services
        $services = get_posts([
            'post_type' => 'service',
            'posts_per_page' => -1,
            'fields' => 'ids' // Only get IDs for efficiency
        ]);

        // If we have services, get their categories
        if (!empty($services)) {
            // Get all categories used by service posts
            $categories = wp_get_object_terms($services, 'category');

            if (!is_wp_error($categories) && !empty($categories)) {
                // Convert terms to the expected array format
                $service_categories = array_map(function ($term) {
                    $image_id = get_term_meta($term->term_id, 'category_image', true);
                    $image = wp_get_attachment_image_url($image_id, 'medium');

                    return [
                        'title' => $term->name,
                        'subtitle' => get_term_meta($term->term_id, 'subtitle', true) ?? '',
                        'description' => $term->description,
                        'image' => $image ?: asset('images/placeholder.jpg'),
                        'url' => get_term_link($term)
                    ];
                }, $categories);
            }
        }

        // Return default categories if none found
        if (empty($service_categories)) {
            return [
                [
                    'title' => 'Landscape Design',
                    'subtitle' => 'Expert planning for beautiful landscapes',
                    'description' => 'Professional design services to transform your outdoor space',
                    'image' => asset('images/service-category-design.jpg'),
                    'url' => '/services/landscape-design'
                ],
                // ...other defaults
            ];
        }

        return $service_categories;
    }

    protected function getDetailedServices()
    {
        // Query for service post type
        $query = new WP_Query([
            'post_type' => 'service',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
        ]);

        if (!$query->have_posts()) {
            // Return default services if none found
            return [
                [
                    'title' => 'Landscape Design',
                    'subtitle' => 'Custom designs for your unique space',
                    'description' => 'Our landscape design services create functional, beautiful outdoor spaces tailored to your needs.',
                    'image' => asset('images/service-design.jpg'),
                    'url' => '/services/landscape-design'
                ],
                [
                    'title' => 'Garden Installation',
                    'subtitle' => 'Expert planting and setup',
                    'description' => 'Professional installation of gardens, plants, and landscape features.',
                    'image' => asset('images/service-installation.jpg'),
                    'url' => '/services/garden-installation'
                ]
                // Add more default services as needed
            ];
        }

        // Convert posts to service array
        $services = [];
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();

            // Get featured image or fallback
            $image = get_the_post_thumbnail_url($post_id, 'medium');
            if (!$image) {
                $image = asset('images/placeholder.jpg');
            }

            $services[] = [
                'title' => get_the_title(),
                'subtitle' => rwmb_meta('service_subtitle', '', $post_id) ?? '',
                'description' => rwmb_meta('service_description', '', $post_id) ?? get_the_excerpt(),
                'image' => $image,
                'url' => get_permalink($post_id)
            ];
        }
        wp_reset_postdata();

        return $services;
    }

    protected function getTestimonials()
    {
        // This could be replaced with a custom testimonial post type query
        return [
            [
                'quote' => 'The design team at Sandoval listened carefully to our needs and created a landscape plan that perfectly suits our lifestyle.',
                'author' => 'James & Maria Wilson',
                'position' => 'Residential Clients'
            ],
            [
                'quote' => 'As a commercial property owner, I appreciate Sandoval\'s thoughtful approach to design. They created a beautiful, low-maintenance landscape.',
                'author' => 'Robert Chen',
                'position' => 'Office Park Owner'
            ]
        ];
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

            $specific_query = new WP_Query($specific_args);

            // Only apply the filter if there are service-specific FAQs
            if ($specific_query->have_posts()) {
                $args = $specific_args;
            }
            wp_reset_postdata();
        }

        $query = new WP_Query($args);

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
            usort($faqs, function ($a, $b) {
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
