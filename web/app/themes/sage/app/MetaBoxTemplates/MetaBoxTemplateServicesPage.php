<?php

namespace App\MetaBoxTemplates;

use App\Contracts\MetaBoxTemplate;

class MetaBoxTemplateServicesPage implements MetaBoxTemplate
{
    /**
     * Get the meta box configuration
     *
     * @return array
     */
    public function getConfig(): array
    {
        return [
            'title'      => 'Services Page Options',
            'id'         => 'services_page_options',
            'post_types' => ['page'],
            'context'    => 'normal',
            'priority'   => 'high',
            'fields'     => [
                // Hero Section fields (flattened)
                [
                    'name' => 'Hero Title',
                    'id'   => 'hero_title',
                    'type' => 'text',
                    'std'  => 'Our Landscaping Services',
                ],
                [
                    'name' => 'Hero Subtitle',
                    'id'   => 'hero_subtitle',
                    'type' => 'textarea',
                    'std'  => 'Professional solutions for your residential and commercial landscaping needs',
                ],
                [
                    'name' => 'Hero Button Text',
                    'id'   => 'hero_button_text',
                    'type' => 'text',
                    'std'  => 'Our Services',
                ],
                [
                    'name' => 'Hero Button URL',
                    'id'   => 'hero_button_url',
                    'type' => 'text',
                    'std'  => '#services',
                ],
                [
                    'name' => 'Hero Background Image',
                    'id'   => 'hero_background_image',
                    'type' => 'image_advanced',
                    'max_file_uploads' => 1,
                ],
                // Introduction Section fields (flattened)
                [
                    'name' => 'Introduction Title',
                    'id'   => 'intro_title',
                    'type' => 'text',
                    'std'  => 'Comprehensive Landscaping Solutions',
                ],
                [
                    'name' => 'Introduction Subtitle',
                    'id'   => 'intro_subtitle',
                    'type' => 'textarea',
                    'std'  => 'At Sandoval Landscaping, we offer a complete range of services to transform and maintain your outdoor spaces.',
                ],
                [
                    'name' => 'Introduction Content',
                    'id'   => 'intro_content',
                    'type' => 'wysiwyg',
                ],
                [
                    'name' => 'Introduction Image',
                    'id'   => 'intro_image',
                    'type' => 'image_advanced',
                    'max_file_uploads' => 1,
                ],
                // Service Categories fields (flattened)
                [
                    'name' => 'Service Category Title',
                    'id'   => 'service_category_title',
                    'type' => 'text',
                ],
                [
                    'name' => 'Service Category Subtitle',
                    'id'   => 'service_category_subtitle',
                    'type' => 'text',
                ],
                [
                    'name' => 'Service Category Description',
                    'id'   => 'service_category_description',
                    'type' => 'textarea',
                ],
                [
                    'name' => 'Service Category Link URL',
                    'id'   => 'service_category_url',
                    'type' => 'text',
                ],
                [
                    'name' => 'Service Category Image',
                    'id'   => 'service_category_image',
                    'type' => 'image_advanced',
                    'max_file_uploads' => 1,
                ],
                // Detailed Services fields (flattened)
                [
                    'name' => 'Detailed Service Title',
                    'id'   => 'detailed_service_title',
                    'type' => 'text',
                ],
                [
                    'name' => 'Detailed Service Subtitle',
                    'id'   => 'detailed_service_subtitle',
                    'type' => 'text',
                ],
                [
                    'name' => 'Detailed Service Description',
                    'id'   => 'detailed_service_description',
                    'type' => 'textarea',
                ],
                [
                    'name' => 'Detailed Service Link URL',
                    'id'   => 'detailed_service_url',
                    'type' => 'text',
                ],
                [
                    'name' => 'Detailed Service Image',
                    'id'   => 'detailed_service_image',
                    'type' => 'image_advanced',
                    'max_file_uploads' => 1,
                ],
                // Testimonials fields (flattened)
                [
                    'name' => 'Testimonial Quote',
                    'id'   => 'testimonial_quote',
                    'type' => 'textarea',
                ],
                [
                    'name' => 'Testimonial Author',
                    'id'   => 'testimonial_author',
                    'type' => 'text',
                ],
                [
                    'name' => 'Testimonial Position',
                    'id'   => 'testimonial_position',
                    'type' => 'text',
                ],
                // FAQs fields (flattened)
                [
                    'name' => 'FAQ Question',
                    'id'   => 'faq_question',
                    'type' => 'text',
                ],
                [
                    'name' => 'FAQ Answer',
                    'id'   => 'faq_answer',
                    'type' => 'textarea',
                ],
            ],
        ];
    }
}