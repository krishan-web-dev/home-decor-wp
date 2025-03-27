<?php
// Load all function files
require_once get_template_directory() . '/inc/init.php';
require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/menus.php';
require_once get_template_directory() . '/inc/theme-support.php';

function homedecor_enqueue_styles() {
    wp_enqueue_style(
        'main-style',
        get_stylesheet_uri(),
        array(),
        filemtime(get_template_directory() . '/style.css')
    );
}
add_action('wp_enqueue_scripts', 'homedecor_enqueue_styles');


// Disable block-based cart template
add_filter('woocommerce_enable_block_style', '__return_false');
add_filter('woocommerce_blocks_enable_cart', '__return_false');

?>