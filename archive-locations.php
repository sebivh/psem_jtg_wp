<?php
// wp_enqueue_style('singular-style');
wp_enqueue_style('component-timeline-style');
wp_enqueue_style('singular-style');
wp_enqueue_script('component-timeline-script');
get_header();

//Get Query
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

echo apply_shortcodes('[timeline post_ids="' . implode(",", $ids) . '"]');

get_footer();

?>