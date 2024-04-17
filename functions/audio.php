<?php

/**
 * Enqueues the Style and Script when an Audio Block is rendered and adds the Custom Audio HTML
 */
/**add_filter( 'render_block', 'dcwd_add_download_button_to_audio', 10, 2 );
function dcwd_add_download_button_to_audio($block_content, $block) {
    if ( 'core/audio' == $block['blockName'] ) {
        wp_enqueue_style('component-audio-style');
        wp_enqueue_script('component-audio-script');
        return $block_content;
    }
    return $block_content;
}**/

add_filter('register_block_type_args', function ($settings, $name) {
    if ($name == 'core/audio') {
      $settings['render_callback'] = 'render_custom_audio';
    }
    return $settings;
  }, null, 2);

  function render_custom_audio($attributes, $content) {
    wp_enqueue_style('component-audio-style');
    wp_enqueue_script('component-audio-script');

    $content = str_replace("</figure>", "", $content);
    $content .= PHP_EOL . '<div class="audiocontroll">
        <button class="playpause" aria-label="Audio Play-Pause Button">
            <img src="' . get_theme_file_uri("assets/pictures/play.svg") . '" class="play" alt=""></img>
            <img src="' . get_theme_file_uri("assets/pictures/pause.svg") . '" class="pause" alt=""></img>
        </button>
        <div class="playback">
            <div class="playbackhead"></div>
            <div class="playbackdisplay"></div>
            <span class="currentTime"></span>
            <span class="totalTime"></span>
        </div>
    </div>
    </figure>';
    return $content;
  }