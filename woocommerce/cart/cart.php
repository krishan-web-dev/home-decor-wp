<?php
/**
 * Custom Cart Template for Home Decor Theme
 * Location: woocommerce/cart/cart.php
 */

defined('ABSPATH') || exit;

// Disable Gutenberg/block-based cart
add_filter('woocommerce_has_block_template', function($has_template, $template_name) {
    return 'cart/cart.php' === $template_name ? false : $has_template;
}, 10, 2);

do_action('woocommerce_before_cart'); ?>

<div class="container mx-auto px-4 py-8 lg:py-12">
    <h1 class="text-3xl font-serif font-bold text-gray-900 mb-6 text-center">
        <?php esc_html_e('Your Shopping Cart', 'home-decor'); ?>
        <span class="text-base font-normal text-gray-500 ml-2">
            (<?php echo sprintf(_n('%d item', '%d items', WC()->cart->get_cart_contents_count(), 'home-decor'), WC()->cart->get_cart_contents_count()); ?>)
        </span>
    </h1>
    
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Cart Items - Using original WooCommerce structure but with Tailwind classes -->
        <div class="lg:w-2/3">
            <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
                <?php do_action('woocommerce_before_cart_table'); ?>
                
                <table class="w-full woocommerce-cart-form__contents">
                    <thead class="hidden md:table-header-group">
                        <tr class="border-b border-gray-200">
                            <th class="product-remove pb-3 text-left"><span class="screen-reader-text"><?php esc_html_e('Remove item', 'woocommerce'); ?></span></th>
                            <th class="product-thumbnail pb-3 text-left"><span class="screen-reader-text"><?php esc_html_e('Thumbnail image', 'woocommerce'); ?></span></th>
                            <th class="product-name pb-3 text-left"><?php esc_html_e('Product', 'woocommerce'); ?></th>
                            <th class="product-price pb-3 text-left"><?php esc_html_e('Price', 'woocommerce'); ?></th>
                            <th class="product-quantity pb-3 text-left"><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
                            <th class="product-subtotal pb-3 text-right"><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php do_action('woocommerce_before_cart_contents'); ?>
                        
                        <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) : ?>
                            <?php 
                            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                            
                            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) :
                                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                            ?>
                                <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?> border-b border-gray-200">
                                    
                                    <!-- Remove Item -->
                                    <td class="product-remove py-4">
                                        <?php
                                        echo apply_filters(
                                            'woocommerce_cart_item_remove_link',
                                            sprintf(
                                                '<a href="%s" class="text-gray-400 hover:text-red-500" aria-label="%s" data-product_id="%s" data-product_sku="%s">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </a>',
                                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                                esc_attr__('Remove this item', 'home-decor'),
                                                esc_attr($product_id),
                                                esc_attr($_product->get_sku())
                                            ),
                                            $cart_item_key
                                        );
                                        ?>
                                    </td>
                                    
                                    <!-- Product Thumbnail -->
                                    <td class="product-thumbnail py-4">
                                        <?php
                                        $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                                        if (!$product_permalink) {
                                            echo $thumbnail;
                                        } else {
                                            printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail);
                                        }
                                        ?>
                                    </td>
                                    
                                    <!-- Product Name -->
                                    <td class="product-name py-4" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                                        <?php
                                        if (!$product_permalink) {
                                            echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                                        } else {
                                            echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                                        }
                                        
                                        do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);
                                        echo wc_get_formatted_cart_item_data($cart_item);
                                        
                                        if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                            echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                                        }
                                        ?>
                                    </td>
                                    
                                    <!-- Product Price -->
                                    <td class="product-price py-4" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                                        <?php
                                        echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                                        ?>
                                    </td>
                                    
                                    <!-- Quantity -->
                                    <td class="product-quantity py-4" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                                        <?php
                                        if ($_product->is_sold_individually()) {
                                            $min_quantity = 1;
                                            $max_quantity = 1;
                                        } else {
                                            $min_quantity = 0;
                                            $max_quantity = $_product->get_max_purchase_quantity();
                                        }

                                        $product_quantity = woocommerce_quantity_input(
                                            array(
                                                'input_name'   => "cart[{$cart_item_key}][qty]",
                                                'input_value'  => $cart_item['quantity'],
                                                'max_value'    => $max_quantity,
                                                'min_value'    => $min_quantity,
                                                'product_name' => $_product->get_name(),
                                            ),
                                            $_product,
                                            false
                                        );

                                        echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
                                        ?>
                                    </td>
                                    
                                    <!-- Subtotal -->
                                    <td class="product-subtotal py-4 text-right" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>">
                                        <?php
                                        echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
                                        ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        
                        <?php do_action('woocommerce_cart_contents'); ?>
                        
                        <tr>
                            <td colspan="6" class="actions py-4">
                                <div class="flex flex-col md:flex-row justify-between gap-4">
                                    <?php if (wc_coupons_enabled()) : ?>
                                        <div class="coupon flex items-center gap-2">
                                            <input type="text" name="coupon_code" class="border border-gray-300 rounded-md px-3 py-2" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" />
                                            <button type="submit" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>">
                                                <?php esc_attr_e('Apply', 'woocommerce'); ?>
                                            </button>
                                            <?php do_action('woocommerce_cart_coupon'); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <button type="submit" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 md:ml-auto" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>">
                                        <?php esc_html_e('Update Cart', 'woocommerce'); ?>
                                    </button>
                                </div>
                                
                                <?php do_action('woocommerce_cart_actions'); ?>
                                <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                            </td>
                        </tr>
                        
                        <?php do_action('woocommerce_after_cart_contents'); ?>
                    </tbody>
                </table>
                
                <?php do_action('woocommerce_after_cart_table'); ?>
            </form>
        </div>
        
        <!-- Cart Totals -->
        <div class="lg:w-1/3">
            <div class="bg-white rounded-lg shadow-sm p-6 sticky top-4">
                <h2 class="text-xl font-medium text-gray-900 mb-4"><?php esc_html_e('Cart Totals', 'home-decor'); ?></h2>
                
                <?php do_action('woocommerce_before_cart_collaterals'); ?>
                
                <div class="cart-collaterals">
                    <?php do_action('woocommerce_cart_collaterals'); ?>
                </div>
                
                <div class="mt-6">
                    <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="block w-full bg-wood-600 text-white text-center py-3 px-4 rounded-md hover:bg-wood-700 transition font-medium">
                        <?php esc_html_e('Proceed to Checkout', 'home-decor'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php do_action('woocommerce_after_cart'); ?>