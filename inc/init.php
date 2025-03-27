<?php

function hmdecor_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'hmdecor_theme_setup');

?>
