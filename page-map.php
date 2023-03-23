<?php
/*Php for the '/map' page*/
/*Load Assets needed for Map into Header */
add_action( 'wp_head', 'custom_external_map_assets');
wp_enqueue_style('component-map-style');
wp_enqueue_script('component-map-script');
get_header();

function custom_external_map_assets() {
    echo '<!--Leaflet.js inclusion-->'.PHP_EOL;
    echo '<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />'.PHP_EOL;
    echo '<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>'.PHP_EOL;
    echo '<!--Leaflet Position Controls inclusion-->';
    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol/dist/L.Control.Locate.min.css" />'.PHP_EOL;
    echo '<script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol/dist/L.Control.Locate.min.js" charset="utf-8"></script>'.PHP_EOL;
}

?>
<div class="map"></div>

<!-- Loaded Cities to display -->
<script>
    var cities = <?php echo get_theme_mod('set-map-selectable-cities', '[{"title":"Passau", "address":"[48.57390609055261, 13.460523755393428]"}]'); ?> ;
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

    <?php
        /**
         *  Selects all Locations
         */
        global $wpdb;
        //Loading all the Information
        $query = new WP_Query(array(
            'post_type' => 'locations',
            'post_status' => 'publish',
            'posts_per_page' => -1,
        ));
        $i = 0; //Counter for ID
        /**
         * Loads the Meta of the Location into the JS Class locationData and saves them int the loadedLocationData Array
         * 
         * Most of the Data is collected from the Custom Fields, if necessary Information isn't provided the Skript tries to find a Suitable replacement
         * (z.B.: if not Title is declared the Skripts loads the Title of the Location)
         * 
         * Out of Performace reasons the addresses are pre Rendered on the Backend into Latitude and Longitude. Those rendered JSON Objekts are loaded from the MySQL Database. If for some reason the Database cant resolve the Request the Skript will continue loading the Address from the Custom Fields and enter the Address as a String into locationData
         */
        while ($query->have_posts()) {
            //Defaults
            $query->the_post();
            $post_id = get_the_ID();
            //Array of all Custom Field Keys used
            $custom_keys = get_post_custom_keys($post_id);
            //Data
            $pin_theme = 'default';
            $addresses = '';
            $toShow = true;
            $mapTitle = 'Not Set';
            //Setting all Values from Custom Fields
            if (in_array('map_show', $custom_keys)) {
                $toShow = get_post_custom_values('map_show', $post_id)[0];
            }
            if (in_array('map_pin_style', $custom_keys)) {
                $pin_theme = get_post_custom_values('map_pin_style', $post_id)[0];
            }
            if (in_array('map_title', $custom_keys)) {
                $mapTitle = get_post_custom_values('map_title', $post_id)[0];
            } else {
                $mapTitle = get_the_title($post_id); //Gets the Title of the Post
            }
            //Try and load rendered addresses from Database
            $addresses = $wpdb->get_results("SELECT coordinates FROM `jtg_locations_addresses` WHERE post_id=" . $post_id . ";", $output = ARRAY_A);
            if($addresses == null) { //If selecting the Data from the Database failed for any reason select the address from the Custom Fields
                if (in_array('address', $custom_keys)) {
                    $addresses = get_post_custom_values('address', $post_id); //Insert from Custom Field
               } else { //If there is no custom field Key then set $toShow to false
                    $toShow = false;
               }                
            }
            //Set the URL
            $url = get_permalink($post_id);
            //Output Data and push to the loadedLocations Array
            if($toShow == 'true') { //Only shows the location if $toShow is true
                foreach ($addresses as $value) {
                    //Injects a new Location with loaded Data to JS
                    echo 'loadedLocationData.push(new locationData("' , $mapTitle , '","' , addslashes($value["coordinates"]), '","' , $url, '",' , $i , ',"' , $pin_theme , '"));'.PHP_EOL;
                  }
            }
            $i++;
        }
        wp_reset_query();
    ?>
</script>

<?php
get_footer();