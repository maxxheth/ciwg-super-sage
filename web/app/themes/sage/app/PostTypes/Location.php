<?php

namespace App\PostTypes;

use App\Contracts\PostTypeTemplate;

class Location implements PostTypeTemplate
{
    /**
     * Get the post type name/slug
     *
     * @return string
     */
    public function getPostType(): string
    {
        return 'location';
    }

    /**
     * Get the post type configuration
     *
     * @return array
     */
    public function getConfig(): array
    {
        $labels = [
            'name'                     => esc_html__('Locations', 'sage'),
            'singular_name'            => esc_html__('Location', 'sage'),
            'add_new'                  => esc_html__('Add Location', 'sage'),
            'add_new_item'             => esc_html__('Add New Location', 'sage'),
            'edit_item'                => esc_html__('Edit Location', 'sage'),
            'new_item'                 => esc_html__('New Location', 'sage'),
            'view_item'                => esc_html__('View Location', 'sage'),
            'view_items'               => esc_html__('View Locations', 'sage'),
            'search_items'             => esc_html__('Search Locations', 'sage'),
            'not_found'                => esc_html__('No locations found.', 'sage'),
            'not_found_in_trash'       => esc_html__('No locations found in Trash.', 'sage'),
            'parent_item_colon'        => esc_html__('Parent Location:', 'sage'),
            'all_items'                => esc_html__('All Locations', 'sage'),
            'archives'                 => esc_html__('Location Archives', 'sage'),
            'attributes'               => esc_html__('Location Attributes', 'sage'),
            'insert_into_item'         => esc_html__('Insert into location', 'sage'),
            'uploaded_to_this_item'    => esc_html__('Uploaded to this location', 'sage'),
            'featured_image'           => esc_html__('Featured image', 'sage'),
            'set_featured_image'       => esc_html__('Set featured image', 'sage'),
            'remove_featured_image'    => esc_html__('Remove featured image', 'sage'),
            'use_featured_image'       => esc_html__('Use as featured image', 'sage'),
            'menu_name'                => esc_html__('Locations', 'sage'),
            'filter_items_list'        => esc_html__('Filter locations list', 'sage'),
            'items_list_navigation'    => esc_html__('Locations list navigation', 'sage'),
            'items_list'               => esc_html__('Locations list', 'sage'),
            'item_published'           => esc_html__('Location published.', 'sage'),
            'item_published_privately' => esc_html__('Location published privately.', 'sage'),
            'item_reverted_to_draft'   => esc_html__('Location reverted to draft.', 'sage'),
            'item_scheduled'           => esc_html__('Location scheduled.', 'sage'),
            'item_updated'             => esc_html__('Location updated.', 'sage'),
        ];

        return [
            'label'               => esc_html__('Locations', 'sage'),
            'labels'              => $labels,
            'public'              => true,
            'hierarchical'        => false,
            'show_in_rest'        => true,
            'has_archive'         => 'locations',
            'rewrite'             => ['slug' => 'locations'],
            'menu_icon'           => 'dashicons-location-alt',
            'supports'            => ['title', 'editor', 'thumbnail'],
        ];
    }
}