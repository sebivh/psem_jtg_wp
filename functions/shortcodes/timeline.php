<?php
function timeline_shortcode($atts = [], $content = null, $tag = '') {
    // normalize attribute keys, lowercase
	$atts = array_change_key_case( (array) $atts, CASE_LOWER );

	// override default attributes with user attributes
	$properties = shortcode_atts(
		array(
			'show_dates' => 'true',
			'post_id' => null,
		), $atts, $tag
	);

    //Creating a array of all Post Id's
    $post_ids = explode(',', $properties['post_id']);

    //Include Style and Script
    wp_enqueue_style('component-timeline-style');
    wp_enqueue_script('component-timeline-script');

    $mappedDates = mapDates($post_ids);

    $sorted = sortDates($mappedDates);

    $o = createTimelineHTML($sorted, $mappedDates);

    return $o;
}
add_shortcode('timeline', 'timeline_shortcode');#

function mapDates(Array $post_ids) {
    $o = array();
    foreach ($post_ids as $id) {
        $date = get_post_custom_values('date', $id)[0];
        $o[$date] = $id;
    }
    return $o;
}

function sortDates(Array $mappedDates) {
    $dates = array_keys($mappedDates);

    sort($dates, SORT_NUMERIC);

    return $dates;
}

function createTimelineHTML($sorted, $mappedDates) {
    $o = '<div class="timeline">' . PHP_EOL
        . '<h1>Timeline:</h1>' . PHP_EOL
        . '<div class="posts-container">' . PHP_EOL
            . '<div class="arrow">' . PHP_EOL
                . '<div class="arrowHead"></div>' . PHP_EOL
            . '</div>' . PHP_EOL;

    foreach($sorted as $date) {
        $o .= '<a href="' . get_the_permalink($mappedDates[$date]) . '" class="tl-post">' . PHP_EOL
        . '<span class="date">' . $date . '</span>' . PHP_EOL
        . '<h1 class="title">' . get_the_title($mappedDates[$date]) . '</h1>' . PHP_EOL
        // . '<p class="excerpt">' . get_the_excerpt($mappedDates[$date]) . '</p>' . PHP_EOL
        . '</a>' . PHP_EOL;
    }

    $o .= '</div>
    </div>' . PHP_EOL;
    return $o;
}