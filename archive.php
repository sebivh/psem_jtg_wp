<?php
wp_enqueue_style('singular-style');

get_header();

$ids = array();

while(have_posts()) {
	$id = get_the_ID(the_post());
	array_push($ids, $id);
}

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
get_footer();