<?php
//Customize Presets
function setup_customize_register( $wp_customize ) {
	
	/* ==============SETTINGS============*/
	$wp_customize->add_setting('set_def_spacing', array(
		'default' =>  '25px',
		'transport' => 'refresh',
	));
	$wp_customize->add_setting('set_def_text_color_normal', array(
		'default' =>  '#000000',
		'transport' => 'refresh',
	));
	$wp_customize->add_setting('set_def_text_color_accent', array(
		'default' =>  '#ffffff',
		'transport' => 'refresh',
	));
	$wp_customize->add_setting('set-def-font-size-normal', array(
		'default' =>  '14px',
		'transport' => 'refresh',
	));
	$wp_customize->add_setting('set-def-font-size-medium', array(
		'default' =>  '16px',
		'transport' => 'refresh',
	));
	$wp_customize->add_setting('set-def-font-size-large', array(
		'default' =>  'calc(var(--def-text-font-size-normal) * 4)',
		'transport' => 'refresh',
	));
	$wp_customize->add_setting('set-def-font-size-small', array(
		'default' =>  '10px',
		'transport' => 'refresh',
	));
	$wp_customize->add_setting('set-def-link-color', array(
		'default' =>  '#000000',
		'transport' => 'refresh',
	));
	$wp_customize->add_setting('set-def-link-color-visited', array(
		'default' =>  '#FF00FF',
		'transport' => 'refresh',
	));
	$wp_customize->add_setting('set-def-page-color', array(
		'default' =>  '#FFFFFF',
		'transport' => 'refresh',
	));
	$wp_customize->add_setting('set-def-background-color', array(
		'default' =>  '#FFFFFF',
		'transport' => 'refresh',
	));
	$wp_customize->add_setting('set-def-background-color-dark', array(
		'default' =>  '#000000',
		'transport' => 'refresh',
	));
	$wp_customize->add_setting('set-nav-logo-background', array(
		'default' =>  '#6930c3cc',
		'transport' => 'refresh',
	));
	$wp_customize->add_setting('set-nav-logo-text-color', array(
		'default' =>  '#FFFFFF',
		'transport' => 'refresh',
	));
	$wp_customize->add_setting('set-nav-logo-text-font-size', array(
		'default' =>  'var(--def-font-size-large)',
		'transport' => 'refresh',
	));
	$wp_customize->add_setting('set-nav-burger-size', array(
		'default' =>  '1',
		'transport' => 'refresh',
	));
	$wp_customize->add_setting('set-nav-link-list-font-size', array(
		'default' =>  'var(--def-font-size-large)',
		'transport' => 'refresh',
	));
	$wp_customize->add_setting('set-nav-link-list-background', array(
		'default' =>  '#6930c3cc',
		'transport' => 'refresh',
	));
	$wp_customize->add_setting('set-nav-link-list-background-hover', array(
		'default' =>  '#7400b8cc',
		'transport' => 'refresh',
	));
	$wp_customize->add_setting('set-nav-link-list-text-color', array(
		'default' =>  '#FFFFFF',
		'transport' => 'refresh',
	));
	$wp_customize->add_setting('set-map-marker-size', array(
		'default' =>  '3',
		'transport' => 'refresh',
	));
	$wp_customize->add_setting('set-map-controlls-size', array(
		'default' =>  '2',
		'transport' => 'refresh',
	));
	$wp_customize->add_setting('set-map-location-arrow-size', array(
		'default' =>  '1',
		'transport' => 'refresh',
	));
	$wp_customize->add_setting('set-map-selectable-cities', array(
		'default' =>  '[{"title":"Passau", "address":"[48.57390609055261, 13.460523755393428]"},{"title":"Leopoldinum", "address":"Michaeligasse 15, 94032 Passau"},{"title":"Regensburg","address":"Regensburg"}]',
		'transport' => 'refresh',
	));


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

	/*=============CONTROLLS==============*/
	//Pagestyle
	$wp_customize->add_control('con_set_def_spacing', array(
		'label' => 'Standard Spaltmaße',
		'section' => 'sec_pagestyle',
		'settings' => 'set_def_spacing',
	));
	$wp_customize->add_control('con_set_def_page_color', array(
		'label' => 'Standard Seiten Hintergrundfarbe',
		'section' => 'sec_pagestyle',
		'settings' => 'set-def-page-color',
	));
	$wp_customize->add_control('con_set_def_background_color', array(
		'label' => 'Standard Hintererundfarbe',
		'section' => 'sec_pagestyle',
		'settings' => 'set-def-background-color',
	));
	$wp_customize->add_control('con_set_def_background_color_dark', array(
		'label' => 'Standard Dunkle Hintererundfarbe',
		'section' => 'sec_pagestyle',
		'settings' => 'set-def-background-color-dark',
	));

	//Nav
	$wp_customize->add_control('con_set_nav_logo_background', array(
		'label' => 'Logo Hintergrundfarbe',
		'section' => 'sec_nav',
		'settings' => 'set-nav-logo-background',
	));
	$wp_customize->add_control('con_set_nav_logo_text_font_size', array(
		'label' => 'Logo Font Größe',
		'section' => 'sec_nav',
		'settings' => 'set-nav-logo-text-font-size',
	));
	$wp_customize->add_control('con_set_nav_burger_size', array(
		'label' => 'Burger Size',
		'section' => 'sec_nav',
		'settings' => 'set-nav-burger-size',
	));
	$wp_customize->add_control('con_set_nav_link_list_font_size', array(
		'label' => 'Navigationsliste Font Größe',
		'section' => 'sec_nav',
		'settings' => 'set-nav-link-list-font-size',
	));
	$wp_customize->add_control('con_set_nav_link_list_background', array(
		'label' => 'Navigationsliste Hintergrundfarbe',
		'section' => 'sec_nav',
		'settings' => 'set-nav-link-list-background',
	));
	$wp_customize->add_control('con_set_nav_link_list_background_hover', array(
		'label' => 'Navigationsliste Hover Hintergrundfarbe',
		'section' => 'sec_nav',
		'settings' => 'set-nav-link-list-background-hover',
	));
	$wp_customize->add_control('con_set_nav_logo_text_color', array(
		'label' => 'Logo Text Farbe',
		'section' => 'sec_nav',
		'settings' => 'set-nav-logo-text-color',
	));
	$wp_customize->add_control('con_set_nav_link_list_text_color', array(
		'label' => 'Navigationsliste Text Farbe',
		'section' => 'sec_nav',
		'settings' => 'set-nav-link-list-text-color',
	));

	//Text
	$wp_customize->add_control('con_set_def_text_color', array(
		'label' => 'Text Farbe',
		'section' => 'sec_text',
		'settings' => 'set_def_text_color_normal'
	));
	$wp_customize->add_control('con_set_def_text_accent', array(
		'label' => 'Text Akzent Farbe',
		'section' => 'sec_text',
		'settings' => 'set_def_text_color_accent'
	));
	$wp_customize->add_control('con_set_def_font_size_normal', array(
		'label' => 'Standard Font Größe',
		'section' => 'sec_text',
		'settings' => 'set-def-font-size-normal',
	));
	$wp_customize->add_control('con_set_def_font_size_medium', array(
		'label' => 'Mittlere Font Größe',
		'section' => 'sec_text',
		'settings' => 'set-def-font-size-medium',
	));
	$wp_customize->add_control('con_set_def_font_size_large', array(
		'label' => 'Große Font Größe',
		'section' => 'sec_text',
		'settings' => 'set-def-font-size-large',
	));
	$wp_customize->add_control('con_set_def_font_size_small', array(
		'label' => 'Kleine Font Größe',
		'section' => 'sec_text',
		'settings' => 'set-def-font-size-small',
	));
	$wp_customize->add_control('con_set_def_link_color', array(
		'label' => 'Link Farbe',
		'section' => 'sec_text',
		'settings' => 'set-def-link-color',
	));
	$wp_customize->add_control('con_set_def_link_color_visited', array(
		'label' => 'Besuchter Link Farbe',
		'section' => 'sec_text',
		'settings' => 'set-def-link-color-visited',
	));

	//Map
	$wp_customize->add_control('con_set_map_marker_size', array(
		'label' => 'Marker Größe',
		'section' => 'sec_map',
		'settings' => 'set-map-marker-size',
	));
	$wp_customize->add_control('con_set_map_controlls_size', array(
		'label' => 'Steuerelemente Größe',
		'section' => 'sec_map',
		'settings' => 'set-map-controlls-size',
	));
	$wp_customize->add_control('con_set_map_location_arrow_size', array(
		'label' => 'Standort Kompassadel Größe',
		'section' => 'sec_map',
		'settings' => 'set-map-location-arrow-size',
	));
	$wp_customize->add_control('con_set_map_selectable_cities', array(
		'label' => 'Städte (in JSON)',
		'section' => 'sec_map',
		'settings' => 'set-map-selectable-cities',
	));
}
add_action('customize_register', 'setup_customize_register');

//================USER SELECTED CSS Variables====================
function generateCSSVariables() {
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
		--map-marker-size: <?php echo get_theme_mod('set-map-marker-size', '3');?>;
		--map-controlls-size: <?php echo get_theme_mod('set-map-controlls-size', '2');?>;
		--map-location-arrow-size: <?php echo get_theme_mod('set-map-location-arrow-size', '1');?>;
	}
</style>
<?php
}
add_action('wp_head', 'generateCSSVariables');