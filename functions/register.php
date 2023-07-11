<?php

/**
 * Registers all Styles so they can be enqueued when needed
 * @return void
 */
function register_styles() {
	wp_register_style('main-style', get_stylesheet_uri());
	wp_register_style('component-audio-style', get_theme_file_uri("assets/styles/audio.css"));
	wp_register_style('header-style', get_theme_file_uri("assets/styles/header.css"));
	wp_register_style('location-style', get_theme_file_uri("assets/styles/location.css"));
	wp_register_style('ueber-uns-style', get_theme_file_uri("assets/styles/ueber-uns.css"));
	wp_register_style('component-map-style', get_theme_file_uri("assets/styles/map.css"));
	wp_register_style('component-postCard-style', get_theme_file_uri("assets/styles/postCard.css"));
	wp_register_style('component-postGallery-style', get_theme_file_uri("assets/styles/postGallery.css"));
	wp_register_style('component-timeline-style', get_theme_file_uri("assets/styles/timeline.css"));
	wp_register_style('component-characteristic-style', get_theme_file_uri("assets/styles/characteristic.css"));
	wp_register_style('singular-style', get_theme_file_uri("assets/styles/singular.css"));
	wp_register_style('leaflet-main-style', 'https://unpkg.com/leaflet@1.9.3/dist/leaflet.css');
	wp_register_style('leaflet-location-style', 'https://cdn.jsdelivr.net/npm/leaflet.locatecontrol/dist/L.Control.Locate.min.css');
}
add_action('init', 'register_styles');

/**
 * Registers all Scripts so they can be enqueued when needed
 * @return void
 */
function register_scripts() {
	wp_register_script('jtg-script', get_theme_file_uri("assets/js/jtg.js"), array(), false, false);
	wp_register_script('component-audio-script', get_theme_file_uri("assets/js/audio.js"), array(), false, true);
	wp_register_script('header-script', get_theme_file_uri("assets/js/header.js"), array(), false, true);
	wp_register_script('component-postGallery-script', get_theme_file_uri("assets/js/postGallery.js"), array(), false, true);
	wp_register_script('component-map-script', get_theme_file_uri("assets/js/map.js"), array(), false, true);
	wp_register_script('component-timeline-script', get_theme_file_uri("assets/js/timeline.js"), array(), false, true);
	wp_register_script('leaflet-main-script', 'https://unpkg.com/leaflet@1.9.3/dist/leaflet.js', array(), false, false);
	wp_register_script('leaflet-location-script', 'https://cdn.jsdelivr.net/npm/leaflet.locatecontrol/dist/L.Control.Locate.min.js', array(), false, false);
}
add_action('init', 'register_scripts');