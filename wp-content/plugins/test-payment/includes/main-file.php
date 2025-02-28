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
     *  Title
     *
     */
    public $title;
    
    /**
     *  Description
     *
     */
    public $description;
    
    
    
    /**
     *  test_public_key
     *
     */
    public $test_public_key;
    
    /**
     *  test_secret_key
     *
     */
    public $test_secret_key;
    
    /**
     *  live_public_key
     *
     */
    public $live_public_key;
    
    /**
     *  live_secret_key
     *
     */
    public $live_secret_key;
    
    /**
     * saved_cards
     * 
     */
    public $saved_cards;
    
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
       
       /////// ADD FORM FIELDS ///////
       $this->title = $this->get_option('title');
       $this->description = $this->get_option('description');
       $this->enabled = $this->get_option('enabled');
       
       // saved cards
       $this->saved_cards = FALSE;
       
       $this->test_mode = 'yes' === get_option('test_mode') ? true : false;
       
       $this->test_public_key = $this->get_option('test_public_key');       
       $this->test_secret_key = $this->get_option('test_secret_key');
       
       $this->live_public_key = $this->get_option('live_public_key');
       $this->live_secret_key = $this->get_option('live_secret_key');
       
       $this->public_key = $this->test_mode ? $this->test_public_key : $this->live_public_key;
       $this->secret_key = $this->test_mode ? $this->test_secret_key : $this->live_secret_key;
       
       // Process admin options
       add_action('woocommerce_update_options_payment_gateways_' . $this->id, [$this, 'process_admin_options']);
       // Admin script
       add_action('admin_enqueue_scripts', [$this, 'admin_scripts']);       
       // woocommerce available payment gateways
       add_action('woocommerce_available_payment_gateways', [$this, 'available_payment_gateways']);
       
    }
    
    
    /**
     * Get Test payment icon URL.
     */
    public function get_logo_url()
    {
        $url = WC_HTTPS::force_https_url(TEST_PAYMENT_PLUGIN_URL . '/assets/images/visa_master.png');
        return apply_filters('woocommerce_test_payment_icon', $url, $this->id);
    }
    
    
    /**
     * available_payment_gateways
     * 
     */
    // Ensures only active and enabled payment gateways appear at checkout.
    public function available_payment_gateways($available_gateways)
    {
        if (!$this->is_available()){
            // unset the gateway
            unset($available_gateways[$this->id]);
        }
        return $available_gateways;
    }
    
    
    /**
     * is availble
     *
     */
    public function is_available() {
        return $this->enabled === 'yes';
    }
    
    
    /**
     * Admin scripts
     * 
     * @since 1.0.0
     */
    public function admin_scripts()
    {
        wp_enqueue_script('test-admin-script', TEST_PAYMENT_PLUGIN_URL . 'assets/js/admin.js', ['jquery'], TEST_PAYMENT_VERSION, TRUE);
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
                'title' => __('Payment Mode', TEST_PAYMENT_TEXT_DOMAIN),
                'type'  => 'select',
                'label' => __('Select the Test Mode', TEST_PAYMENT_TEXT_DOMAIN),
                'options' => [
                    'yes' => __('Test', TEST_PAYMENT_TEXT_DOMAIN),
                    'no' => __('Live', TEST_PAYMENT_TEXT_DOMAIN),
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
