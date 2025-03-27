<?php
/**
 * Step-by-Step Checkout Template
 * Location: woocommerce/checkout/form-checkout.php
 */

defined('ABSPATH') || exit;

// Disable block-based checkout
add_filter('woocommerce_has_block_template', function($has_template, $template_name) {
    return 'checkout/form-checkout.php' === $template_name ? false : $has_template;
}, 10, 2);

// If checkout registration is disabled and not logged in
if (!WC()->checkout()->is_registration_enabled() && WC()->checkout()->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}
?>
<div class="checkout" style="background-color:aliceblue;">
    <div class="container mx-auto px-4 py-8 lg:py-12">
        <!-- Checkout Progress Steps -->
        <div class="mb-8">
            <ol class="flex items-center justify-between text-sm font-medium text-gray-500">
                <li class="flex items-center gap-2">
                    <span class="flex items-center justify-center w-8 h-8 bg-wood-600 rounded-full text-white font-bold">1</span>
                    <span class="hidden sm:block"><?php esc_html_e('Information', 'home-decor'); ?></span>
                </li>
                
                <li class="flex items-center gap-2">
                    <span class="flex items-center justify-center w-8 h-8 border-2 border-gray-300 rounded-full font-bold">2</span>
                    <span class="hidden sm:block"><?php esc_html_e('Shipping', 'home-decor'); ?></span>
                </li>
                
                <li class="flex items-center gap-2">
                    <span class="flex items-center justify-center w-8 h-8 border-2 border-gray-300 rounded-full font-bold">3</span>
                    <span class="hidden sm:block"><?php esc_html_e('Payment', 'home-decor'); ?></span>
                </li>
                
                <li class="flex items-center gap-2">
                    <span class="flex items-center justify-center w-8 h-8 border-2 border-gray-300 rounded-full font-bold">4</span>
                    <span class="hidden sm:block"><?php esc_html_e('Confirmation', 'home-decor'); ?></span>
                </li>
            </ol>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Checkout Form -->
            <div class="lg:w-2/3">
                <form name="checkout" class="checkout woocommerce-checkout" method="post" enctype="multipart/form-data">
                    <!-- Step 1: Customer Information -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6" id="customer-info-step">
                        <h2 class="text-xl font-medium text-gray-900 mb-4 flex items-center">
                            <span class="flex items-center justify-center w-6 h-6 bg-wood-600 rounded-full text-white text-sm mr-2">1</span>
                            <?php esc_html_e('Customer Information', 'home-decor'); ?>
                        </h2>
                        
                        <?php if (!is_user_logged_in()) : ?>
                            <div class="mb-6">
                                <label class="flex items-center">
                                    <input type="checkbox" name="createaccount" id="createaccount" class="mr-2" <?php checked(true, WC()->checkout()->get_value('createaccount')); ?>>
                                    <?php esc_html_e('Create an account?', 'home-decor'); ?>
                                </label>
                            </div>
                        <?php endif; ?>
                        
                        <?php do_action('woocommerce_checkout_billing'); ?>
                        
                        <div class="mt-6 flex justify-end">
                            <button type="button" class="btn-style-1 next-step" data-next="shipping-step">
                                <?php esc_html_e('Continue to Shipping', 'home-decor'); ?>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 2: Shipping Information -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6 hidden" id="shipping-step">
                        <h2 class="text-xl font-medium text-gray-900 mb-4 flex items-center">
                            <span class="flex items-center justify-center w-6 h-6 bg-wood-600 rounded-full text-white text-sm mr-2">2</span>
                            <?php esc_html_e('Shipping Method', 'home-decor'); ?>
                        </h2>
                        
                        <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
                            <?php do_action('woocommerce_review_order_before_shipping'); ?>
                            <?php wc_cart_totals_shipping_html(); ?>
                            <?php do_action('woocommerce_review_order_after_shipping'); ?>
                        <?php endif; ?>
                        
                        <div class="mt-6 flex justify-between">
                            <button type="button" class="btn-style-1 prev-step" data-prev="customer-info-step">
                                <?php esc_html_e('Back to Information', 'home-decor'); ?>
                            </button>
                            <button type="button" class="btn-style-1 next-step" data-next="payment-step">
                                <?php esc_html_e('Continue to Payment', 'home-decor'); ?>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 3: Payment Information -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6 hidden" id="payment-step">
                        <h2 class="text-xl font-medium text-gray-900 mb-4 flex items-center">
                            <span class="flex items-center justify-center w-6 h-6 bg-wood-600 rounded-full text-white text-sm mr-2">3</span>
                            <?php esc_html_e('Payment Method', 'home-decor'); ?>
                        </h2>
                        
                        <?php do_action('woocommerce_checkout_before_order_review'); ?>
                        
                        <div id="order_review" class="woocommerce-checkout-review-order">
                            <?php do_action('woocommerce_checkout_order_review'); ?>
                        </div>
                        
                        <?php do_action('woocommerce_checkout_after_order_review'); ?>
                        
                        <div class="mt-6 flex justify-between">
                            <button type="button" class="btn-style-1 prev-step" data-prev="shipping-step">
                                <?php esc_html_e('Back to Shipping', 'home-decor'); ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Order Summary Sidebar -->
            <div class="lg:w-1/3">
                <div class="sticky top-4">
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <?php esc_html_e('Order Summary', 'home-decor'); ?>
                        </h3>
                        
                        <div class="woocommerce-checkout-review-order-table">
                            <?php
                            do_action('woocommerce_review_order_before_cart_contents');
                            
                            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                                $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                
                                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
                                    ?>
                                    <div class="flex justify-between py-3 border-b border-gray-100">
                                        <div class="flex items-center">
                                            <div class="w-16 h-16 bg-gray-100 rounded-md overflow-hidden mr-3">
                                                <?php echo apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key); ?>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">
                                                    <?php echo apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key); ?>
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    <?php echo apply_filters('woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf('&times;&nbsp;%s', $cart_item['quantity']) . '</strong>', $cart_item, $cart_item_key); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900">
                                            <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            
                            do_action('woocommerce_review_order_after_cart_contents');
                            ?>
                        </div>
                        
                        <div class="mt-4 space-y-2">
                            <div class="flex justify-between">
                                <span><?php esc_html_e('Subtotal', 'woocommerce'); ?></span>
                                <span><?php wc_cart_totals_subtotal_html(); ?></span>
                            </div>
                            
                            <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
                                <div class="flex justify-between">
                                    <span><?php wc_cart_totals_coupon_label($coupon); ?></span>
                                    <span><?php wc_cart_totals_coupon_html($coupon); ?></span>
                                </div>
                            <?php endforeach; ?>
                            
                            <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
                                <div class="flex justify-between">
                                    <span><?php esc_html_e('Shipping', 'woocommerce'); ?></span>
                                    <span><?php woocommerce_shipping_calculator(); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php foreach (WC()->cart->get_fees() as $fee) : ?>
                                <div class="flex justify-between">
                                    <span><?php echo esc_html($fee->name); ?></span>
                                    <span><?php wc_cart_totals_fee_html($fee); ?></span>
                                </div>
                            <?php endforeach; ?>
                            
                            <?php if (wc_tax_enabled() && !WC()->cart->display_prices_including_tax()) : ?>
                                <div class="flex justify-between">
                                    <span><?php echo esc_html(WC()->countries->tax_or_vat()); ?></span>
                                    <span><?php wc_cart_totals_taxes_total_html(); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="flex justify-between border-t border-gray-200 pt-3 mt-3 font-medium text-gray-900">
                                <span><?php esc_html_e('Total', 'woocommerce'); ?></span>
                                <span><?php wc_cart_totals_order_total_html(); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Trust Badges -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex flex-wrap justify-center gap-4 mb-4">
                            <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/ssl-secure.png')); ?>" alt="SSL Secure" class="h-10">
                            <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/payment-methods.png')); ?>" alt="Payment Methods" class="h-10">
                        </div>
                        <p class="text-center text-sm text-gray-500">
                            <?php esc_html_e('Secure 256-bit SSL encryption', 'home-decor'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    // Step navigation
    $('.next-step').on('click', function() {
        var nextStep = $(this).data('next');
        $(this).closest('.bg-white').addClass('hidden');
        $('#' + nextStep).removeClass('hidden');
        updateProgressBar(nextStep);
    });
    
    $('.prev-step').on('click', function() {
        var prevStep = $(this).data('prev');
        $(this).closest('.bg-white').addClass('hidden');
        $('#' + prevStep).removeClass('hidden');
        updateProgressBar(prevStep);
    });
    
    // Update progress bar
    function updateProgressBar(currentStep) {
        $('.flex.items-center.justify-between li').each(function() {
            $(this).find('span:first').removeClass('bg-wood-600 text-white').addClass('border-2 border-gray-300');
        });
        
        if (currentStep === 'customer-info-step') {
            $('.flex.items-center.justify-between li:first-child span:first').removeClass('border-2 border-gray-300').addClass('bg-wood-600 text-white');
        } else if (currentStep === 'shipping-step') {
            $('.flex.items-center.justify-between li:nth-child(2) span:first').removeClass('border-2 border-gray-300').addClass('bg-wood-600 text-white');
        } else if (currentStep === 'payment-step') {
            $('.flex.items-center.justify-between li:nth-child(3) span:first').removeClass('border-2 border-gray-300').addClass('bg-wood-600 text-white');
        }
    }
});
</script>