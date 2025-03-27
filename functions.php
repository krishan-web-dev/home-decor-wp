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


// Force classic cart template
add_filter('woocommerce_blocks_enable_cart', '__return_false');
add_filter('woocommerce_has_block_template', function($has_template, $template_name) {
    return 'cart/cart.php' === $template_name ? false : $has_template;
}, 10, 2);

// Simplify checkout fields
add_filter('woocommerce_checkout_fields', 'home_decor_simplify_checkout_fields');
function home_decor_simplify_checkout_fields($fields) {
    // Remove unnecessary fields
    unset($fields['order']['order_comments']);
    
    // Make fields more minimal
    $fields['billing']['billing_company']['placeholder'] = __('Company (optional)', 'home-decor');
    $fields['billing']['billing_address_2']['placeholder'] = __('Apartment, suite, etc. (optional)', 'home-decor');
    
    // Set required fields
    $fields['billing']['billing_email']['required'] = true;
    $fields['billing']['billing_phone']['required'] = true;
    
    return $fields;
}

// Move email field to top
add_filter('woocommerce_checkout_fields', 'home_decor_move_checkout_email_field');
function home_decor_move_checkout_email_field($fields) {
    $fields['billing']['billing_email']['priority'] = 5;
    return $fields;
}
?>