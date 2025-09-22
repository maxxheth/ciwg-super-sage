<?php

namespace App\PostTypes;

use App\Contracts\PostTypeTemplate;

class PortfolioProject implements PostTypeTemplate
{

    public function __construct()
    {
        add_filter('theme_portfolio-project_templates', [$this, 'addCustomTemplates'], 10, 4);
    }

    /**
     * Add custom templates to the portfolio project post type
     */
    public function addCustomTemplates($post_templates, $wp_theme, $post, $post_type)
    {
        $theme_dir = $wp_theme->get_template_directory(); // Get the theme directory
        $template_dir = $theme_dir . '/resources/views';
        // Add your custom templates here
        $portfolio_templates = [
            "$template_dir/template-portfolio-project.blade.php" => 'Portfolio Project', // This is the default template for portfolio projects
        ];
        
        return array_merge($post_templates, $portfolio_templates);
    }

    /**
     * Get the post type name/slug
     *
     * @return string
     */
    public function getPostType(): string
    {
        return 'portfolio-project';
    }

    /**
     * Get the post type configuration
     *
     * @return array
     */
    public function getConfig(): array
    {
        $labels = [
            'name'                     => esc_html__('Portfolio Projects', 'sage'),
            'singular_name'            => esc_html__('Portfolio Project', 'sage'),
            'add_new'                  => esc_html__('Portfolio Project', 'sage'),
            'add_new_item'             => esc_html__('Add New Portfolio Project', 'sage'),
            'edit_item'                => esc_html__('Edit Portfolio Project', 'sage'),
            'new_item'                 => esc_html__('New Portfolio Project', 'sage'),
            'view_item'                => esc_html__('View Portfolio Project', 'sage'),
            'view_items'               => esc_html__('View Portfolio Projects', 'sage'),
            'search_items'             => esc_html__('Search Portfolio Projects', 'sage'),
            'not_found'                => esc_html__('No portfolio items found.', 'sage'),
            'not_found_in_trash'       => esc_html__('No portfolio items found in Trash.', 'sage'),
            'parent_item_colon'        => esc_html__('Parent Portfolio Project:', 'sage'),
            'all_items'                => esc_html__('All Portfolio Projects', 'sage'),
            'archives'                 => esc_html__('Portfolio Project Archives', 'sage'),
            'attributes'               => esc_html__('Portfolio Project Attributes', 'sage'),
            'insert_into_item'         => esc_html__('Insert into portfolio item', 'sage'),
            'uploaded_to_this_item'    => esc_html__('Uploaded to this portfolio item', 'sage'),
            'featured_image'           => esc_html__('Featured image', 'sage'),
            'set_featured_image'       => esc_html__('Set featured image', 'sage'),
            'remove_featured_image'    => esc_html__('Remove featured image', 'sage'),
            'use_featured_image'       => esc_html__('Use as featured image', 'sage'),
            'menu_name'                => esc_html__('Portfolio Projects', 'sage'),
            'filter_items_list'        => esc_html__('Filter portfolio items list', 'sage'),
            'filter_by_date'           => esc_html__('', 'sage'),
            'items_list_navigation'    => esc_html__('Portfolio Projects list navigation', 'sage'),
            'items_list'               => esc_html__('Portfolio Projects list', 'sage'),
            'item_published'           => esc_html__('Portfolio Project published.', 'sage'),
            'item_published_privately' => esc_html__('Portfolio Project published privately.', 'sage'),
            'item_reverted_to_draft'   => esc_html__('Portfolio Project reverted to draft.', 'sage'),
            'item_scheduled'           => esc_html__('Portfolio Project scheduled.', 'sage'),
            'item_updated'             => esc_html__('Portfolio Project updated.', 'sage'),
        ];
        
        return [
            'label'               => esc_html__('Portfolio Items', 'sage'),
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
            'menu_icon'           => 'dashicons-format-gallery',
            'capability_type'     => 'page',
            'supports'            => ['title', 'thumbnail', 'author', 'page-attributes', 'template'],
            'taxonomies'          => ['category'],
            'rewrite'             => [
                'with_front' => true,
            ],
        ];
    }
}