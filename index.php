<?php
/**
 * Main Themes php, the lowest point in the hierarchy, every thing leads here
 */
//echo header
get_header();

$i = 0;
echo("<hr>");
while (have_posts()) {
	$i++;
	echo "<h1>" . $i . ":";
	printPost(get_post(the_post()));
}

echo("<hr><span><b>Das waren alle Posts!</b></span>");

function printPost($post) {
	echo(" Ein Toller Post namens " . get_the_title($post) . "</h1><span>" . get_the_content($post) . "</span>");
}
get_footer();