<?php
/**
 * Page showing single content like a single WP Post or WP Site
 */
wp_enqueue_style('singular-style');
get_header();

echo '<h1>' . get_the_title() . '</h1>';

the_content();

get_footer();