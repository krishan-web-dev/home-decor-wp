jQuery(document).ready(function ($) {
    $(".wp-block-woocommerce-product-collection").each(function () {
        // Wrap the block inside a new structure
        $(this).wrap('<div class="container mx-auto"></div>').parent().wrap('<section class="product-collection"></section>');
    });
});
