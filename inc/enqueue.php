<?php

function hmdecor_enqueue_styles() {
    wp_enqueue_style('hmdecor-style', get_template_directory_uri() . '/assets/css/frontend.css', [], '1.0');
    wp_enqueue_script('hmdecor-scripts', get_template_directory_uri() . '/assets/js/scripts.js', ['jquery'], '1.0', true);
}
add_action('wp_enqueue_scripts', 'hmdecor_enqueue_styles');

?>
