<?php
/**
 * This Function is executed once a Location is saved. It continues to convert all Addresses of the Locations Custom Values to Latitude and Longitude using the OpenStreetMap Geostat API. Those converted Values are Saved in the MySQL Table `jtg_locations_addresses`
 * @param int $post_id
 * @return void
 */
function update_addresses($post_id) {
	global $wpdb;
	if('locations' == get_post_type($post_id)) {
		/**
		 * Tries to create the `jtg_locations_addresses` Table it it not allready exists
		 */
		$wpdb->query("CREATE TABLE IF NOT EXISTS `jtg_locations_addresses` (
			`post_id` int(11) NOT NULL,
			`raw_address` longtext NOT NULL,
			`coordinates` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`coordinates`))
		  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

		//Retreves all addresses form the Posts Custom Fields
		$raw_addresses = get_post_meta($post_id, 'address');
		//Clear all prior entries for this post_id from the Database
		$wpdb->query("DELETE FROM jtg_locations_addresses WHERE post_id=" . $post_id . ";");
		//Convert Address into an Array of Latitude and Longitude
		foreach ($raw_addresses as  $raw_address) {
			//Convert the raw Address to Latitude and Longitude via a http request to the OpenStreetMap Geostat API
			$response = wp_remote_retrieve_body(wp_remote_get( 'https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' . $raw_address ));
			//Decodes the in JSON formatted Answer to a PHP Array
			$decoded = json_decode($response)[0];
			//Convert to JSON String
			$coordinates = '{"lat":' . $decoded->{"lat"} . ',"lon":' . $decoded->{"lon"} . '}';
			//Add the resolved Address to the Table
			$wpdb->query("INSERT INTO `jtg_locations_addresses` VALUES (". $post_id .", '" . $raw_address . "', '" . $coordinates . "');");
		}

	}
}
add_action( 'save_post', 'update_addresses');

/**
 * Function that cleans up the Rendered Addresses if a Location is deleted
 * @param int $post_id
 * @return void
 */
function clean_addresses($post_id) {
	global $wpdb;
	if ('locations' == get_post_type($post_id)) {
		$wpdb->query("DELETE FROM jtg_locations_addresses WHERE post_id=" . $post_id . ";");
	}
}
add_action( 'delete_post', 'clean_addresses');