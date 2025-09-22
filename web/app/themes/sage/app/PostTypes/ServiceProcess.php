<?php

namespace App\PostTypes;

use App\Contracts\PostTypeTemplate;

class ServiceProcess implements PostTypeTemplate
{
    /**
     * Get the post type name/slug
     *
     * @return string
     */
    public function getPostType(): string
    {
        return 'service-process';
    }

    /**
     * Get the post type configuration
     *
     * @return array
     */
    public function getConfig(): array
    {
        $labels = [
            'name'                     => esc_html__('Service Processes', 'sage'),
            'singular_name'            => esc_html__('Service Process', 'sage'),
            'add_new'                  => esc_html__('Add Process Step', 'sage'),
            'add_new_item'             => esc_html__('Add New Process Step', 'sage'),
            'edit_item'                => esc_html__('Edit Process Step', 'sage'),
            'new_item'                 => esc_html__('New Process Step', 'sage'),
            'view_item'                => esc_html__('View Process Step', 'sage'),
            'view_items'               => esc_html__('View Process Steps', 'sage'),
            'search_items'             => esc_html__('Search Process Steps', 'sage'),
            'not_found'                => esc_html__('No process steps found.', 'sage'),
            'not_found_in_trash'       => esc_html__('No process steps found in Trash.', 'sage'),
            'parent_item_colon'        => esc_html__('Parent Process Step:', 'sage'),
            'all_items'                => esc_html__('All Process Steps', 'sage'),
            'archives'                 => esc_html__('Process Step Archives', 'sage'),
            'attributes'               => esc_html__('Process Step Attributes', 'sage'),
            'insert_into_item'         => esc_html__('Insert into Process Step', 'sage'),
            'uploaded_to_this_item'    => esc_html__('Uploaded to this Process Step', 'sage'),
            'menu_name'                => esc_html__('Process Steps', 'sage'),
            'filter_items_list'        => esc_html__('Filter Process Steps list', 'sage'),
            'items_list_navigation'    => esc_html__('Process Steps list navigation', 'sage'),
            'items_list'               => esc_html__('Process Steps list', 'sage'),
            'item_published'           => esc_html__('Process Step published.', 'sage'),
            'item_published_privately' => esc_html__('Process Step published privately.', 'sage'),
            'item_reverted_to_draft'   => esc_html__('Process Step reverted to draft.', 'sage'),
            'item_scheduled'           => esc_html__('Process Step scheduled.', 'sage'),
            'item_updated'             => esc_html__('Process Step updated.', 'sage'),
        ];
        
        return [
            'label'               => esc_html__('Service Processes', 'sage'),
            'labels'              => $labels,
            'description'         => '',
            'public'              => false,
            'hierarchical'        => false,
            'exclude_from_search' => true,
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
            'menu_icon'           => 'dashicons-list-view',
            'capability_type'     => 'post',
            'supports'            => ['title', 'revisions', 'page-attributes'],
            'taxonomies'          => ['service-process-category'],
            'rewrite'             => [
                'slug' => 'service-process',
                'with_front' => false,
            ],
        ];
    }
}