<?php
/**
 * php File controlling the Site that is put out during a 404 error
 */
get_header();

?>
<img src="<?php echo get_theme_file_uri('assets\pictures\error.svg') ?>" alt="Error">
<h1>404</h1>
<err>Diese Seite existiert leider noch nicht!</err>

<style>
    .site-content-container {
        display: flex;
        flex-direction: column;
    }
    .site-content-container>h1 {
        text-align: center;
        font-size: 7rem;
    }
    .site-content-container err {
        text-align: center;
    }
    .site-content-container>img {
        width: 20%;
        margin-left: auto;
        margin-right: auto;
    }
</style>

<?php

get_footer();