<?php
function map_shortcode($atts = [], $content = null, $tag = ''){
    // normalize attribute keys, lowercase
	$atts = array_change_key_case( (array) $atts, CASE_LOWER );

	// override default attributes with user attributes
	$properties = shortcode_atts(
		array(
			'interactive' => 'true',
            'width' => '100%',
            'height' => '40svh',
            'overwrite_address' => null,
            'overwrite_zoom' => null,
            'location_post_id' => null,
		), $atts, $tag
	);

    //Include Style and Script
    wp_enqueue_style('component-map-style');
    wp_enqueue_script('component-map-script');
    //External Styles and Scripts
    wp_enqueue_style('leaflet-main-style');
    wp_enqueue_script('leaflet-main-script');

    //Only Include Location Controll if needed by an Interactive Map
    if($properties['interactive'] === 'true') {
        wp_enqueue_style('leaflet-location-style');
        wp_enqueue_script('leaflet-location-script');
    }

    //Get Query
    $query = get_query( (int) $properties['location_post_id']);
    
    //Get location Data
    $dataList = get_location_data($query);
    
    //Outputs all Data
    $injection = get_output_data($dataList);

    //Creates the finished js
    $o = generate_js_structure($injection, $properties['interactive'], $properties['overwrite_address'], $properties['overwrite_zoom']);
    
    //Generate Map
    $o .= '<div class="map" style="height:' . $properties['height'] . ';width:' . $properties['width'] . ';"></div>' . PHP_EOL;

    return $o;
}
add_shortcode('map', 'map_shortcode');


/**
 * Injects the loaded data into JS
 * 
 * The cities Array contains a JSON Object in wich all the Locations for the City selector are loaded
 * locationData is the class the Information for the Map Markers gets loaded from
 * @return string
 */
function generate_js_structure(string $injection, $interactive, $overwrite_address, $overwrite_zoom) {
    /**
     * Includes the necessary JS classes
     */
    //Null Checks
    if ($overwrite_address == null) {
        $overwrite_address = 'null';
    }
    if ($overwrite_zoom == null) {
        $overwrite_zoom = 'null';
    }


    $o = '<!-- Loaded Cities to display -->' . PHP_EOL;
    $o .= '
    <script>
        var cities = ' . get_theme_mod('set-map-selectable-cities', '[{"title":"Passau", "address":"[48.57390609055261, 13.460523755393428]"}]') . ';
    </script>
    <!-- Loaded Post Data-->
    <script>
        /**
         * Class that contains the Backend Location Data
         */
        class locationData {
            /**
             * @param {string} title the Title of the Location
             * @param {json || string} address the address as a String or as Latitude and Longitude formatted as an JSON Objekt
             * @param {string} url The Permalink of the Location
             * @param {int} category The Locations Parameter
             * @param {string} theme The Style of the Marker (assets/pictures/markers/marker-{theme}.svg)
            */
            constructor(title, address, url, category, theme) {
                this.title = title;
                this.address = address;
                this.url = url;
                this.category = category;
                this.theme = theme;
            }
        };

        var loadedLocationData = [];

        //Injected Data
        const interactive = JSON.parse(' . json_encode($interactive) . ');
        const overwriteAddress = ' . $overwrite_address . ';
        const overwriteZoom = ' . $overwrite_zoom . ';

        ' . $injection . '
        </script>
        ';
    return $o;
}

/**
 * Gets a Query for the locations Post Type
 * 
 * @param int $post If Specified only this Post will be queried
 * 
 * @return WP_Query
 */
function get_query($post) {
    $properties = array(
        'post_type' => 'locations',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );

    //If $post is specified adds its id to the search parameters (get_post_status returns false if post dosn't exist, it is used to check if the post Id is valid)
    if(  $post != 0 && get_post_status( $post )) {
        $properties['p'] = $post;
    }

    return new WP_Query($properties);
}

/**
 * Gets all the nesseary Data for an location Query and returns an Array with Data for all Posts
 * @param WP_Query $query
 * @return array
 */
function get_location_data(WP_Query $query) {
    global $wpdb;
    
    $o = array();
    while ($query->have_posts()) {

        //Iterate Query
        $query->the_post();

        //Setting Post ID
        $post_id = get_the_ID();

        //Create Data and generate Defaults
        $data = array(
            'id' => get_the_ID(),
            'style' => 'default',
            'addresses' => array(),
            'toShow' => true,
            'title' => 'Not Set',
            'url' => '',
        );

        //Used Custom Field Values
        $custom_keys = get_post_custom_keys($post_id);

        //Setting all Values from Custom Fields
        if (in_array('map_show', $custom_keys)) {
            $data['id'] = get_post_custom_values('map_show', $post_id)[0];
        }
        if (in_array('map_pin_style', $custom_keys)) {
            $data['style'] = get_post_custom_values('map_pin_style', $post_id)[0];
        }
        if (in_array('map_title', $custom_keys)) {
            $data['title'] = get_post_custom_values('map_title', $post_id)[0];
        } else {
            $data['title'] = get_the_title($post_id); //Gets the Title of the Post
        }
        $data['url'] = get_permalink($post_id);

        //Try and load rendered addresses from Database
        $response = $wpdb->get_results("SELECT coordinates FROM `jtg_locations_addresses` WHERE post_id=" . $post_id . ";", $output = ARRAY_A);

        //If selecting the Data from the Database failed for any reason select the address from the Custom Fields
        if ($response == null) {
            //If no address is defined in the Custom Keys set toSho to false
            if (in_array('address', $custom_keys)) {
                $data['addresses'] = get_post_custom_values('address', $post_id); //Insert from Custom Field
            } else { //If there is no custom field Key then set $toShow to false
                $data['toShow'] = false;
            }
        } else {
            //Fill Addressen with MySQL answer
            foreach ($response as $entry) {
                array_push($data['addresses'], $entry["coordinates"]);
            }
            $i = array(
                array(
                    'coordinates' => '[]'
                )
            );
        }
        //Add to output
        array_push($o, $data);
    }
    return $o;
}

/**
 * Generates the JS script lines to inject data into JS
 * @param array $dataList
 * @param bool $interactive
 * @return string
 */
function get_output_data(array $dataList) {
    $i = 0; //Counter for ID
    $o = ''; //Output String;

    foreach ($dataList as $data) {
        //If its supposed to be seen
        if($data['toShow'] == 'true') {
            foreach ($data['addresses'] as $address) {
                //Injects a new Location with loaded Data to JS
                $o .= 'loadedLocationData.push(new locationData("' . addslashes($data['title']) . '", ' . $address . ',"' . $data['url'] . '",' . $i . ',"' . $data['style'] . '"));'.PHP_EOL;
              }
        }
        $i++;
    }
    return $o;
}