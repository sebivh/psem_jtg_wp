<?php
add_shortcode('characteristic', 'characteristic_shortcode');
function characteristic_shortcode($atts = [], $content = null, $tag = ''){
    // normalize attribute keys, lowercase
	$atts = array_change_key_case( (array) $atts, CASE_LOWER );
	// override default attributes with user attributes
	$properties = shortcode_atts(
		array(
            'user_id' => -1,
            'name' => '',
            'picture_url' => get_theme_file_uri('assets/pictures/defaultAvatar.svg'),
		), $atts, $tag
	);

    //Enque Style
    wp_enqueue_style('component-characteristic-style');

    //Override Properties with User Data if real User is specified
    $userData = get_userdata($properties['user_id']);

    if($userData != false) {
        //Set Name
        $properties['name'] = $userData->display_name;


        //Set Picture
        $avUrl = get_avatar_url($properties['user_id']);
        
        //Only set the URL to the Avatra if its not a gravatar generated Avatar
        if(!str_contains($avUrl, 'secure.gravatar.com/avatar')) {
            $properties['picture_url'] = $avUrl;
        }
    
    }

    $o = '<div class="characteristic">';
    $o .= '<img src="' . $properties['picture_url'] . '">';
    $o .= '<h1>' . $properties['name'] . '</h1>';
    $o .= '</div>';

    return $o;
}