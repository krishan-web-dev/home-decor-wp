<?php
/**
 * My Account Template
 * 
 * @package Home Decor
 * @version 1.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
    <div class="container mx-auto">
    <!-- Account Header -->
    <div class="mb-8 text-center">
        <h1 class="text-3xl md:text-4xl font-serif font-bold text-gray-900 mb-2"><?php esc_html_e('My Account', 'home-decor'); ?></h1>
        <p class="text-gray-600"><?php esc_html_e('Manage your account details and orders', 'home-decor'); ?></p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Account Navigation -->
        <nav class="w-full lg:w-64 flex-shrink-0">
            <div class="bg-white p-6 rounded-lg shadow-sm sticky top-4">
                <div class="flex items-center gap-4 mb-6">
                    <?php echo get_avatar(get_current_user_id(), 60, '', '', ['class' => 'rounded-full']); ?>
                    <div>
                        <p class="font-medium"><?php echo esc_html(wp_get_current_user()->display_name); ?></p>
                        <p class="text-sm text-gray-600"><?php echo esc_html(wp_get_current_user()->user_email); ?></p>
                    </div>
                </div>

                <ul class="space-y-2">
                    <?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
                        <li>
                            <a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>" 
                               class="block px-4 py-2 rounded-md hover:bg-wood-50 hover:text-wood-700 transition <?php echo wc_get_account_menu_item_classes($endpoint); ?>">
                                <?php echo esc_html($label); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    <li>
                        <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" 
                           class="block px-4 py-2 rounded-md hover:bg-gray-100 text-gray-600 hover:text-gray-900 transition">
                            <?php esc_html_e('Logout', 'home-decor'); ?>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Account Content -->
        <main class="flex-1">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <?php
                /**
                 * My Account content.
                 * @since 2.6.0
                 */
                do_action('woocommerce_account_content');
                ?>
            </div>

            <!-- Recent Orders (Custom Section) -->
            <div class="mt-8">
                <h2 class="text-xl font-medium text-gray-900 mb-4"><?php esc_html_e('Recent Orders', 'home-decor'); ?></h2>
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <?php
                    $customer_orders = wc_get_orders([
                        'customer' => get_current_user_id(),
                        'limit'    => 3,
                        'status'   => array_keys(wc_get_order_statuses()),
                    ]);

                    if ($customer_orders) : ?>
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php esc_html_e('Order', 'home-decor'); ?></th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php esc_html_e('Date', 'home-decor'); ?></th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php esc_html_e('Status', 'home-decor'); ?></th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php esc_html_e('Total', 'home-decor'); ?></th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php esc_html_e('Actions', 'home-decor'); ?></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($customer_orders as $customer_order) :
                                    $order = wc_get_order($customer_order);
                                    $item_count = $order->get_item_count() - $order->get_item_count_refunded();
                                ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <a href="<?php echo esc_url($order->get_view_order_url()); ?>">
                                                #<?php echo esc_html($order->get_order_number()); ?>
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo esc_html(wc_format_datetime($order->get_date_created())); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo esc_attr($order->get_status() === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                                <?php echo esc_html(wc_get_order_status_name($order->get_status())); ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo wp_kses_post($order->get_formatted_order_total()); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <a href="<?php echo esc_url($order->get_view_order_url()); ?>" class="text-wood-600 hover:text-wood-700">
                                                <?php esc_html_e('View', 'home-decor'); ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <div class="p-6 text-center text-gray-500">
                            <?php esc_html_e('No orders yet.', 'home-decor'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
    </div>