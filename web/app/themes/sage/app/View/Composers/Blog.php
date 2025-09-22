<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Blog extends Composer
{
	/**
	 * List of views served by this composer.
	 *
	 * @var array
	 */
	protected static $views = [
		'template-blog',
	];

	/**
	 * Get the featured post.
	 * Returns the latest post marked as featured.
	 *
	 * @return \WP_Post|null The featured post object or null if none found.
	 */
	public function getFeaturedPost(): ?\WP_Post
	{
		$args = [
			'post_type'      => 'post',
			'posts_per_page' => 1, // We only need the latest one
			'meta_key'       => 'featured_post',
			'meta_value'     => '1', // Assuming '1' means featured
			'orderby'        => 'date', // Get the most recent featured post
			'order'          => 'DESC',
			'post_status'    => 'publish', // Ensure it's a published post
		];

		$featured_query = new \WP_Query($args);

		// Return the first post found, or null if the query returned no posts
		return $featured_query->have_posts() ? $featured_query->posts[0] : null;
	}

	/**
	 * Data to be passed to view before rendering, but after merging.
	 *
	 * @return array
	 */
	public function with(): array
	{
		$featuredPost = $this->getFeaturedPost(); // Get the featured post

		return [
			'title' => $this->title(),
			'pagination' => $this->pagination(),
			'author' => $this->author(),
			'posts' => $this->getPosts($featuredPost ? $featuredPost->ID : null), // Pass featured post ID to exclude it
			'featured_post' => $featuredPost, // Add featured post to the view data
		];
	}

	/**
	 * Get non-featured posts query, optionally excluding a specific post ID.
	 *
	 * @param int|null $exclude_id The ID of the post to exclude (e.g., the featured post).
	 * @return \WP_Query The query object for non-featured posts.
	 */
	public function getPosts(int | null $exclude_id = null): \WP_Query // Change return type hint
	{
		// Get the current page number
		$paged = get_query_var('paged') ? get_query_var('paged') : 1;

		// Base query args
		$args = [
			'post_type'      => 'post',
			'paged'          => $paged,
			'posts_per_page' => -1, // Change to -1 to get all posts, or set a specific number if needed
			'post_status'    => 'publish',
		];

		// Exclude the featured post ID if provided
		if ($exclude_id !== null) {
			$args['post__not_in'] = [$exclude_id];
		}

		$postsQuery = new \WP_Query($args);

		 // Return the entire query object
		return $postsQuery; // Change this line
	}

	/**
	 * Retrieve the author name.
	 */
	public function author(): string
	{
		if (is_single()) {
			return get_the_author();
		}

		return sprintf(
			/* translators: %s is replaced with the author name */
			__('by %s', 'sage'),
			'<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a>',
		);
	}

	/**
	 * Retrieve the post title.
	 */
	public function title(): string
	{
		if (is_single()) {
			return get_the_title();
		}

		return __('Blog', 'sage');
	}

	/**
	 * Retrieve the pagination.
	 */
	public function pagination(): string
	{
		if (is_single()) {
			return get_the_date();
		}

		return get_the_date('F Y');
	}
}