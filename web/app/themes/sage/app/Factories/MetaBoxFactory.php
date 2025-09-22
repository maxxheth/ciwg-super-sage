<?php

namespace App\Factories;

use App\Contracts\MetaBoxTemplate;

class MetaBoxFactory
{
    /**
     * Array of MetaBoxTemplate instances
     *
     * @var array<MetaBoxTemplate>
     */
    protected $templates = [];

    /**
     * Constructor that accepts templates via dependency injection
     *
     * @param array<MetaBoxTemplate> $templates
     */
    public function __construct(array $templates = [])
    {
        $this->templates = $templates;
    }

    /**
     * Add a template to the factory
     *
     * @param MetaBoxTemplate $template
     * @return $this
     */
    public function addTemplate(MetaBoxTemplate $template): self
    {
        $this->templates[] = $template;
        return $this;
    }

    /**
     * Register all Meta Box fields
     *
     * @param array $meta_boxes
     * @return array
     */
    public function register(array $meta_boxes): array
    {
        foreach ($this->templates as $template) {
            $config = $template->getConfig();

            if (isset($config['fields']) && is_array($config['fields'])) {
                $config['fields'] = $this->ensureFieldProperties($config['fields']);
            }

            $meta_boxes[] = $config;
        }

        return $meta_boxes;
    }

    /**
     * Ensure each top-level field has the required 'clone' property.
     *
     * @param array $fields
     * @return array
     */
    protected function ensureFieldProperties(array $fields): array
    {
        foreach ($fields as &$field) {
            if (!isset($field['clone'])) {
                $field['clone'] = false;
            }
        }
        return $fields;
    }

    /**
     * Static method for backward compatibility and easier usage
     *
     * @param array $meta_boxes
     * @return array
     */
    public static function registerAll(array $meta_boxes): array
    {
        $factory = app(MetaBoxFactory::class);
        return $factory->register($meta_boxes);
    }
}