<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <?php   
        wp_head();
        ?>
        <title><? echo get_bloginfo('name') ?></title>
        <!--Meta-->
        <!--<meta name="viewport" content="width=device-width"> -->
        <!--Fonts-->
        <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
        <style> @import url('https://fonts.googleapis.com/css2?family=Rubik:wght@300&display=swap'); </style>
        <style> @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap'); </style>
    </head>
    <body>
        <nav>
            <?php
            /**Integrating WP Menu*/
            wp_nav_menu(
                array(
                    "theme_location" => "header-menu",
                    "container" => "div",
                    "menu_class" => "header-menu-navbar-container",
                    "item_spacing" => "discard",
                    "link_after" => "<hr>"
                )
            );
            echo PHP_EOL;
            ?>
            <button class="burger" aria-label="Burger" aria-expanded="true" tabindex="0">
                <div class="burger-ln" id="ln1"></div>
                <div class="burger-ln" id="ln2"></div>
                <div class="burger-ln" id="ln3"></div>
            </button>
        </nav>
            <?php
/* Site Logo using Custom Logo or Site Title */
echo "<a class='hero' href='" . home_url() . "'>".PHP_EOL;
if(has_custom_logo()){
    $custom_logo_image_url = wp_get_attachment_image_src(get_theme_mod( 'custom_logo' ) , 'full' );

    echo "<img src='" , $custom_logo_image_url[0] , "' alt= 'Custom Logo'>".PHP_EOL;
} else {
    if(has_site_icon()) {
        echo "<img src='". get_site_icon_url() ."' alt= 'Website Icon'>".PHP_EOL;
    }
}
echo "<span>".get_bloginfo('name')."</span></a>".PHP_EOL;
?>
        <div class="site-content-container">
            