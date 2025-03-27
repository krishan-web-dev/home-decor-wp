<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="bg-blue-600 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-xl font-bold"><?php bloginfo('name'); ?></h1>
        <nav>
            <?php wp_nav_menu(['theme_location' => 'primary', 'menu_class' => 'flex space-x-4']); ?>
        </nav>
    </div>
</header>
