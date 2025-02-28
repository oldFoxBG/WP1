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
        
}