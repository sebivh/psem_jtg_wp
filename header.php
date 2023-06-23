<?php
//Loading Styles and Scripts
wp_enqueue_style("header-style");
wp_enqueue_script('header-script');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <?php   
        wp_head();
        ?>
        <title><? echo get_bloginfo('name') ?></title>
        <!--Meta-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    "link_before" => "<span>",
                    "link_after" => "</span><hr>"
                )
            );
            echo PHP_EOL;
            ?>
            <button class="burger" aria-label="Burger" aria-expanded="true" tabindex="0">
                <div class="burger-ln"></div>
                <div class="burger-ln"></div>
                <div class="burger-ln"></div>
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
<?php
            