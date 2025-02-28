<?php
// Security check

use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;
use Automattic\WooCommerce\StoreApi\Payments\PaymentContext;
use Automattic\WooCommerce\StoreApi\Payments\PaymentResult;

if (!defined('ABSPATH')) {
    exit("You must not access this file directly");
}

final class WC_Test_payment_Gateway_Block_Support extends AbstractPaymentMethodType 
{
    /**
     * Payment method name
     * 
     */
    protected $name = 'test_payment';
    
    
    /**
     * Initialize the payment method type
     *
     */
    public function initialize() 
    {
        $this->settings = get_option('woocommerce_test_payment_settings', array());
        
        // add failure message
        add_action('woocommerce_rest_checkout_process_payment_with_context', array($this, 'add_failure_message'), 10, 2);
    }
    
    
    /**
     * Returns if this payment method should be active. If false, the script will not be wnqueued. 
     * 
     * @return boolean
     */
    public function is_active()
    {
        $payment_gateways_class = WC()->payment_gateways();
        $payment_gateways       = $payment_gateways_class->payment_gateways();
        return $payment_gateways['test_payment']->is_available();
    }
    
    /**
     * Add failed payment notice to the payment datails.
     * 
     * @param PaymentContext $context Holds context for the payment 
     * @param PaymentResult  $result  Result object for the payment 
     */
    public function add_failure_message(PaymentContext $context, PaymentResult &$result)
    {
        if ('test_payment' === $context->payment_method) {
            add_action(
               'wc_gateway_test_payment_process_payment_error', 
                function ($failed_notice) use (&$result) {
                    $payment_details                 = $result->payment_details;
                    $payment_details['errorMessage'] = wp_strip_all_tags($failed_notice);
                    $result->set_payment_datails($payment_details);
                }
            );
        }              
    }
    
    /**
     * Returns an array of key=>value pairs of data, made available to the payment methods script.
     * 
     * @return array
     */
    public function get_payment_method_data()
    {
        $payment_gateways_class = WC()->payment_gateways();
        $payment_gateways       = $payment_gateways_class->payment_gateways();
        $gateway                = $payment_gateways['test_payment'];
        
        return array(
            'title'             => $this->get_setting('title'),
            'description'       => $this->get_setting('description'),
            'supports'          => array_filter($gateway->supports, array($gateway, 'supports')),
            'allow_saved_cards' => $gateway->saved_cards,
            'logo_urls'         => array($payment_gateways['test_payment']->get_logo_url())
        );
    }
    
    /**
     * Returns an array of scripts/handles to be registered for this payment method.
     * 
     * @return array
     */
    public function get_payment_method_script_handles()
    {
//         $asset_path   = plugin_dir_path(TEST_PAYMENT_FILE) . '/assets/js/block/block.asset.php';
//         $version      = null;
//         $dependencies = array();
//         if (file_exists($asset_path)) {
//             $asset        = require $asset_path;
//             $version      = isset($asset['version']) ? $asset['version'] : $version;
//             $dependencies =  isset($asset['dependencies']) ? $asset['dependencies'] : $version;
//         }
        
//         wp_register_script(
//             'wp-test-payment-blocks-integratrion',
//             plugin_dir_url(TEST_PAYMENT_FILE) . '/assets/js/block/block.js',
//             $dependencies,
//             $version,
//             TRUE
//         );
        
//         // logo url
//         $logo_url = WC_HTTPS::force_https_url(TEST_PAYMENT_PLUGIN_URL . '/assets/images/visa_master.png');
        
//         // localization script
//         wp_localize_script('wp-test-payment-blocks-integratrion', 'test_payment_Data', array(
//             'logo_url' => $logo_url
//         ));
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
        
}