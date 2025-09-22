<?php

namespace App\MetaBoxTemplates;

use App\Contracts\MetaBoxTemplate;

class MetaBoxTemplateServiceDetails implements MetaBoxTemplate
{
    /**
     * Get the meta box configuration
     * 
     * @return array
     */
    public function getConfig(): array
    {
        return [
            'title'      => 'Service Details',
            'id'         => 'service_details',
            'post_types' => ['service'], // Adjust based on your post type
            'context'    => 'normal',
            'priority'   => 'high',
            'fields'     => [
                [
                    'name'  => 'Description',
                    'id'    => 'service_description',
                    'type'  => 'textarea',
                    'clone' => false,
                    'desc'  => 'Short description of the service that will appear in the hero section',
                ],
                [
                    'name'  => 'Content',
                    'id'    => 'service_content',
                    'type'  => 'wysiwyg',
                    'clone' => false,
                    'desc'  => 'Main content of the service',
                ],
                [
                    'name'  => 'Hero Image',
                    'id'    => 'service_hero_image',
                    'type'  => 'image_advanced',
                    'max_file_uploads' => 1,
                    'clone' => false,
                    'desc'  => 'Image to be displayed in the hero section',
                ],
                [
                    'name'  => 'Service Features',
                    'id'    => 'service_features',
                    'type'  => 'group',
                    'clone' => true,
                    'sort_clone' => true,
                    'collapsible' => true,
                    'group_title' => '{#}. {title}',
                    'add_button' => '+ Add Feature',
                    'fields' => [
                        [
                            'name'    => 'Title',
                            'id'      => 'title',
                            'type'    => 'text',
                            'required' => true,
                            'desc'    => 'Feature title',
                            'clone'   => false,
                        ],
                        [
                            'name'    => 'Description',
                            'id'      => 'description',
                            'type'    => 'textarea',
                            'desc'    => 'Feature description',
                            'clone'   => false,
                        ],
                        [
                            'name'    => 'Icon Type',
                            'id'      => 'type',
                            'type'    => 'select',
                            'options' => [
                                'design'           => 'Design & Planning (design)',
                                'maintenance'      => 'Maintenance & Care (maintenance)',
                                'irrigation'       => 'Irrigation & Water (irrigation)',
                                'planting'         => 'Plants & Greenery (planting)',
                                'hardscape'        => 'Hardscape & Construction (hardscape)',
                                'local expertise'  => 'Local Expertise (local expertise)',
                                'sustainability'   => 'Sustainability & Eco-Friendly (sustainability)',
                                'leaf'             => 'Leaf & Foliage (leaf)',
                                'trowel'           => 'Gardening Tools (trowel)',
                                'checklist'        => 'Checklist & Services (checklist)',
                                'shield'           => 'Protection & Warranty (shield)',
                                'hourglass'        => 'Time & Scheduling (hourglass)',
                                'info'             => 'Information (info)',
                                'eye'              => 'Oversight & Attention (eye)',
                                'seedling'         => 'Growth & Development (seedling)',
                                'wrench'           => 'Repairs & Maintenance Tools (wrench)',
                                'tools'            => 'Equipment & Toolbox (tools)',
                                'thumbs-up'        => 'Thumbs Up (thumbs-up)',
                                'seasonal color'   => 'Seasonal Color (seasonal color)',
                                'lighting'         => 'Outdoor Lighting (lighting)',
                                'soil management'  => 'Soil Management (soil management)'
                            ],
                            'desc'    => 'Select the icon type for this feature',
                            'clone'   => false,
                        ],
                    ],
                ],
                [
                    'name'  => 'Process Section Title',
                    'id'    => 'process_section_title',
                    'type'  => 'text',
                    'clone' => false,
                    'std'   => 'Our Design Process',
                    'desc'  => 'Title for the process section',
                ],
                [
                    'name'  => 'Process Section Subtitle',
                    'id'    => 'process_section_subtitle',
                    'type'  => 'text',
                    'clone' => false,
                    'std'   => 'How we create your perfect landscape design',
                    'desc'  => 'Subtitle for the process section',
                ],
                [
                    'name'  => 'Process Steps',
                    'id'    => 'process_steps',
                    'type'  => 'group',
                    'clone' => true,
                    'sort_clone' => true,
                    'collapsible' => true,
                    'group_title' => '{#}. {step_title}',
                    'add_button' => '+ Add Process Step',
                    'fields' => [
                        [
                            'name'    => 'Step Title',
                            'id'      => 'step_title',
                            'type'    => 'text',
                            'required' => true,
                            'desc'    => 'Title of this process step',
                            'clone' => false,
                        ],
                        [
                            'name'    => 'Step Description',
                            'id'      => 'step_description',
                            'type'    => 'textarea',
                            'desc'    => 'A brief description of this process step',
                            'clone' => false,
                        ],
                        [
                            'name'    => 'Icon Type',
                            'id'      => 'icon_type',
                            'type'    => 'select',
                            'options' => [
                                'default'      => 'Default (Number)',
                                'consultation' => 'Consultation',
                                'analysis'     => 'Analysis & Testing',
                                'design'       => 'Design & Planning',
                                'development'  => 'Development',
                                'presentation' => 'Presentation',
                                'refinement'   => 'Refinement',
                                'implementation' => 'Implementation',
                                'maintenance'  => 'Maintenance & Care',
                                'irrigation'   => 'Irrigation & Water',
                                'planting'     => 'Plants & Greenery',
                                'hardscape'    => 'Hardscape & Construction',
                                'leaf'         => 'Leaf & Foliage',
                                'trowel'       => 'Gardening Tools',
                                'checklist'    => 'Checklist & Services',
                                'shield'       => 'Protection & Warranty',
                                'hourglass'    => 'Time & Scheduling',
                                'info'         => 'Information',
                                'eye'          => 'Oversight & Attention',
                                'seedling'     => 'Growth & Development',
                                'wrench'       => 'Repairs & Maintenance Tools',
                                'tools'        => 'Equipment & Toolbox',
                                'thumbs-up'    => 'Thumbs Up',
                            ],
                            'std'     => 'default',
                            'desc'    => 'Select the icon type for this process step',
                            'clone' => false,
                        ],
                    ],
                ],
                [
                    'name'  => 'Gallery',
                    'id'    => 'service_gallery',
                    'type'  => 'image_advanced',
                    'clone' => false,
                    'desc'  => 'Images to be displayed in the gallery section',
                ],
                [
                    'name'  => 'Benefits',
                    'id'    => 'service_benefits',
                    'type'  => 'text',
                    'clone' => true,
                    'desc'  => 'List of benefits for this service',
                ],
                [
                    'name'      => 'Related Services',
                    'id'        => 'related_services',
                    'type'      => 'post',
                    'post_type' => 'service',
                    'multiple'  => true,
                    'clone' => false,
                    'desc'      => 'Select related services',
                ],
            ],
        ];
    }
}