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
}
