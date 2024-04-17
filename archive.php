<?php
/**
 * Enqueue necessary Page Style
 */
wp_enqueue_style('singular-style');

//echo Header
get_header();

/**
 * Get the IDs of all Post of type Locations
 */
$ids = array();
while(have_posts()) {
	$id = get_the_ID();
	array_push($ids, $id);
}

/**
 * Generate the content for the PostGallery Shortcode using the Post Shortcode
 */
$galleryContent = '';
foreach ($ids as $id) {
	$galleryContent .= '[post post_id=' . $id . ']';
}
?>
<div class="searchwrapper">
	<h1>Suche</h1>
	<span>Wir haben folgende Einträge gefunden:</span>
</div>
<?php echo do_shortcode('[postgallery]' . $galleryContent . '[/postgallery]'); ?>

<?php

//echo Footer
get_footer();