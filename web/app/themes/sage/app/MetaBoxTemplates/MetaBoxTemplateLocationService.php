<?php

namespace App\MetaBoxTemplates;

use App\Contracts\MetaBoxTemplate;

class MetaBoxTemplateLocationService implements MetaBoxTemplate
{
    public function getConfig(): array
    {
        return [
            'title'      => 'Location Service Details',
            'id'         => 'location_service_details',
            'post_types' => ['location_service'],
            'context'    => 'normal',
            'priority'   => 'high',
            'fields'     => [
                [
                    'name'      => 'Base Service',
                    'id'        => 'base_service',
                    'type'      => 'post',
                    'post_type' => 'service',
                    'field_type' => 'select_advanced',
                    'placeholder' => 'Select a base service',
                    'desc'      => 'Select the base service to inherit data from. Fields below will override the base service data.',
                    'required'  => true,
                ],
                [
                    'name'      => 'Related Location',
                    'id'        => 'related_location',
                    'type'      => 'post',
                    'post_type' => 'location',
                    'field_type' => 'select_advanced',
                    'placeholder' => 'Select a location',
                    'desc'      => 'Select the location for this service page.',
                    'required'  => true,
                ],
                [
                    'name' => 'Location-Specific Details',
                    'type' => 'heading',
                    'desc' => 'The fields below will override the data from the selected Base Service.',
                ],
                [
                    'name'  => 'Description Override',
                    'id'    => 'service_description_override',
                    'type'  => 'textarea',
                    'desc'  => 'Optional. Overrides the hero description from the base service.',
                ],
                [
                    'name'  => 'Content Override',
                    'id'    => 'service_content_override',
                    'type'  => 'wysiwyg',
                    'desc'  => 'Optional. Overrides the main content from the base service.',
                ],
                [
                    'name'  => 'Hero Image Override',
                    'id'    => 'service_hero_image_override',
                    'type'  => 'image_advanced',
                    'max_file_uploads' => 1,
                    'desc'  => 'Optional. Overrides the hero image from the base service.',
                ],
            ],
        ];
    }
}