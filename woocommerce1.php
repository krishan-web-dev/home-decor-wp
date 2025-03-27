<?php
/**
 * The Template for displaying product archives, including the main shop page
 *
 * @package Home Decor
 * @version 1.0
 */

get_header(); ?>

<div class="container mx-auto px-4 py-8 lg:py-12 shop">
    <!-- Hero Section -->
    <div class="bg-cover bg-center overflow-hidden mb-12" style="background-image: url('<?php echo esc_url(get_theme_file_uri('/assets/images/shop-hero.jpg')); ?>')">
        <div class="py-16 px-6 sm:px-12 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4"><?php woocommerce_page_title(); ?></h1>
            <p class="text-xl text-white max-w-2xl mx-auto"><?php echo esc_html(get_theme_mod('home_decor_shop_subtitle', 'Discover handcrafted home decor pieces to elevate your living space')); ?></p>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar Filters -->
        <aside class="w-full md:w-72 flex-shrink-0">
            <div class="bg-white p-6 rounded-lg shadow-sm sticky top-4">
                <!-- Mobile Filter Toggle -->
                <button id="filter-toggle" class="md:hidden w-full flex justify-between items-center mb-4">
                    <span class="font-medium"><?php esc_html_e('Filters', 'home-decor'); ?></span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <!-- Filter Content -->
                <div id="filter-content" class="md:block">
                    <?php if (is_active_sidebar('shop-sidebar')) : ?>
                        <?php dynamic_sidebar('shop-sidebar'); ?>
                    <?php else : ?>
                        <!-- Default filters if sidebar not configured -->
                        <div class="mb-6">
                            <h3 class="font-medium text-gray-900 mb-3"><?php esc_html_e('Product Categories', 'home-decor'); ?></h3>
                            <?php
                            $args = array(
                                'taxonomy' => 'product_cat',
                                'title_li' => '',
                                'style' => 'none',
                                'echo' => false
                            );
                            $categories = wp_list_categories($args);
                            if ($categories) {
                                echo '<ul class="space-y-2">' . $categories . '</ul>';
                            }
                            ?>
                        </div>                        
                    <?php endif; ?>

                    <button class="w-full bg-wood-600 text-white py-2 px-4 rounded-md hover:bg-wood-700 transition">
                        <?php esc_html_e('Apply Filters', 'home-decor'); ?>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1">
            <!-- Sort and Results Info -->
            <div class="bg-white p-4 rounded-lg shadow-sm mb-6 flex flex-col sm:flex-row justify-between items-center">
                <div class="mb-4 sm:mb-0">
                    <?php woocommerce_result_count(); ?>
                </div>
                <div class="flex items-center space-x-4">
                    <?php woocommerce_catalog_ordering(); ?>
                </div>
            </div>

            <!-- Products Grid -->
            <?php
            if (woocommerce_product_loop()) {
                woocommerce_product_loop_start();
                
                while (have_posts()) {
                    the_post();
                    wc_get_template_part('content', 'product');
                }
                
                woocommerce_product_loop_end();
                
                // Pagination
                echo '<div class="mt-8">';
                woocommerce_pagination();
                echo '</div>';
            } else {
                do_action('woocommerce_no_products_found');
            }
            ?>
        </main>
    </div>
</div>

<?php get_footer(); ?>

<script>
    // Mobile filter toggle
    document.getElementById('filter-toggle')?.addEventListener('click', function() {
        const filterContent = document.getElementById('filter-content');
        filterContent.classList.toggle('hidden');
    });
</script>