<?php

namespace App\PostTypes;

use App\Contracts\PostTypeTemplate;

class PostTypeFactory
{
    /**
     * Array of PostTypeTemplate instances
     *
     * @var array<PostTypeTemplate>
     */
    protected $templates = [];

    /**
     * Constructor that accepts templates via dependency injection
     *
     * @param array<PostTypeTemplate> $templates
     */
    public function __construct(array $templates = [])
    {
        $this->templates = $templates;
    }

    /**
     * Add a template to the factory
     *
     * @param PostTypeTemplate $template
     * @return $this
     */
    public function addTemplate(PostTypeTemplate $template): self
    {
        $this->templates[] = $template;
        return $this;
    }

    /**
     * Register all post types
     *
     * @return void
     */
    public function register(): void
    {
        foreach ($this->templates as $template) {
            $config = $template->getConfig();
            $post_type = $template->getPostType();
            
            register_post_type($post_type, $config);
        }
    }

    /**
     * Static method for backward compatibility and easier usage
     *
     * @return void
     */
    public static function registerAll(): void
    {
        $factory = app(PostTypeFactory::class);
        $factory->register();
    }
}