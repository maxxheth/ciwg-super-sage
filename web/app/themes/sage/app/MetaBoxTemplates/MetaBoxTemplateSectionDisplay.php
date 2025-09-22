<?php

namespace App\MetaBoxTemplates;

use App\Contracts\MetaBoxTemplate;

class MetaBoxTemplateSectionDisplay implements MetaBoxTemplate
{
    /**
     * Get the meta box configuration
     * 
     * @return array
     */
    public function getConfig(): array
    {
        return [
            'title'      => 'Section Display Options',
            'id'         => 'section_display_options',
            'post_types' => ['page'],
            'fields'     => [
                [
                    'name' => 'Section Title',
                    'id'   => 'section_title',
                    'type' => 'text',
                ],
                [
                    'name' => 'Section Content',
                    'id'   => 'section_content',
                    'type' => 'textarea',
                ],
            ],
        ];
    }
}