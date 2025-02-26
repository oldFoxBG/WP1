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
    //function function_construct()
    public function __construct()
    {
        // id
        $this->id = 'test_payment';
        // has fields
        $this->has_fields = TRUE;
        // method title
        $this->method_title = __('Test Payment Gateway', TEST_PAYMENT_TEXT_DOMAIN);
        //$this->method_title =  'Test Payment Gateway';
        $this->method_description = __('This plugin allows you to accept payments on your website. TEST Payment under PHP 8.2.12 / WP 6.7.2 / WC 9.6.2', TEST_PAYMENT_TEXT_DOMAIN);
        //$this->method_description = 'This plugin allows you to accept payments on your website. TEST Payment under PHP 8.2.12 / WP 6.7.2 / WC 9.6.2';
        // supports
        $this->supports = array(
            'products'
        );
        
        
    }
    
}
