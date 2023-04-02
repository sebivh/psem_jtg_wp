<?php
add_action('wp_head', 'generateCSSVariables');


add_action('customize_register', 'setup_controlls');
function setup_controlls( WP_Customize_Manager $wp_customize) {
	
	setup_sections( $wp_customize );

	/**
	 * 	Path of the JSON file where the Customizor is Configured
	 *  @var string */
	$datafile = get_stylesheet_directory() . '/functions/customizor.json';

	if( ! file_exists($datafile)) {
		return;
	}

	$controlls = json_decode( file_get_contents( $datafile));

	//Sets Up Settings and Controlls
	foreach ($controlls as $controll) {
		$section_name = 'sec_' . $controll->handle;
		$wp_customize->add_setting( $section_name, array(
			'default' =>  $controll->default,
			'transport' => 'refresh',
		));
		$wp_customize->add_control( 'con_' . $controll->handle, array(
			'label' => $controll->lable,
			'section' => $controll->section,
			'settings' => $section_name,
		));
	}
}

function setup_sections( WP_Customize_Manager $wp_customize ) {
	/*==============SECTIONS==============*/
	$wp_customize->add_section('sec_pagestyle', array(
		'title' => 'Pagestyle',
		'description' => 'Bearbeite den allgemeinen Stiel der Seite',
		'priority' => 50,
	));
	$wp_customize->add_section('sec_nav', array(
		'title' => 'Navigation',
		'description' => 'Bearbeite den Stiel der Navigation',
		'priority' => 40,
	));
	$wp_customize->add_section('sec_text', array(
		'title' => 'Text',
		'description' => 'Bearbeite allgemeine Einstellungen zum Text auf der Seite',
		'priority' => 60,
	));
	$wp_customize->add_section('sec_map', array(
		'title' => 'Karte',
		'description' => 'Bearbeite allgemeine Einstellungen zur Übersichtskarte',
		'priority' => 40,
	));
}

//================USER SELECTED CSS Variables====================
function generateCSSVariables()
{
	?>
<style>
	:root {
		--def-spacing: <?php echo get_theme_mod('set_def_spacing', '25px'); ?>;
		--def-text-color-normal: <?php echo get_theme_mod('set_def_text_color_normal', '#000000'); ?>;
		--def-text-color-accent: <?php echo get_theme_mod('set_def_text_color_accent', '#ffffff'); ?>;
		--def-text-font-size-normal: <?php echo get_theme_mod('set-def-font-size-normal', '14px'); ?>;
		--def-text-font-size-medium: <?php echo get_theme_mod('set-def-font-size-medium', '16px'); ?>;
		--def-text-font-size-large: <?php echo get_theme_mod('set-def-font-size-large', 'calc(var(--def-text-font-size-normal) * 4)'); ?>;
		--def-text-font-size-small: <?php echo get_theme_mod('set-def-font-size-small', '10px'); ?>;
		--def-link-color: <?php echo get_theme_mod('set-def-link-color', '#000000'); ?>;
		--def-link-color-visited: <?php echo get_theme_mod('set-def-link-color-visited', '#FF00FF'); ?>;
		--def-page-color: <?php echo get_theme_mod('set-def-page-color', '#FFFFFF'); ?>;
		--def-background-color: <?php echo get_theme_mod('set-def-background-color', '#FFFFFF'); ?>;
		--def-background-color-dark: <?php echo get_theme_mod('set-def-background-color-dark', '#000000'); ?>;
	}
	nav {
		--nav-logo-background: <?php echo get_theme_mod('set-nav-logo-background', '#6930c3cc'); ?>;
		--nav-logo-text-color: <?php echo get_theme_mod('set-nav-logo-text-color', '#FFFFFF'); ?>;
		--nav-logo-text-font-size: <?php echo get_theme_mod('set-nav-logo-text-font-size', 'var(--def-font-size-large)'); ?>;
		--nav-burger-size: <?php echo get_theme_mod('set-nav-burger-size', '1'); ?>;
		--nav-link-list-font-size: <?php echo get_theme_mod('set-nav-link-list-font-size', 'var(--def-font-size-large)'); ?>;
		--nav-link-list-background: <?php echo get_theme_mod('set-nav-link-list-background', '#6930c3cc'); ?>;
		--nav-link-list-background-hover: <?php echo get_theme_mod('set-nav-link-list-background-hover', '#7400b8cc'); ?>;
		--nav-link-list-text-color: <?php echo get_theme_mod('con_set_nav_link_list_text_color', '#FFFFFF'); ?>;
	}
	.map {
		--map-marker-size: <?php echo get_theme_mod('set-map-marker-size', '3'); ?>;
		--map-controlls-size: <?php echo get_theme_mod('set-map-controlls-size', '2'); ?>;
		--map-location-arrow-size: <?php echo get_theme_mod('set-map-location-arrow-size', '1'); ?>;
	}
</style>
<?php
}