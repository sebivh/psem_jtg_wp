<?php
/**
 * Enqueue necessary Styles for Page Styling
 */
wp_enqueue_style('component-timeline-style');
wp_enqueue_style('singular-style');
wp_enqueue_script('component-timeline-script');

//echo Header
get_header();

/**
 * Creates a Query to search for all Posts of the Location-Type that have a Date Custom Attribute
 */
$query = get_query( (int) $properties['location_post_id']);

$ids = array();
while(have_posts()) {
    the_post();
    $id = get_the_ID();
    $keys = get_post_custom_keys($id);
    if (in_array('date', $keys)) {
        array_push($ids, $id);
    }
}

/**
 * Print the found Posts on a Timeline using the Theme Timeline Shortcode
 */

echo apply_shortcodes('[timeline post_ids="' . implode(",", $ids) . '"]');


//echo Footer
get_footer();