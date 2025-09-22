<?php

/**
 * Theme setup.
 */

namespace App;

use Illuminate\Support\Facades\Vite;
use App\PostTypes\PostTypeFactory;
use App\Services\ImageProcessor;
use App\Admin\MediaCompression;

// Initialize media compression features
// add_action('admin_init', function() {
//     new MediaCompression();
// });

add_action('wp_head', function () {
    ?>
    <script id="spinningLogoData" type="application/json">
    <?php
    // Logo path
    $logo_path = 'resources/images/logos';

    $defaultLogoStyles = 'w-16 h-16';

    // Create multidimensional array with URL and className for each logo

    $mainLogo = Vite::asset("$logo_path/sandoval-logo-wo-text.png");
    $logos = [
        'mcdonalds' => [
            'imagePath' => Vite::asset("$logo_path/mcdonalds-logo.webp"),
            'className' => 'mcdonalds-logo-class rounded-full',
        ],
        'ashton_woods' => [
            'imagePath' => Vite::asset("$logo_path/ashton-woods-logo.webp"),
            'className' => 'ashton-woods-logo-class rounded-full',
        ],
        'bridge' => [
            'imagePath' => Vite::asset("$logo_path/bridge-logo.webp"),
            'className' => 'bridge-logo-class rounded-full',
        ],
        'camden' => [
            'imagePath' => Vite::asset("$logo_path/camden-logo.webp"),
            'className' => 'camden-logo-class rounded-full',
        ],
        'drees' => [
            'imagePath' => Vite::asset("$logo_path/drees-logo.webp"),
            'className' => 'drees-logo-class rounded-full',
        ],
        'firestone' => [
            'imagePath' => Vite::asset("$logo_path/firestone-logo.webp"),
            'className' => 'firestone-logo-class rounded-full',
        ],
        'garland' => [
            'imagePath' => Vite::asset("$logo_path/garland-logo.webp"),
            'className' => 'garland-logo-class rounded-full',
        ],
        'jackson' => [
            'imagePath' => Vite::asset("$logo_path/jackson-logo.webp"),
            'className' => 'jackson-logo-class rounded-full',
        ],
        'kb_homes' => [
            'imagePath' => Vite::asset("$logo_path/kb-homes-logo.webp"),
            'className' => 'kb-homes-logo-class rounded-full',
        ],
        'keller' => [
            'imagePath' => Vite::asset("$logo_path/keller-logo.webp"),
            'className' => 'keller-logo-class rounded-full',
        ],
        'ladera' => [
            'imagePath' => Vite::asset("$logo_path/ladera-logo.webp"),
            'className' => 'ladera-logo-class rounded-full',
        ],
        'riverside' => [
            'imagePath' => Vite::asset("$logo_path/riverside-logo.webp"),
            'className' => 'riverside-logo-class rounded-full',
        ],
        'tripoint' => [
            'imagePath' => Vite::asset("$logo_path/tripoint-logo.webp"),
            'className' => 'tripoint-logo-class rounded-full',
        ],
        'trophy' => [
            'imagePath' => Vite::asset("$logo_path/trophy-logo.webp"),
            'className' => 'trophy-logo-class rounded-full',
        ],
    ];

    echo json_encode(['logos' => $logos, 'mainLogo' => $mainLogo]); // Logos
    ?>
     </script>
    <?php
});

/**
 * Configure Vite settings - adjusting for the actual directory structure
 */
add_action(
    'after_setup_theme',
    function () {
        Vite::useManifestFilename('manifest.json');
        Vite::useHotFile(get_template_directory() . '/public/hot');
    },
    10,
);

// Dequeue all Gutenberg styles
add_action(
    'wp_enqueue_scripts',
    function () {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('classic-theme-styles');
        wp_dequeue_style('wc-block-style');
        wp_dequeue_style('global-styles');
    },
    100,
);

/**
 * Register the theme assets with Vite integration.
 */
add_action(
    'wp_enqueue_scripts',
    function () {
        // Register a handle for localization and enqueue it
        wp_register_script('sage-data', '', [], null, true);
        wp_enqueue_script('sage-data');

        // Localize data including the nonce and REST URL
        wp_localize_script('sage-data', 'sageApiSettings', [
            'nonce' => wp_create_nonce('wp_rest'),
            'rest_url' => rest_url(),
        ]);

        if (Vite::isRunningHot()) {
            echo Vite::withEntryPoints(['resources/js/app.ts'])
                ->useStyleTagAttributes(['id' => 'sage-app-css'])
                ->toHtml();
            echo Vite::reactRefresh();
        } else {
            try {
                $jsEntrypoint = 'resources/js/app.ts';
                $cssEntrypoint = 'resources/css/app.css';

                wp_enqueue_script(
                    'sage/app.js',
                    get_template_directory_uri() .
                        '/public/assets/' .
                        basename(Vite::asset($jsEntrypoint)),
                    ['sage-data'], // Add sage-data as a dependency
                    null,
                    true,
                );

                wp_enqueue_style(
                    'sage/app.css',
                    get_template_directory_uri() .
                        '/public/assets/' .
                        basename(Vite::asset($cssEntrypoint)),
                    [],
                    null,
                );
            } catch (\Throwable $e) {
                error_log('Vite asset error: ' . $e->getMessage());
                // Fallback enqueues should also depend on sage-data if they use the nonce
                wp_enqueue_style(
                    'sage/app.css',
                    get_template_directory_uri() .
                        '/public/assets/app-8kQraylj.css',
                    [],
                    null,
                );
                wp_enqueue_script(
                    'sage/app.js',
                    get_template_directory_uri() .
                        '/public/assets/app-l0sNRNKZ.js',
                    ['sage-data'], // Add sage-data as a dependency
                    null,
                    true,
                );
            }
        }
    },
    100,
);

/**
 * Inject styles into the block editor.
 */
add_filter('block_editor_settings_all', function ($settings) {
    try {
        $editorCssPath = 'resources/css/editor.css';

        if (Vite::isRunningHot()) {
            $style = Vite::asset($editorCssPath);
            $settings['styles'][] = [
                'css' => "@import url('{$style}')",
            ];
        } else {
            $editorCssFile =
                get_template_directory() . '/public/assets/editor-D6Vq9HXg.css';
            if (file_exists($editorCssFile)) {
                $settings['styles'][] = [
                    'css' => file_get_contents($editorCssFile),
                ];
            }
        }
    } catch (\Throwable $e) {
        error_log('Vite editor CSS error: ' . $e->getMessage());
    }

    return $settings;
});

/**
 * Register editor assets with Vite integration.
 */
add_action('admin_enqueue_scripts', function () {
    if (! is_admin() || ! get_current_screen()?->is_block_editor()) {
        return;
    }

    if (Vite::isRunningHot()) {
        echo Vite::withEntryPoints(['resources/js/editor.js'])->toHtml();
        echo Vite::reactRefresh();
    } else {
        try {
            wp_enqueue_script(
                'sage/editor.js',
                get_template_directory_uri() .
                    '/public/assets/editor-C3PRZ95-.js',
                [],
                null,
                true,
            );

            wp_enqueue_style(
                'sage/editor.css',
                get_template_directory_uri() .
                    '/public/assets/editor-eKLvfQBY.css',
                [],
                null,
            );

            $depsFile =
                get_template_directory() .
                '/public/assets/editor.deps-DxpY22xl.json';
            if (file_exists($depsFile)) {
                $deps = json_decode(file_get_contents($depsFile), true) ?: [];
                foreach ($deps as $dep) {
                    wp_enqueue_script($dep);
                }
            }
        } catch (\Throwable $e) {
            error_log('Vite editor asset error: ' . $e->getMessage());
        }
    }
});

/**
 * Add Vite's HMR client to the block editor.
 */
add_action('enqueue_block_assets', function () {
    if (! is_admin() || ! get_current_screen()?->is_block_editor()) {
        return;
    }

    if (! Vite::isRunningHot()) {
        return;
    }

    $script = sprintf(
        <<<'JS'
window.__vite_client_url = '%s';

window.self !== window.top && document.head.appendChild(
    Object.assign(document.createElement('script'), { type: 'module', src: '%s' })
);
JS
        ,
        rtrim(file_get_contents(Vite::hotFile()), '/'),
        Vite::asset('@vite/client'),
    );

    wp_add_inline_script('wp-blocks', $script);
});

/**
 * Use the generated theme.json file.
 */
add_filter(
    'theme_file_path',
    function ($path, $file) {
        if (
            $file === 'theme.json' &&
            file_exists(get_template_directory() . '/public/assets/theme.json')
        ) {
            return get_template_directory() . '/public/assets/theme.json';
        }

        return $path;
    },
    10,
    2,
);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action(
    'after_setup_theme',
    function () {
        /**
         * Disable full-site editing support.
         *
         * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
         */
        remove_theme_support('block-templates');

        /**
         * Register the navigation menus.
         *
         * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
         */
        register_nav_menus([
            'primary_navigation' => __('Primary Navigation', 'sage'),
        ]);

        /**
         * Disable the default block patterns.
         *
         * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
         */
        remove_theme_support('core-block-patterns');

        /**
         * Enable plugins to manage the document title.
         *
         * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
         */
        add_theme_support('title-tag');

        /**
         * Enable post thumbnail support.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        /**
         * Enable responsive embed support.
         *
         * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#responsive-embedded-content
         */
        add_theme_support('responsive-embeds');

        /**
         * Enable HTML5 markup support.
         *
         * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
         */
        add_theme_support('html5', [
            'caption',
            'comment-form',
            'comment-list',
            'gallery',
            'search-form',
            'script',
            'style',
        ]);

        /**
         * Enable selective refresh for widgets in customizer.
         *
         * @link https://developer.wordpress.org/reference/functions/add_theme_support/#customize-selective-refresh-widgets
         */
        add_theme_support('customize-selective-refresh-widgets');
    },
    20,
);

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ];

    register_sidebar(
        [
            'name' => __('Primary', 'sage'),
            'id' => 'sidebar-primary',
        ] + $config,
    );

    register_sidebar(
        [
            'name' => __('Footer', 'sage'),
            'id' => 'sidebar-footer',
        ] + $config,
    );
});


add_action('init', function () {
    PostTypeFactory::registerAll();
}, 10);


// Add to functions.php or a custom plugin
add_filter('template_include', function($template) {
    // Check if we're on the services page
    if (is_page('services')) {
        // Path to your template relative to the theme directory
        $new_template = locate_template(['resources/views/template-services.blade.php']);
        if (!empty($new_template)) {
            return $new_template;
        }
    }
    return $template;
}, 99);
/**
 * Custom image processing
 */
// add_filter('wp_generate_attachment_metadata', function($metadata, $attachment_id) {
//     // Skip processing if not in admin or during API request
//     if (!is_admin() && !defined('REST_REQUEST')) {
//         return $metadata;
//     }

//     // Only process newly uploaded images
//     if (!empty($_POST['action']) && $_POST['action'] !== 'upload-attachment') {
//         return $metadata;
//     }

//     $processor = new ImageProcessor();
//     $result = $processor->process($attachment_id);

//     if (is_wp_error($result)) {
//         return $metadata;
//     }

//     return $result;
// }, 10, 2);

// Disable WordPress default image sizes generation
add_filter('intermediate_image_sizes_advanced', function($sizes) {
    return ['thumbnail' => $sizes['thumbnail']];
});


// Enqueue an admin-only script called 'resources/js/editor.ts'.

add_action('admin_enqueue_scripts', function() {
    if (is_admin()) {
        wp_enqueue_script(
            'sage/editor.js',
            get_template_directory_uri() . '/public/assets/' . basename(Vite::asset('resources/js/editor.ts')),
            [],
            null,
            true
        );
    }
}, 100);

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);
