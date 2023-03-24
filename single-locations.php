<?php

wp_enqueue_style('singular-style');
wp_enqueue_style('location-style');

get_header();
?>
<div class="cover">
	<span class="title"><?php the_title() ?></span>
	<?php
	if(has_post_thumbnail()){
		the_post_thumbnail();
	} else {
		echo "<img src='" . wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) , 'full' )[0] . "' alt= 'Custom Logo'>".PHP_EOL;
	}
	?>
	<?php
	$caption = get_the_post_thumbnail_caption();
	if ($caption !== '')
		echo '<span class="caption">', $caption, '</span>' . PHP_EOL;
	?>
</div>
<div class="metaDataDisplay">
	<?php
	$custom_keys = get_post_custom_keys();
	//Only execute if any Locations are available
	if(in_array('address', $custom_keys)) {
		$pin_theme = 'default';
		//Get the Pin Theme from the Custom Values
		if (in_array('map_pin_style', $custom_keys)) {
			$pin_theme = get_post_custom_values('map_pin_style', $post_id)[0];
		}
		$pin_url = get_theme_file_uri("assets\pictures\markers\marker-" . $pin_theme . ".svg");

		//Generate the HTML for all Locations
		$addresses = get_post_custom_values('address', $post_id);
		//Wrapper and Title
		$title = 'Adresse';
		if(count($addresses) > 1) {
			$title = 'Adressen';
		}
		echo '<div class="locations"><h1>' . $title . '</h1>';

		foreach ($addresses as $address) {
			//Check if address is an adress or an Array
			if(!(str_starts_with($address, '[') || str_starts_with($address, '{'))) {
				//Generating Google Maps Link https://developers.google.com/maps/documentation/urls/get-started
				$maps_link = 'https://www.google.com/maps/dir/?api=1&travelmode=walking&dir_action=navigate&destination=' . $address;
				//Echo to HTML
				echo '<div class="location">' . '<img src="' . $pin_url .'" alt="Pin">' . '<a target="_blank" rel="noopener" href="' . $maps_link . '">' . $address . '</a></div>';
			}
		  }
		echo '</div>';
	}
	?>
</div>
<?php
the_content();

get_footer();
