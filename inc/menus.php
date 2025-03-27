<?php

function hmdecor_register_menus() {
    register_nav_menus([
        'primary' => __('Primary Menu', 'hmdecor'),
        'footer' => __('Footer Menu', 'hmdecor'),
    ]);
}
add_action('init', 'hmdecor_register_menus');

?>
