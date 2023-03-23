<?php
// Register Custom Post Type locations
function custom_post_type() {

	$labels = array(
		'name'                  => _x( 'Orte', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Ort', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Orte', 'text_domain' ),
		'name_admin_bar'        => __( 'Orte', 'text_domain' ),
		'archives'              => __( 'Ort Archiv', 'text_domain' ),
		'attributes'            => __( 'Ort Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'Alle Orte', 'text_domain' ),
		'add_new_item'          => __( 'Neuen Ort hinzufügen', 'text_domain' ),
		'add_new'               => __( 'Neuer Ort', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Ort bearbeiten', 'text_domain' ),
		'update_item'           => __( 'Ort aktualisieren', 'text_domain' ),
		'view_item'             => __( 'Ort anschauen', 'text_domain' ),
		'view_items'            => __( 'Orte anschauen', 'text_domain' ),
		'search_items'          => __( 'Nach Orten suchen', 'text_domain' ),
		'not_found'             => __( 'Nicht gefunden', 'text_domain' ),
		'not_found_in_trash'    => __( 'Nicht im Papierkorb gefunden', 'text_domain' ),
		'featured_image'        => __( 'Cover Bild', 'text_domain' ),
		'set_featured_image'    => __( 'Cover Bild festlegen', 'text_domain' ),
		'remove_featured_image' => __( 'Cover Bild entfernen', 'text_domain' ),
		'use_featured_image'    => __( 'Als Cover Bild benutzen', 'text_domain' ),
		'insert_into_item'      => __( 'In Ort einfügen', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Zu diesem Ort hochladen', 'text_domain' ),
		'items_list'            => __( 'Liste der Orte', 'text_domain' ),
		'items_list_navigation' => __( 'Navigation der Ortsliste', 'text_domain' ),
		'filter_items_list'     => __( 'Filter Orte', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'location', 'text_domain' ),
		'description'           => __( 'Posts that link to a location', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt'),
		'taxonomies'            => array( 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-location',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'show_in_rest' 			=> true,
		'capability_type'       => 'post',
	);
	register_post_type( 'locations', $args );

}
add_action( 'init', 'custom_post_type', 0 );