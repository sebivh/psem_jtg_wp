<?php
wp_enqueue_style('singular-style');


//Loads Header
get_header();

//Loads content of the Site
the_content();

//Loads Footer
get_footer();