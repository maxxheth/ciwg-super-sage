<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Page extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'page',
        'template-*', // Apply to all templates, which are often used for pages.
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'title' => $this->title(),
			'pagination' => $this->pagination()
        ];
    }

    /**
     * Returns the current page's title.
     *
     * @return string
     */
    public function title()
    {
        return get_the_title();
    }

    /**
     * Returns the current page's pagination.
     *
     * @return array
     */
    public function pagination()
    {
        return [
            'prev' => get_previous_post(),
            'next' => get_next_post(),
        ];
    }
}