<?php

namespace App\MetaBoxTemplates;

use App\Contracts\MetaBoxTemplate;

class MetaBoxTemplateFeaturedProject implements MetaBoxTemplate
{
    /**
     * Get Meta Box configuration
     *
     * @return array
     */
    public function getConfig(): array
    {
        return [
            'id'         => 'featured_project_details',
            'title'      => esc_html__('Featured Project Details', 'sage'),
            'post_types' => ['featured-project'], // Apply to the new CPT
            'context'    => 'normal',
            'priority'   => 'high',
            'fields'     => [
                [
                    'name'        => esc_html__('Project Category', 'sage'),
                    'id'          => 'featured_project_category',
                    'type'        => 'text',
                    'desc'        => esc_html__('Category label shown on the card (e.g., Corporate, Retail).', 'sage'),
                    'placeholder' => esc_html__('e.g., Corporate', 'sage'),
                ],
                [
                    'name'        => esc_html__('Project Description', 'sage'),
                    'id'          => 'featured_project_description',
                    'type'        => 'textarea',
                    'rows'        => 4,
                    'desc'        => esc_html__('Short description displayed on the project card.', 'sage'),
                ],
                [
                    'name'        => esc_html__('Project Link', 'sage'),
                    'id'          => 'featured_project_link',
                    'type'        => 'post', // Link to an existing post/page
                    'post_type'   => ['portfolio-project', 'page'], // Allow linking to Portfolio Projects or Pages
                    'field_type'  => 'select_advanced', // Use a searchable dropdown
                    'placeholder' => esc_html__('Select a Project or Page', 'sage'),
                    'query_args'  => [
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                    ],
                    'desc'        => esc_html__('Link for the "View Project Details" button. Select the full portfolio project or relevant page.', 'sage'),
                ],
                 [
                    'name'        => esc_html__('Display Order', 'sage'),
                    'id'          => 'featured_project_order',
                    'type'        => 'number',
                    'min'         => 0,
                    'step'        => 1,
                    'std'         => 0, // Default order
                    'desc'        => esc_html__('Set the display order on the homepage (lower numbers appear first).', 'sage'),
                ],
            ],
        ];
    }
}