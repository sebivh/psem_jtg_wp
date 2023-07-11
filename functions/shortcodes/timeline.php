<?php
function timeline_shortcode($atts = [], $content = null, $tag = '') {
    // normalize attribute keys, lowercase
	$atts = array_change_key_case( (array) $atts, CASE_LOWER );

	// override default attributes with user attributes
	$properties = shortcode_atts(
		array(
			'show_dates' => 'true',
			'show_title' => 'true',
			'post_ids' => '',
		), $atts, $tag
	);

    //Creating a array of all Post Id's
    $post_ids = explode(',', $properties['post_id']);

    //Include Style and Script
    wp_enqueue_style('component-timeline-style');
    wp_enqueue_script('component-timeline-script');

    $mappedDates = mapDates($post_ids);

    $sorted = sortDates($mappedDates);

    $o = createTimelineHTML($sorted, $mappedDates, $properties['show_dates'] == 'true', $properties['show_title'] == 'true');

    return $o;
}
add_shortcode('timeline', 'timeline_shortcode');#

function mapDates(Array $post_ids) {
    $o = array();

    //Check if any Ids are provided if not, query for locations
    if($post_ids[0] == '') {

        $args = array(
            'posts_per_page'   => -1,
            'post_status' => 'publish',
            'post_type' => 'locations',
        );
        $query = new WP_Query( $args );

        while ($query->have_posts()) {

            //Iterate Query
            $query->the_post();
    
            //Setting Post ID
            $post_id = get_the_ID();
    
            //All Custom Values that are set
            $custom_keys = get_post_custom_keys($post_id);
    
            //Continue in Loop only if Addresses are not set
            if(!in_array('date', $custom_keys))
                continue;

            array_push($post_ids, $post_id);
        }
    }

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

function createTimelineHTML($sorted, $mappedDates, bool $showDates, bool $showTitle) {
    $o = '<div class="timeline">' . PHP_EOL;

    if($showTitle)
        $o .= '<h1>Timeline:</h1>' . PHP_EOL;

    $o .= '<div class="posts-container">' . PHP_EOL
            . '<div class="arrow">' . PHP_EOL
                . '<div class="arrowHead"></div>' . PHP_EOL
            . '</div>' . PHP_EOL;

    foreach($sorted as $date) {
        $o .= '<a href="' . get_the_permalink($mappedDates[$date]) . '" class="tl-post">' . PHP_EOL;

        if($showDates)
            $o .= '<span class="date">' . $date . '</span>' . PHP_EOL;

        $o .= '<h1 class="title">' . get_the_title($mappedDates[$date]) . '</h1>' . PHP_EOL
        // . '<p class="excerpt">' . get_the_excerpt($mappedDates[$date]) . '</p>' . PHP_EOL
        . '</a>' . PHP_EOL;
    }

    $o .= '</div>
    </div>' . PHP_EOL;
    return $o;
}