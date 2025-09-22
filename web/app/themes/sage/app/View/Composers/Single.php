<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Single extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'single',
    ];

    /**
     * Data to be passed to view before rendering, but after merging.
     *
     * @return array
     */
    public function with(): array
    {
        $post = get_post();

        

        return [
            'title' => $this->title(),
            'pagination' => $this->pagination(),
            'author' => $this->author(),
            'post' => $post, 
            'post_author' => $post->post_author,
        ]; 
    }

    /**
     * Retrieve the author name.
     */
    public function author(): string
    {

        $post = get_post();

        $author = get_the_author_meta('display_name', $post->post_author);

        if (is_single()) {
            return $author;
        }

        return sprintf(
            /* translators: %s is replaced with the author name */
            __('by %s', 'sage'),
            '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html($author) . '</a>',
        );
    }

    /**
     * Retrieve the post title.
     */
    public function title(): string
    {
        if ($this->view->name !== 'partials.page-header') {
            return get_the_title();
        }

        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }

            return __('Latest Posts', 'sage');
        }

        if (is_archive()) {
            return get_the_archive_title();
        }

        if (is_search()) {
            return sprintf(
                /* translators: %s is replaced with the search query */
                __('Search Results for %s', 'sage'),
                get_search_query(),
            );
        }

        if (is_404()) {
            return __('Not Found', 'sage');
        }

        return get_the_title();
    }

    /**
     * Retrieve the pagination links.
     *
     * @return string
     */
    public function pagination(): string
    {
        return wp_link_pages([
            'echo' => 0,
            'before' => '<p>' . __('Pages:', 'sage'),
            'after' => '</p>',
        ]);
    }
}
