<?php

namespace App\PostTypes;

use App\Contracts\PostTypeTemplate;

class FeaturedProject implements PostTypeTemplate
{
    /**
     * Get the post type name/slug
     *
     * @return string
     */
    public function getPostType(): string
    {
        return 'featured-project';
    }

    /**
     * Get the post type configuration
     *
     * @return array
     */
    public function getConfig(): array
    {
        $labels = [
            'name'                     => esc_html__('Featured Projects', 'sage'),
            'singular_name'            => esc_html__('Featured Project', 'sage'),
            'add_new'                  => esc_html__('Add New', 'sage'),
            'add_new_item'             => esc_html__('Add New Featured Project', 'sage'),
            'edit_item'                => esc_html__('Edit Featured Project', 'sage'),
            'new_item'                 => esc_html__('New Featured Project', 'sage'),
            'view_item'                => esc_html__('View Featured Project', 'sage'),
            'view_items'               => esc_html__('View Featured Projects', 'sage'),
            'search_items'             => esc_html__('Search Featured Projects', 'sage'),
            'not_found'                => esc_html__('No featured projects found.', 'sage'),
            'not_found_in_trash'       => esc_html__('No featured projects found in Trash.', 'sage'),
            'parent_item_colon'        => esc_html__('Parent Featured Project:', 'sage'),
            'all_items'                => esc_html__('All Featured Projects', 'sage'),
            'archives'                 => esc_html__('Featured Project Archives', 'sage'),
            'attributes'               => esc_html__('Featured Project Attributes', 'sage'),
            'insert_into_item'         => esc_html__('Insert into featured project', 'sage'),
            'uploaded_to_this_item'    => esc_html__('Uploaded to this featured project', 'sage'),
            'featured_image'           => esc_html__('Featured image', 'sage'),
            'set_featured_image'       => esc_html__('Set featured image', 'sage'),
            'remove_featured_image'    => esc_html__('Remove featured image', 'sage'),
            'use_featured_image'       => esc_html__('Use as featured image', 'sage'),
            'menu_name'                => esc_html__('Featured Projects', 'sage'),
            'filter_items_list'        => esc_html__('Filter featured projects list', 'sage'),
            'filter_by_date'           => esc_html__('', 'sage'),
            'items_list_navigation'    => esc_html__('Featured Projects list navigation', 'sage'),
            'items_list'               => esc_html__('Featured Projects list', 'sage'),
            'item_published'           => esc_html__('Featured Project published.', 'sage'),
            'item_published_privately' => esc_html__('Featured Project published privately.', 'sage'),
            'item_reverted_to_draft'   => esc_html__('Featured Project reverted to draft.', 'sage'),
            'item_scheduled'           => esc_html__('Featured Project scheduled.', 'sage'),
            'item_updated'             => esc_html__('Featured Project updated.', 'sage'),
        ];

        return [
            'label'               => esc_html__('Featured Projects', 'sage'),
            'labels'              => $labels,
            'description'         => esc_html__('Featured projects displayed on the homepage.', 'sage'),
            'public'              => true,
            'hierarchical'        => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false, // Typically not needed for homepage features
            'show_ui'             => true,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => true,
            'show_in_rest'        => true,
            'query_var'           => false,
            'can_export'          => true,
            'delete_with_user'    => false,
            'has_archive'         => false,
            'rest_base'           => 'featured-projects',
            'show_in_menu'        => true,
            'menu_position'       => 21, // Position after Portfolio Projects
            'menu_icon'           => 'dashicons-star-filled',
            'capability_type'     => 'post',
            'supports'            => ['title', 'thumbnail', 'revisions'], // Title for internal name, Thumbnail for image
            'taxonomies'          => [], // No default taxonomies needed based on example
            'rewrite'             => false, // No frontend rewrite needed
        ];
    }
}