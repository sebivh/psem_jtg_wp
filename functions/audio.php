<?php

/**
 * Enqueues the Style and Script when an Audio Block is rendered and adds the Custom Audio HTML
 */
add_filter( 'render_block', 'dcwd_add_download_button_to_audio', 10, 2 );
function dcwd_add_download_button_to_audio($block_content, $block) {
    if ( 'core/audio' == $block['blockName'] ) {
        wp_enqueue_style('component-audio-style');
        wp_enqueue_script('component-audio-script');
        return $block_content;
    }
    return $block_content;
}