<?php
/**
 * The Template for displaying single product pages.
 * 
 * Override this template by copying it to your theme's `woocommerce/single-product.php`.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header(); ?>

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />

<div class="container mx-auto px-4 py-10">
    <?php while (have_posts()) : the_post(); global $product; ?>
        <div class="grid md:grid-cols-2 gap-10">
            <!-- Product Image Slider with Swiper -->
            <div style="overflow: hidden; position: relative;">
                <div class="swiper-container main-slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img id="mainImage" src="<?php echo wp_get_attachment_url($product->get_image_id()); ?>" alt="<?php the_title(); ?>" class="w-full h-auto cursor-zoom-in transition-transform duration-200" />
                        </div>
                        <?php
                        $attachment_ids = $product->get_gallery_image_ids();
                        foreach ($attachment_ids as $attachment_id) {
                            echo '<div class="swiper-slide"><img src="' . wp_get_attachment_url($attachment_id) . '" class="w-full h-auto" /></div>';
                        }
                        ?>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
                <div class="swiper-container thumbnail-slider mt-4">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="<?php echo wp_get_attachment_url($product->get_image_id()); ?>" class="w-20 h-20 object-cover rounded cursor-pointer" />
                        </div>
                        <?php
                        foreach ($attachment_ids as $attachment_id) {
                            echo '<div class="swiper-slide"><img src="' . wp_get_attachment_url($attachment_id) . '" class="w-20 h-20 object-cover rounded cursor-pointer" /></div>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div>
                <h1 class="text-3xl font-bold text-gray-900"> <?php the_title(); ?> </h1>
                <p class="text-lg text-gray-500 mt-2"> <?php echo $product->get_price_html(); ?> </p>
                <div class="mt-4">
                    <?php echo wc_get_rating_html($product->get_average_rating()); ?>
                </div>
                <div class="mt-6"> <?php the_content(); ?> </div>
                
                <!-- Add to Cart -->
                <form class="mt-6" method="post" enctype="multipart/form-data">
                    <?php do_action('woocommerce_before_add_to_cart_button'); ?>
                    <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" />
                    <button type="submit" class="w-full bg-blue-600 text-white text-lg font-semibold py-3 rounded-lg hover:bg-blue-700 transition">
                        <?php echo esc_html($product->single_add_to_cart_text()); ?>
                    </button>
                    <?php do_action('woocommerce_after_add_to_cart_button'); ?>
                </form>
            </div>
        </div>

        <!-- Product Tabs: Details & Reviews -->
        <div class="mt-10">
            <div class="border-b flex space-x-6 text-lg font-semibold">
                <button class="py-3 px-5 focus:outline-none border-b-2 border-blue-600" onclick="showTab('details')">Product Details</button>
                <button class="py-3 px-5 focus:outline-none" onclick="showTab('reviews')">Reviews</button>
            </div>
            <div id="details" class="mt-6">
                <h2 class="text-2xl font-semibold">Product Description</h2>
                <div class="mt-4"> <?php the_content(); ?> </div>
            </div>
            <div id="reviews" class="mt-6 hidden">
                <h2 class="text-2xl font-semibold">Customer Reviews</h2>
                <div class="mt-4"> <?php comments_template(); ?> </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script>
function showTab(tab) {
    document.getElementById("details").classList.add("hidden");
    document.getElementById("reviews").classList.add("hidden");
    document.getElementById(tab).classList.remove("hidden");
}

// Swiper Initialization
var mainSwiper = new Swiper(".main-slider", {
    loop: true,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    thumbs: {
        swiper: new Swiper(".thumbnail-slider", {
            slidesPerView: 4,
            spaceBetween: 10,
            freeMode: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
        })
    }
});
</script>

<?php get_footer(); ?>
