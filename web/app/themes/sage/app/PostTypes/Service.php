<?php

namespace App\PostTypes;

use App\Contracts\PostTypeTemplate;

class Service implements PostTypeTemplate
{
    public function __construct()
    {
        add_filter('theme_service_templates', [$this, 'addCustomTemplates'], 10, 4);
    }

    /**
     * Add custom templates to the service post type
     */
    public function addCustomTemplates($post_templates, $wp_theme, $post, $post_type)
    {
        $theme_dir = $wp_theme->get_template_directory(); // Get the theme directory
        $template_dir = $theme_dir . '/resources/views';
        // Add your custom templates here
        $service_templates = [
            "$template_dir/template-service.blade.php" => 'Single Service', // This is the default template for services
        ];

        return array_merge($post_templates, $service_templates);
    }

    /**
     * Get the post type name/slug
     *
     * @return string
     */
    public function getPostType(): string
    {
        return 'service';
    }

    /**
     * Get the post type configuration
     *
     * @return array
     */
    public function getConfig(): array
    {
        $labels = [
            'name'                     => esc_html__('Services', 'sage'),
            'singular_name'            => esc_html__('Service', 'sage'),
            'add_new'                  => esc_html__('Add Service', 'sage'),
            'add_new_item'             => esc_html__('Add New Service', 'sage'),
            'edit_item'                => esc_html__('Edit Service', 'sage'),
            'new_item'                 => esc_html__('New Service', 'sage'),
            'view_item'                => esc_html__('View Service', 'sage'),
            'view_items'               => esc_html__('View Services', 'sage'),
            'search_items'             => esc_html__('Search Services', 'sage'),
            'not_found'                => esc_html__('No services found.', 'sage'),
            'not_found_in_trash'       => esc_html__('No services found in Trash.', 'sage'),
            'parent_item_colon'        => esc_html__('Parent Service:', 'sage'),
            'all_items'                => esc_html__('All Services', 'sage'),
            'archives'                 => esc_html__('Service Archives', 'sage'),
            'attributes'               => esc_html__('Service Attributes', 'sage'),
            'insert_into_item'         => esc_html__('Insert into service', 'sage'),
            'uploaded_to_this_item'    => esc_html__('Uploaded to this service', 'sage'),
            'featured_image'           => esc_html__('Featured image', 'sage'),
            'set_featured_image'       => esc_html__('Set featured image', 'sage'),
            'remove_featured_image'    => esc_html__('Remove featured image', 'sage'),
            'use_featured_image'       => esc_html__('Use as featured image', 'sage'),
            'menu_name'                => esc_html__('Services', 'sage'),
            'filter_items_list'        => esc_html__('Filter services list', 'sage'),
            'filter_by_date'           => esc_html__('', 'sage'),
            'items_list_navigation'    => esc_html__('Services list navigation', 'sage'),
            'items_list'               => esc_html__('Services list', 'sage'),
            'item_published'           => esc_html__('Service published.', 'sage'),
            'item_published_privately' => esc_html__('Service published privately.', 'sage'),
            'item_reverted_to_draft'   => esc_html__('Service reverted to draft.', 'sage'),
            'item_scheduled'           => esc_html__('Service scheduled.', 'sage'),
            'item_updated'             => esc_html__('Service updated.', 'sage'),
        ];

        return [
            'label'               => esc_html__('Services', 'sage'),
            'labels'              => $labels,
            'description'         => '',
            'public'              => true,
            'hierarchical'        => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'show_in_rest'        => true,
            'query_var'           => true,
            'can_export'          => true,
            'delete_with_user'    => true,
            'order'               => true,
            'has_archive'         => true,
            'rest_base'           => '',
            'show_in_menu'        => true,
            'menu_position'       => '',
            'menu_icon'           => 'dashicons-admin-tools',
            'capability_type'     => 'page',
            'supports'            => ['title', 'thumbnail', 'author', 'page-attributes', 'template'],
            'taxonomies'          => ['category'],
            // 'rewrite'             => [
            //     'slug' => 'services',
            //     // 'with_front' => true,
            // ],
        ];
    }
}
