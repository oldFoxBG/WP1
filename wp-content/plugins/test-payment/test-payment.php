<?php
/**
 * Plugin Name: TEST Payment Gateway
 * Plugin URI:  Plugin URL Link
 * Author:      Author Name
 * Author URI:  Author URI
 * Description: TEST Payment Gateway under PHP 8.2.12 / WP 6.7.2 / WC 9.6.2
 * Version:     0.1.0
 * License:     GPL-2.0+
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: test-payment-domain
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit("You must not access this file directly");
}

// Define the plugin constants
define('TEST_PAYMENT_VERSION', '0.1.0');
define('TEST_PAYMENT_PLUGIN_URL', plugin_dir_url(__FILE__));
define('TEST_PAYMENT_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('TEST_PAYMENT_TEXT_DOMAIN', 'test-payment-domain');

// Activation Hook - Check if WooCommerce is Active
register_activation_hook(__FILE__, 'test_payment_activation_check');

function test_payment_activation_check()
{
    include_once ABSPATH . 'wp-admin/includes/plugin.php'; // Ensure is_plugin_active() is available

    if (!is_plugin_active('woocommerce/woocommerce.php')) {
        // Deactivate the plugin
        deactivate_plugins(plugin_basename(__FILE__));

        // Display error message and stop activation
        wp_die(
            __('Test Payment Gateway requires WooCommerce to be installed and active.', 'test-payment'),
            'Plugin Activation Error',
            array('back_link' => true)
        );
    }
}

// Run this check after all plugins are loaded
add_action('plugins_loaded', 'test_payment_check_woocommerce');



function test_payment_check_woocommerce()
{
    if (!class_exists('WooCommerce')) {
        add_action('admin_notices', 'test_payment_woocommerce_notice');
        return; // Stop further execution if WooCommerce is missing
    }

    // Initialize the plugin
    test_payment_init();    
    // Add settings url
    add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'test_payment_settings_link');
    // register woocommerce payment gateway
    add_filter('woocommerce_payment_gateways', 'test_payment_gateway');
    }

function test_payment_init() 
{    
    // Check if class exists Test_Payment_Gateway
    if (!class_exists('Test_Payment_Gateway')) {
        include_once TEST_PAYMENT_PLUGIN_PATH . 'includes/main-file.php';
    }
}

// WooCommerce Not Installed Notice
function test_payment_woocommerce_notice()
{
    ob_start();
    // require the admin notice template
    require_once TEST_PAYMENT_PLUGIN_PATH . '/templates/admin_notice.php';
    echo ob_get_clean();
}

// test_payment_settings_link
function test_payment_settings_link ($links) {
    $settings_link = '<a href="admin.php?page=wc-settings&tab=checkout&section=test_payment">Settings</a>';
    array_push($links, $settings_link);
    return $links;
}

// test_paument_gateway
function test_payment_gateway($gateways)
{
    $gateways[] = 'Test_Payment_Gateway';
    return $gateways;
    
}

