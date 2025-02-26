<?php
// Security check
if (!defined('ABSPATH')) {
    exit("You must not access this file directly");
}
?>
<div class="notice notice-error is-dismissible">
    <p><?php _e('Test Payment Gateway requires WooCommerce to be installed and active.', 'test-payment'); ?></p>
</div>

<script>
    jQuery(document).ready(function ($) {
        // set P in notice-error bold
        $('.notice-error p').css('font-weight', 'bold');
    });
</script>


