<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class LocationService extends Composer
{
    protected static $views = [
        'template-location-service',
    ];

    public function with()
    {
        $data = $this->getInheritedServiceData();
        return [
            'service'  => $data['service'],
            'location' => $data['location'],
        ];
    }

    protected function getInheritedServiceData()
    {
        $location_service_post = get_post();
        $serviceData = [];
        $location = null;

        if ($location_service_post && function_exists('rwmb_meta')) {
            $base_service_id = rwmb_meta('base_service', '', $location_service_post->ID);
            $location_id = rwmb_meta('related_location', '', $location_service_post->ID);

            if ($location_id) {
                $location = get_post($location_id);
            }

            if ($base_service_id) {
                // Inherit all data from the base service post
                $serviceData['title'] = get_the_title($base_service_id);
                $serviceData['description'] = rwmb_meta('service_description', '', $base_service_id);
                $serviceData['content'] = rwmb_meta('service_content', '', $base_service_id);
                
                $hero_images = rwmb_meta('service_hero_image', ['size' => 'full'], $base_service_id);
                if (!empty($hero_images)) {
                    $serviceData['hero_image'] = reset($hero_images)['url'];
                }

                $serviceData['features'] = rwmb_meta('service_features', '', $base_service_id);
                $serviceData['process']['section_title'] = rwmb_meta('process_section_title', '', $base_service_id);
                $serviceData['process']['section_subtitle'] = rwmb_meta('process_section_subtitle', '', $base_service_id);
                $serviceData['process']['steps'] = rwmb_meta('process_steps', '', $base_service_id);
                
                $related_ids = rwmb_meta('related_services', '', $base_service_id);
                if (!empty($related_ids) && is_array($related_ids)) {
                    $serviceData['related_services'] = array_map(function ($related_id) {
                        $hero_images = rwmb_meta('service_hero_image', ['size' => 'medium'], $related_id);
                        $image_url = !empty($hero_images) ? reset($hero_images)['url'] : asset('images/placeholder.jpg');
                        return [
                            'title' => get_the_title($related_id),
                            'url'   => get_permalink($related_id),
                            'image' => $image_url,
                        ];
                    }, $related_ids);
                }
            }

            // Override with location-specific data if it exists
            $serviceData['title'] = get_the_title($location_service_post); // Always use the LocationService title

            $description_override = rwmb_meta('service_description_override', '', $location_service_post->ID);
            if ($description_override) {
                $serviceData['description'] = $description_override;
            }

            $content_override = rwmb_meta('service_content_override', '', $location_service_post->ID);
            if ($content_override) {
                $serviceData['content'] = $content_override;
            } else {
                // If no content override, use the main editor of the location_service post
                $serviceData['content'] = apply_filters('the_content', $location_service_post->post_content);
            }

            $hero_override = rwmb_meta('service_hero_image_override', ['size' => 'full'], $location_service_post->ID);
            if (!empty($hero_override)) {
                $serviceData['hero_image'] = reset($hero_override)['url'];
            }
        }

        return ['service' => $serviceData, 'location' => $location];
    }
}