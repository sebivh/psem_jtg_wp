<?php

wp_enqueue_style('singular-style');
wp_enqueue_style('location-style');

get_header();
?>
<div class="cover">
	<h1 class="title"><?php the_title() ?></h1>
	<div class="thumbnail-container">
	<?php
	if(has_post_thumbnail()){
		the_post_thumbnail();
	} else {
		echo '<img src="' . wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) , 'full' )[0] . '" alt= "Custom Logo">'.PHP_EOL;
	}
	?>
	<?php
	$caption = get_the_post_thumbnail_caption();
	if ($caption !== '')
		echo '<span class="caption">', $caption, '</span>' . PHP_EOL;
	?>
	</div>
</div>

<?php
# Displaying the Content
the_content();
?>

<div class="metaDataDisplay">
	<?php
	//https://developer.mozilla.org/en-US/docs/Learn/Forms/Sending_and_retrieving_form_data
	$custom_keys = get_post_custom_keys();
	//Only execute if any Locations are available
	if(in_array('address', $custom_keys)) {
		//If User comes from the Map an Attribute with the Address is passed and format it
		$addressAttribute = str_replace('_', ' ', filter_input(INPUT_GET, 'address'));
		$hasAddressAttribute = ($addressAttribute != "");

		//Get the Pin Theme from the Custom Values
		$pin_theme = 'default';
		if (in_array('map_pin_style', $custom_keys)) {
			$pin_theme = get_post_custom_values('map_pin_style', $post_id)[0];
		}
		$pin_url = get_theme_file_uri("assets\pictures\markers\marker-" . $pin_theme . ".svg");

		//Generate the HTML for all Locations
		$addresses = get_post_custom_values('address', $post_id);
		//Wrapper and Title
		$title = 'Adressen';
		if(count($addresses) == 1 || $hasAddressAttribute) {
			$title = 'Adresse';
		}

		echo '<div class="locations"><h1>' . $title . '</h1>' . PHP_EOL;
		echo '<span class="description">Klicke auf die ' . $title . ' um die Navigation über Google Maps zu starten</span>';

		foreach ($addresses as $address) {

			$isArray = str_starts_with($address, '[') || str_starts_with($address, '{');
			$attributeIsAddress = ($addressAttribute == $address);

			//Check if address is an address or an Array and Checks if the address is the address from the Attribute. If it is, only shows this Address
			if(!$isArray) {
				//If an Address is specified and the Address is not the Specified Address it is not shown
				if($hasAddressAttribute & !$attributeIsAddress) {
					continue;
				}
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
<h2>Weitere Artikel</h2>
<?php

$this_post_id = $post->ID;

$query = new WP_Query(array(
	'post_type' => 'locations',
	'post_status' => 'publish',
	'posts_per_page' => -1,
));

$c = '';

while($query->have_posts()) {
    $query->the_post();
    $id = get_the_ID();
	if($id != $this_post_id) {
		$c .='[post post_id=' . $id . ']';
	}
}

echo(do_shortcode('[postgallery]' . $c . '[/postgallery]'));

?>
<script>

// Determines if the passed element is overflowing its bounds,
// either vertically or horizontally.
// Will temporarily modify the "overflow" style to detect this
// if necessary.
function checkOverflow(el)
{
   var curOverflow = el.style.overflow;

   if ( !curOverflow || curOverflow === "visible" )
      el.style.overflow = "hidden";

   var isOverflowing = el.clientWidth  < el.scrollWidth

   el.style.overflow = curOverflow;

   return isOverflowing;
}

h1 = document.querySelector('.title')

while (checkOverflow(h1)) {
	fontS = window.getComputedStyle(h1, null).getPropertyValue('font-size')
	h1.style.fontSize = parseInt(fontS.replace('px', '')) - 1 + 'px'
	console.log(parseInt(fontS.replace('px', '')) - 1 + 'px');
}


</script>

<?php
get_footer();
