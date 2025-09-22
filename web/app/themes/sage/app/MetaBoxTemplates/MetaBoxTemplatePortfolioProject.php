<?php

namespace App\MetaBoxTemplates;

use App\Contracts\MetaBoxTemplate;

class MetaBoxTemplatePortfolioProject implements MetaBoxTemplate
{
    /**
     * Get Meta Box configuration
     *
     * @return array
     */
    public function getConfig(): array
    {
        return [
            'id'         => 'portfolio_project_details',
            'title'      => esc_html__('Portfolio Project Details', 'sage'),
            'post_types' => ['portfolio-project'],
            'context'    => 'normal',
            'priority'   => 'high',
            'fields'     => [
                [
                    'name'        => esc_html__('Project Description', 'sage'),
                    'id'          => 'project_description',
                    'type'        => 'wysiwyg',
                    'options'     => [
                        'teeny'         => false,
                        'media_buttons' => true,
                    ],
                    'desc'        => esc_html__('Enter a detailed description of the project', 'sage'),
                ],
                [
                    'name'        => esc_html__('Short Description', 'sage'),
                    'id'          => 'project_short_description',
                    'type'        => 'textarea',
                    'rows'        => 3,
                    'desc'        => esc_html__('Brief summary for use in project listings (150 characters max)', 'sage'),
                ],
                [
                    'name'        => esc_html__('Location', 'sage'),
                    'id'          => 'project_location',
                    'type'        => 'text',
                    'desc'        => esc_html__('City, State format (e.g., Dallas, TX)', 'sage'),
                ],
                [
                    'name'        => esc_html__('Services Provided', 'sage'),
                    'id'          => 'project_services',
                    'type'        => 'text',
                    'clone'       => true,
                    'desc'        => esc_html__('List the services provided for this project', 'sage'),
                ],
                [
                    'name'        => esc_html__('Project Gallery', 'sage'),
                    'id'          => 'project_gallery',
                    'type'        => 'image_advanced',
                    'desc'        => esc_html__('Upload images for the project gallery', 'sage'),
                ],
                [
                    'name'        => esc_html__('Featured Project', 'sage'),
                    'id'          => 'is_featured',
                    'type'        => 'checkbox',
                    'desc'        => esc_html__('Set this project as featured on the portfolio page', 'sage'),
                ],
                [
                    'name'        => esc_html__('Project Completion Date', 'sage'),
                    'id'          => 'project_completion_date',
                    'type'        => 'date',
                    'desc'        => esc_html__('When was this project completed?', 'sage'),
                ],
                [
                    'name'        => esc_html__('Client Name', 'sage'),
                    'id'          => 'project_client',
                    'type'        => 'text',
                    'desc'        => esc_html__('Name of the client (optional)', 'sage'),
                ],
                [
                    'name'        => esc_html__('Project Size/Scope', 'sage'),
                    'id'          => 'project_size',
                    'type'        => 'text',
                    'desc'        => esc_html__('Size or scope of the project (e.g., "5 acres", "15,000 sq ft")', 'sage'),
                ],
            ],
        ];
    }
}