<?php

namespace App\Contracts;

interface PostTypeTemplate
{
    /**
     * Get the post type configuration
     *
     * @return array
     */
    public function getConfig(): array;
    
    /**
     * Get the post type name/slug
     *
     * @return string
     */
    public function getPostType(): string;
}