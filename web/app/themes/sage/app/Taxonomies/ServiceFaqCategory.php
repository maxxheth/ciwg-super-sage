<?php

namespace App\Taxonomies;

class ServiceFaqCategory
{
    public function register()
    {
        $labels = [
            'name'                       => esc_html__('FAQ Categories', 'sage'),
            'singular_name'              => esc_html__('FAQ Category', 'sage'),
            'search_items'               => esc_html__('Search FAQ Categories', 'sage'),
            'popular_items'              => esc_html__('Popular FAQ Categories', 'sage'),
            'all_items'                  => esc_html__('All FAQ Categories', 'sage'),
            'parent_item'                => esc_html__('Parent FAQ Category', 'sage'),
            'parent_item_colon'          => esc_html__('Parent FAQ Category:', 'sage'),
            'edit_item'                  => esc_html__('Edit FAQ Category', 'sage'),
            'view_item'                  => esc_html__('View FAQ Category', 'sage'),
            'update_item'                => esc_html__('Update FAQ Category', 'sage'),
            'add_new_item'               => esc_html__('Add New FAQ Category', 'sage'),
            'new_item_name'              => esc_html__('New FAQ Category Name', 'sage'),
            'separate_items_with_commas' => esc_html__('Separate FAQ categories with commas', 'sage'),
            'add_or_remove_items'        => esc_html__('Add or remove FAQ categories', 'sage'),
            'choose_from_most_used'      => esc_html__('Choose from the most used FAQ categories', 'sage'),
            'not_found'                  => esc_html__('No FAQ categories found.', 'sage'),
            'no_terms'                   => esc_html__('No FAQ categories', 'sage'),
            'filter_by_item'             => esc_html__('Filter by FAQ category', 'sage'),
            'items_list_navigation'      => esc_html__('FAQ Categories list navigation', 'sage'),
            'items_list'                 => esc_html__('FAQ Categories list', 'sage'),
            'back_to_items'              => esc_html__('&larr; Back to FAQ Categories', 'sage'),
            'item_link'                  => esc_html__('FAQ Category Link', 'sage'),
            'item_link_description'      => esc_html__('A link to a FAQ category.', 'sage'),
        ];

        $args = [
            'labels'             => $labels,
            'description'        => esc_html__('Categories for organizing Service FAQs', 'sage'),
            'public'             => true,
            'publicly_queryable' => true,
            'hierarchical'       => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'show_in_nav_menus'  => false,
            'show_in_rest'       => true,
            'show_tagcloud'      => false,
            'show_in_quick_edit' => true,
            'show_admin_column'  => true,
            'query_var'          => true,
            'sort'               => false,
            'rewrite'            => [
                'slug'       => 'service-faq-category',
                'with_front' => false,
            ],
        ];

        register_taxonomy('service-faq-category', ['service-faq'], $args);
    }
}