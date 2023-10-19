<?php
function postgallery_shortcode($atts = [], $content = null, $tag = ''){
	// Return nothing if there is no content
	if($content == null){
		return'';
	}
	//Enqueue Scripts and Styles
	wp_enqueue_style('component-postGallery-style');
	wp_enqueue_script('component-postGallery-script');
	//Open Gallery
	$o .= '<div class="postgallery">' . PHP_EOL;
	$arrowPath = get_theme_file_uri('assets/pictures/arrow.svg');
	$o .= "\t" . '<button class="arrow right" aria-label="Left Arrow" aria-expanded="true"><img src="' . $arrowPath . '" alt=">"></button>' . PHP_EOL;
	$o .= "\t" .'<button class="arrow left" aria-label="Right Arrow" aria-expanded="true"><img src="' . $arrowPath . '" alt=">"></button>' . PHP_EOL;
	//Open wrapper
	$o .= "\t\t" .'<div class="postwrapper">' . PHP_EOL;
	//Insert Content ([post]-shortcodes between opening and closing Tags)
	$o .= "\t\t\t" .do_shortcode( $content ) . PHP_EOL;
	//Close Wrapper
	$o .= "\t\t" .'</div>' . PHP_EOL;
	//Close Gallery
	$o .= "\t" . '</div>' . PHP_EOL;
	return $o;
}
add_shortcode('postgallery', 'postgallery_shortcode');