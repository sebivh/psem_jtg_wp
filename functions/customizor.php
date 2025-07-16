<?php
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

	//Reads all Controls written in customizor.json
	$controlls = json_decode( file_get_contents( $datafile));

	//Sets Up Settings and Controls
	foreach ($controlls as $controll) {
		$wp_customize->add_setting( 'set-' . $controll->handle, array(
			'default' =>  $controll->default,
			'transport' => 'refresh',
		));

		switch ($controll->type) {
			case 'color':
				createColorControll($wp_customize, $controll);
				break;
			case 'range':
				createRangeControll($wp_customize, $controll);
				break;
			case 'textarea':
				createTextareaControll($wp_customize, $controll);
				break;
			case 'checkbox':
				createCheckboxControll($wp_customize, $controll);
				break;
			default:
				createDefaultControll($wp_customize, $controll);
				break;
		}
	}
}

function createTextareaControll( WP_Customize_Manager $wp_customize, $controll) {
	$wp_customize->add_control( 'con-' . $controll->handle, array(
		'type' => 'textarea',
		'label' => $controll->label,
		'description' => $controll->description,
		'section' => $controll->section,
		'settings' => 'set-' . $controll->handle,
	));
}
function createDefaultControll( WP_Customize_Manager $wp_customize, $controll) {
	$wp_customize->add_control( 'con-' . $controll->handle, array(
		'label' => $controll->label,
		'description' => $controll->description,
		'section' => $controll->section,
		'settings' => 'set-' . $controll->handle,
	));
}
function createCheckboxControll( WP_Customize_Manager $wp_customize, $controll) {
	$wp_customize->add_control( 'con-' . $controll->handle, array(
		'type' => 'checkbox',
		'label' => $controll->label,
		'description' => $controll->description,
		'section' => $controll->section,
		'settings' => 'set-' . $controll->handle,
	));
}
function createRangeControll( WP_Customize_Manager $wp_customize, $controll) {
	$wp_customize->add_control( 'con-' . $controll->handle, array(
		'type' => 'range',
		'label' => $controll->label,
		'description' => $controll->description,
		'section' => $controll->section,
		'settings' => 'set-' . $controll->handle,
		'input_attrs' => array(
			'min' => $controll->range->min,
			'max' => $controll->range->max,
			'step' => $controll->range->step,
		  ),
	));
}

function createColorControll( WP_Customize_Manager $wp_customize, $controll ) {
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'con-' . $controll->handle, array(
		'label' => $controll->label,
		'description' => $controll->description,
		'section' => $controll->section,
		'settings' => 'set-' . $controll->handle,
	  ) ) );
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
	$wp_customize->add_section('sec_audio', array(
		'title' => 'Audio Player',
		'description' => 'Bearbeite Einstellungen zu Individuellem Audio Player der Website',
		'priority' => 40,
	));
	$wp_customize->add_section('sec_poststyle', array(
		'title' => 'Beiträgs Seiten Stiel',
		'description' => 'Bearbeite das Aussehen der Beitragseiten.',
		'priority' => 40,
	));
	$wp_customize->add_section('sec_locationstyle', array(
		'title' => 'Orts Seiten Stil',
		'description' => 'Bearbeite das Aussehen der Ortsseiten.',
		'priority' => 40,
	));
	$wp_customize->add_section('sec_gallarystyle', array(
		'title' => 'Gallery Stiel',
		'description' => 'Bearbeite das Aussehen der Gallery.',
		'priority' => 40,
	));
}
//================USER SELECTED CSS Variables====================
add_action('wp_head', 'generateCSSVariables');
function generateCSSVariables() {

	/**
	 * 	Path of the JSON file where the Customizor is Configured
	 *  @var string */
	$datafile = get_stylesheet_directory() . '/functions/customizor.json';

	if( ! file_exists($datafile)) {
		return;
	}

	$controlls = json_decode( file_get_contents( $datafile));

	echo '<style>' . PHP_EOL;
	echo ':root {' . PHP_EOL;

	//Prints all Controll in CSS
	foreach ($controlls as $controll) {
		//Only output Var as CSS if CSS is not set to false
		if(!property_exists($controll, 'print') || $controll->print == true) {
			$output = get_theme_mod('set-' . $controll->handle, $controll->default);
	
			if( property_exists($controll, 'outputSuffix')) {
				$output .= $controll->outputSuffix;
			}
	
			echo '--' . $controll->handle . ':' . $output . ';' . PHP_EOL;
		}
	}
	
	echo '}' . PHP_EOL;
	echo '</style>' . PHP_EOL;
}
