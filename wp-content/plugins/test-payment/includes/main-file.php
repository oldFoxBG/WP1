<?php
// Security check
if (!defined('ABSPATH')) {
    exit("You must not access this file directly");
}

/**
 * TEST Payment Gateway
 * 
 * @author Author Name
 * @since 1.0.0
 */

class Test_Payment_Gateway extends WC_Payment_Gateway_CC
{

    /**
     *  Public key
     *  
     *  @var string;
     */
    public $public_key;
    
    /**
     *  Secret key
     *
     *  @var string;
     */
    public $secret_key;
    
    /**
     *  Test mode
     *
     */
    public $test_mode;
    
    /**
     *  Constructor
     *  
     *  @since 1.0.0
     */
    
    public function __construct()
    {
        // id
        $this->id = 'test_payment';
        // has fields
        $this->has_fields = TRUE;
        // method title
        $this->method_title = __('Test Payment Gateway', TEST_PAYMENT_TEXT_DOMAIN);
        // method description
        $this->method_description = __('This plugin allows you to accept payments on your website. TEST Payment under PHP 8.2.12 / WP 6.7.2 / WC 9.6.2', TEST_PAYMENT_TEXT_DOMAIN);        
        // supports
        $this->supports = array(
            'products'
        );
       // Add Form fields
       $this->init_form_fields();        
       // Process admin options
       add_action('woocommerce_update_options_payment_gateways_' . $this->id, [$this, 'process_admin_options']);
    }
    
    /**
     * Initialize Form fields
     * 
     * @since 1.0.0
     */
    public function init_form_fields()
    {
        $form_fields = apply_filters('woo_test_payment', [
            'enabled' => [
                'title' => __('Enable/Disable', TEST_PAYMENT_TEXT_DOMAIN),
                'type'  => 'checkbox',
                'label' => __('Enable Test payment Gateway', TEST_PAYMENT_TEXT_DOMAIN),
                'default' => 'no'
                ],
            // test mode select
            
            'test_mode' => [
                'title' => __('Test Mode', TEST_PAYMENT_TEXT_DOMAIN),
                'type'  => 'select',
                'label' => __('Select the Test Mode', TEST_PAYMENT_TEXT_DOMAIN),
                'options' => [
                    'yes' => __('Yes', TEST_PAYMENT_TEXT_DOMAIN),
                    'no' => __('No', TEST_PAYMENT_TEXT_DOMAIN),
                ],
                'default' => 'yes',
                'desc_tip' => TRUE
            ],
            'title' => [
                'title' => __('Title', TEST_PAYMENT_TEXT_DOMAIN),
                'type'  => 'text',
                'description' => __('This controles the title which the user see during checkout', TEST_PAYMENT_TEXT_DOMAIN),
                'default' => __('Test Payment Gateway', TEST_PAYMENT_TEXT_DOMAIN),
                'desc_tip' => TRUE
            ],
            'description' => [
                'title' => __('Description', TEST_PAYMENT_TEXT_DOMAIN),
                'type'  => 'textarea',
                'description' => __('This controles the description which the user see during checkout', TEST_PAYMENT_TEXT_DOMAIN),
                'default' => __('Pay with your credit card via Test Payment Gateway', TEST_PAYMENT_TEXT_DOMAIN),
                'desc_tip' => TRUE
            ],
            'live_public_key' => [
                'title' => __('Live Public Key', TEST_PAYMENT_TEXT_DOMAIN),
                'type'  => 'text',
                'description' => __('This is the Live public key provided by Test Payment Gateway', TEST_PAYMENT_TEXT_DOMAIN),
                'default' => '',
                'desc_tip' => TRUE
            ],
            'live_secret_key' => [
                'title' => __('Live Secret Key', TEST_PAYMENT_TEXT_DOMAIN),
                'type'  => 'text',
                'description' => __('This is the Live secret key provided by Test Payment Gateway', TEST_PAYMENT_TEXT_DOMAIN),
                'default' => '',
                'desc_tip' => TRUE
            ], 
            // test public key
            'test_public_key' => [
                'title' => __('Test Public Key', TEST_PAYMENT_TEXT_DOMAIN),
                'type'  => 'text',
                'description' => __('This is the Test public key provided by Test Payment Gateway', TEST_PAYMENT_TEXT_DOMAIN),
                'default' => '',
                'desc_tip' => TRUE
                ],
            // test secret key
            'test_secret_key' => [
                'title' => __('Test Secret Key', TEST_PAYMENT_TEXT_DOMAIN),
                'type'  => 'text',
                'description' => __('This is the Test secret key provided by Test Payment Gateway', TEST_PAYMENT_TEXT_DOMAIN),
                'default' => '',
                'desc_tip' => TRUE
            ]
            ]);
            // returt form fields to WooCommerce
            $this->form_fields = $form_fields;
    }
    
}
