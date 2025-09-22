<?php
/**
 * Script to programmatically create 'featured-project' posts
 * and populate their Meta Box fields.
 *
 * How to use:
 * 1. Place this file in your WordPress theme's root directory (e.g., /wp-content/themes/your-theme/create-featured-projects.php).
 * 2. Make sure you are logged in as an administrator.
 * 3. Access this script directly via your browser: yoursite.com/wp-content/themes/your-theme/create-featured-projects.php
 * 4. IMPORTANT: Remove or rename this file after use to prevent accidental re-runs.
 * 5. NOTE: This script does NOT handle image uploads. You will need to manually upload images
 *    based on the provided prompts and set them as the 'Featured image' for each created project.
 * 6. NOTE: This script assumes the Meta Box plugin is active.
 */

// Bootstrap WordPress
require_once(dirname(__FILE__) . '/web/wp/wp-load.php'); // Adjust the path depth if needed

// Set current user to admin for testing purposes

$current_user = get_user_by('login', 'sandoval'); // Replace 'admin' with your admin username
if ($current_user) {
	wp_set_current_user($current_user->ID);
}

if (!current_user_can('manage_options')) {
    wp_die('You do not have sufficient permissions to access this page.');
}

// Check if Meta Box function exists
if (!function_exists('rwmb_set_meta')) {
    wp_die('Meta Box plugin is not active. Please activate it before running this script.');
}

$featured_projects_data = [
    [
        'category' => 'Residential',
        'title' => 'Hillside Haven Transformation',
        'description' => 'Complete residential landscape redesign featuring drought-resistant native plants, custom hardscaping, and integrated outdoor lighting system for a challenging sloped property.',
        'image_prompt' => 'Beautifully terraced garden with stone steps, native plantings, and subtle evening lighting creating an inviting outdoor living space.',
    ],
    [
        'category' => 'Commercial',
        'title' => 'Corporate Campus Green Initiative',
        'description' => 'Sustainable landscape renovation for tech company headquarters incorporating rainwater harvesting, pollinator gardens, and employee wellness zones with edible plantings.',
        'image_prompt' => 'Modern office building surrounded by thoughtfully designed green spaces with employees enjoying outdoor meeting areas amid lush sustainable plantings.',
    ],
    [
        'category' => 'Public Spaces',
        'title' => 'Riverfront Park Revitalization',
        'description' => 'Urban park restoration project featuring flood-resistant landscaping, accessible pathways, community gathering spaces, and educational native plant installations.',
        'image_prompt' => 'Vibrant park scene along a riverbank with winding pathways, strategic plantings, and people enjoying various recreational zones.',
    ],
    [
        'category' => 'Water Conservation',
        'title' => 'Desert Bloom Xeriscape Design',
        'description' => 'Water-wise landscape conversion replacing traditional lawn with artfully arranged drought-tolerant plants, efficient drip irrigation, and decorative gravel hardscaping.',
        'image_prompt' => 'Colorful desert garden featuring diverse cacti, succulents, and flowering native plants arranged among natural stone elements with minimal water requirements.',
    ],
    [
        'category' => 'Ecological Restoration',
        'title' => 'Woodland Habitat Recovery Project',
        'description' => 'Degraded woodland restoration implementing invasive species removal, native understory reestablishment, and wildlife habitat enhancement across five acres.',
        'image_prompt' => 'Thriving woodland scene showing diverse native plantings at various heights with evidence of returning wildlife and healthy ecosystem functions.',
    ],
    [
        'category' => 'Urban Gardens',
        'title' => 'Skyline Terrace Rooftop Garden',
        'description' => 'High-rise residential rooftop transformation featuring lightweight container gardens, vertical growing systems, weather-resistant furnishings, and automated irrigation.',
        'image_prompt' => 'Lush urban rooftop garden with city skyline backdrop, showing container plantings, vertical garden walls, and comfortable seating areas.',
    ],
    [
        'category' => 'Edible Landscapes',
        'title' => 'Community Harvest Design Program',
        'description' => 'Productive landscape redesign for neighborhood association integrating fruit trees, communal vegetable gardens, herb spirals, and educational signage throughout common areas.',
        'image_prompt' => 'Vibrant community garden space showing diverse food plants, gathering areas, and residents actively harvesting fresh produce together.',
    ],
    [
        'category' => 'Stormwater Management',
        'title' => 'RainWise Watershed Solution',
        'description' => 'Comprehensive stormwater management landscaping featuring rain gardens, permeable pavements, bioswales, and constructed wetlands reducing flooding while creating beautiful spaces.',
        'image_prompt' => 'Strategic landscape design during rainfall showing how water is captured in artfully designed rain gardens and flowing through naturalistic bioswales.',
    ],
    [
        'category' => 'Therapeutic Gardens',
        'title' => 'Healing Grounds Sensory Garden',
        'description' => 'Accessible therapeutic landscape for healthcare facility featuring sensory-rich plant selections, elevated planting beds, wheelchair-accessible pathways, and calm reflection spaces.',
        'image_prompt' => 'Thoughtfully designed garden space with patients and staff experiencing various sensory elements through accessible gardening features and comfortable seating areas.',
    ],
    [
        'category' => 'Vertical Landscaping',
        'title' => 'GreenWall Living Architecture',
        'description' => 'Large-scale vertical garden installation for urban retail development incorporating automated irrigation, remote monitoring, and seasonal rotation of over 3,000 plants.',
        'image_prompt' => 'Dramatic living wall covering a building exterior with lush, diverse plantings creating a stunning visual impact in an otherwise concrete urban environment.',
    ],
    [
        'category' => 'Historic Preservation',
        'title' => 'Heritage Garden Restoration',
        'description' => 'Authentic restoration of historic property gardens based on archival research, featuring period-appropriate plant selections, traditional layout, and historically accurate features.',
        'image_prompt' => 'Meticulously maintained formal garden with symmetrical design, heirloom plants, and traditional hardscape elements reflecting historical landscape architecture.',
    ],
    [
        'category' => 'Smart Irrigation',
        'title' => 'WaterWise Automation System',
        'description' => 'Next-generation irrigation management implementation using soil moisture sensors, weather data integration, zone-specific controls, and mobile monitoring for optimal water conservation.',
        'image_prompt' => 'Modern landscape with discreetly placed smart irrigation components and thriving plants despite minimal water usage, showing real-time monitoring dashboard on mobile device.',
    ],
];

echo "<h1>Creating Featured Projects...</h1>";
echo "<ol>";

foreach ($featured_projects_data as $index => $project_data) {
    $post_title = $project_data['title'];
    $post_category = $project_data['category'];
    $post_description = $project_data['description'];
    $display_order = $index + 1; // Start order from 1

    // Check if a post with the same title already exists
    $existing_post = null;
    $query = new WP_Query(
        array(
            'post_type' => 'featured-project',
            'title' => $post_title,
            'post_status' => 'any',
            'posts_per_page' => 1,
        )
    );
    
    if ($query->have_posts()) {
        $existing_post = $query->posts[0];
        echo "<li>Skipped: Featured Project '{$post_title}' already exists (ID: {$existing_post->ID}).</li>";
        continue;
    }

    // Prepare post data
    $new_post = [
        'post_title'   => $post_title,
        'post_content' => '', // Content is handled by custom fields
        'post_status'  => 'publish',
        'post_author'  => get_current_user_id(),
        'post_type'    => 'featured-project',
    ];

    // Insert the post into the database
    $post_id = wp_insert_post($new_post);

    if (is_wp_error($post_id)) {
        echo "<li style='color: red;'>Error creating '{$post_title}': " . $post_id->get_error_message() . "</li>";
    } elseif ($post_id) {
        // Post created successfully, now update Meta Box fields
        rwmb_set_meta($post_id, 'featured_project_category', $post_category);
        rwmb_set_meta($post_id, 'featured_project_description', $post_description);
        rwmb_set_meta($post_id, 'featured_project_link', ''); // Set link to empty initially
        rwmb_set_meta($post_id, 'featured_project_order', $display_order);

        echo "<li>Created: '{$post_title}' (ID: {$post_id}) with order {$display_order}. Category: {$post_category}. Remember to set the featured image.</li>";
    } else {
        echo "<li style='color: red;'>Error creating '{$post_title}': Unknown error.</li>";
    }
}

echo "</ol>";
echo "<h2>Featured Project creation process finished.</h2>";
echo "<p><strong>Important:</strong> Please manually upload images based on the prompts and set the 'Featured image' for each project created above. Also, remember to remove or rename this script file (<code>create-featured-projects.php</code>) from your theme directory.</p>";
