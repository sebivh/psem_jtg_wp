<?php

/**
 * Registers all Styles and Scripts
 */
include_once('functions/register.php');

/**
 * Registers the Custom Post Type 'locations'
 */
include_once('functions/posttypes/locations.php');

/**
 * Sets up the System for Saving the Addresses of locations as Longetude and Latitude in the MySQL Database
 */
include_once('functions/addresses.php');

/**
 * Settings for the Theme Customizor
 */
include_once('functions/customizor.php');

/**
 * Registers the [post post_id={id}] shortcode
 */
include_once('functions/shortcodes/post.php');

/**
 * Registers the [postgallery][/postgallery] shortcode
 */
include_once('functions/shortcodes/postgallery.php');

/**
 * Registers the [map interactive={bool} width="{width}" height="{height}"] shortcode
 */
include_once('functions/shortcodes/map.php');

/**
 * Registers the [timeline] shortcode
 */
include_once('functions/shortcodes/timeline.php');

/**
 * Registers the [characteristics] shortcode
 */
include_once('functions/shortcodes/characteristic.php');

/**
 * Registers the Function for appending the Custom Audio Controll Assets
 */
include_once('functions/audio.php');

function enqueue_styles() {
	wp_enqueue_style("main-style");
}
add_action("wp_enqueue_scripts", "enqueue_styles");

function enqueue_scripts() {
	wp_enqueue_script('jtg-script');
}
add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );

function setup_theme() {
	register_nav_menus(
		array(
			"header-menu" => "Head-Navigation"
		)
	);

	add_theme_support( 'custom-logo' );
	add_theme_support( 'post-thumbnails' );
}
add_action("after_setup_theme", "setup_theme");


add_filter('acf/settings/remove_wp_meta_box', '__return_false');


//Show Post Id Collum
function add_column( $columns ){
	$columns['post_id_clmn'] = 'ID'; // $columns['Column ID'] = 'Column Title';
	return $columns;
}
add_filter('manage_posts_columns', 'add_column', 5);

//Show Post ID
function column_content( $column, $id ){
	if( $column === 'post_id_clmn')
		echo $id;
}
add_action('manage_posts_custom_column', 'column_content', 5, 2);


// Add Menu description Functionality according to https://www.wpbeginner.com/wp-themes/how-to-add-menu-descriptions-in-your-wordpress-themes/
class Menu_With_Description extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth, $args) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
         
        $class_names = $value = '';
 
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
 
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';
 
        $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
 
        $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
        $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';
 
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		//Check if Item has Description and in case add it
		if(!empty($item->description)) {
			$item_output .= '<span class="sub">' . $item->description . '</span>';
		}
        $item_output .= '</a>';
        $item_output .= $args->after;
 
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}	