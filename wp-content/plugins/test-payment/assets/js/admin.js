/**
 * Test Admin Script
 * 
 */
jQuery(document).ready(function ($) {
	
	/**
	 * Init test mode check
	 * 
	 */
	let test_payment_mode_check = () => {
		// get the value of the selected option
		var selectedValue = $("#woocommerce_test_payment_test_mode").val();
		// check if the selected option is 'yes'
		if	(selectedValue == 'yes') {
			console.log("TEST MODE");
			// show the #woocommerce_test_payment_test_secret_key and woocommerce_test_payment_test_public_key
			$("#woocommerce_test_payment_test_secret_key").closest("tr").show();
			$("#woocommerce_test_payment_test_public_key").closest("tr").show();
			// hide the #woocommerce_test_payment_live_secret_key and woocommerce_test_payment_live_public_key
			$("#woocommerce_test_payment_live_secret_key").closest("tr").hide();
			$("#woocommerce_test_payment_live_public_key").closest("tr").hide();	
		} else {
			console.log("LIVE MODE");
			// show the #woocommerce_test_payment_live_secret_key and woocommerce_test_payment_live_public_key
			$("#woocommerce_test_payment_live_secret_key").closest("tr").show();
			$("#woocommerce_test_payment_live_public_key").closest("tr").show();
			// hide the #woocommerce_test_payment_test_secret_key and woocommerce_test_payment_test_public_key
			$("#woocommerce_test_payment_test_secret_key").closest("tr").hide();
			$("#woocommerce_test_payment_test_public_key").closest("tr").hide();			
		}
	};
	
	/**
	 * On change #woocommerce_test_payment_test_mode
	 * 
	 */
	$("#woocommerce_test_payment_test_mode").change(function (e) {
		e.preventDefault();
		test_payment_mode_check();
	});
	
	// init
	test_payment_mode_check();	
});