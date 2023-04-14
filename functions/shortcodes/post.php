<?php
function post_shortcode($atts = [], $content = null, $tag = ''){
	// normalize attribute keys, lowercase
	$atts = array_change_key_case( (array) $atts, CASE_LOWER );
	// override default attributes with user attributes
	$properties = shortcode_atts(
		array(
			'post_id' => 0,
		), $atts, $tag
	);
	//returns if no Post is specified
	if($properties['post_id'] === 0){
		return;
	}
	//Enqueue Styles for Post-Card
	wp_enqueue_style('component-postCard-style');
	//
	setup_postdata( $properties['post_id'] );
	//Open Wrapper
	$o = '<a href="' . get_the_permalink($properties['post_id']) . '" class="post-card">' . PHP_EOL;
	//Thumbnail if it exists
	if(has_post_thumbnail($properties['post_id'])) {
		$o .= '<div class="image-wrapper">' . PHP_EOL;
		$o .= '<img src="' . get_the_post_thumbnail_url($properties['post_id']) . '" alt="Thumbnail">' . PHP_EOL;
		$o .= '</div>' . PHP_EOL;
	}
	//Content
	$o .= '<span>' . PHP_EOL;
	//Title
	$o .= '<h1>' . get_the_title($properties['post_id']) . '</h1>' . PHP_EOL;
	$o .= '<p>' . get_the_excerpt($properties['post_id']) . '</p>' . PHP_EOL;
	$o .= '</span>' . PHP_EOL;
	//close wrapper
	$o .= '</a>' . PHP_EOL;
	//return
	return $o;
}
add_shortcode('post', 'post_shortcode');