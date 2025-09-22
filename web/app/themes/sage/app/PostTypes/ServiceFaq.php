<?php

namespace App\PostTypes;

use App\Contracts\PostTypeTemplate;

class ServiceFaq implements PostTypeTemplate
{
    /**
     * Get the post type name/slug
     *
     * @return string
     */
    public function getPostType(): string
    {
        return 'service-faq';
    }

    /**
     * Get the post type configuration
     *
     * @return array
     */
    public function getConfig(): array
    {
        $labels = [
            'name'                     => esc_html__('Service FAQs', 'sage'),
            'singular_name'            => esc_html__('Service FAQ', 'sage'),
            'add_new'                  => esc_html__('Add FAQ', 'sage'),
            'add_new_item'             => esc_html__('Add New FAQ', 'sage'),
            'edit_item'                => esc_html__('Edit FAQ', 'sage'),
            'new_item'                 => esc_html__('New FAQ', 'sage'),
            'view_item'                => esc_html__('View FAQ', 'sage'),
            'view_items'               => esc_html__('View FAQs', 'sage'),
            'search_items'             => esc_html__('Search FAQs', 'sage'),
            'not_found'                => esc_html__('No FAQs found.', 'sage'),
            'not_found_in_trash'       => esc_html__('No FAQs found in Trash.', 'sage'),
            'parent_item_colon'        => esc_html__('Parent FAQ:', 'sage'),
            'all_items'                => esc_html__('All FAQs', 'sage'),
            'archives'                 => esc_html__('FAQ Archives', 'sage'),
            'attributes'               => esc_html__('FAQ Attributes', 'sage'),
            'insert_into_item'         => esc_html__('Insert into FAQ', 'sage'),
            'uploaded_to_this_item'    => esc_html__('Uploaded to this FAQ', 'sage'),
            'menu_name'                => esc_html__('Service FAQs', 'sage'),
            'filter_items_list'        => esc_html__('Filter FAQs list', 'sage'),
            'items_list_navigation'    => esc_html__('FAQs list navigation', 'sage'),
            'items_list'               => esc_html__('FAQs list', 'sage'),
            'item_published'           => esc_html__('FAQ published.', 'sage'),
            'item_published_privately' => esc_html__('FAQ published privately.', 'sage'),
            'item_reverted_to_draft'   => esc_html__('FAQ reverted to draft.', 'sage'),
            'item_scheduled'           => esc_html__('FAQ scheduled.', 'sage'),
            'item_updated'             => esc_html__('FAQ updated.', 'sage'),
        ];
        
        return [
            'label'               => esc_html__('Service FAQs', 'sage'),
            'labels'              => $labels,
            'description'         => '',
            'public'              => true,
            'hierarchical'        => false,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => true,
            'show_in_rest'        => true,
            'query_var'           => true,
            'can_export'          => true,
            'delete_with_user'    => false,
            'has_archive'         => false,
            'rest_base'           => '',
            'show_in_menu'        => 'edit.php?post_type=service',
            'menu_position'       => '',
            'menu_icon'           => 'dashicons-editor-help',
            'capability_type'     => 'post',
            'supports'            => ['title', 'editor', 'revisions'],
            'taxonomies'          => ['service-faq-category'],
            'rewrite'             => [
                'slug' => 'service-faq',
                'with_front' => false,
            ],
        ];
    }
}