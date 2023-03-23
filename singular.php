<?php
/**
 * Page showing single content like a single WP Post or WP Site
 */
wp_enqueue_script('component-audio-script');
wp_enqueue_style('singular-style');
wp_enqueue_style('component-audio-style');
get_header();

echo '<h1>' . get_the_title() . '</h1>';

the_content();

get_footer();