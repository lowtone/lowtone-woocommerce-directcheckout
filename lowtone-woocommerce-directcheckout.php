<?php
/*
 * Plugin Name: Direct Checkout for WooCommerce
 * Plugin URI: http://wordpress.lowtone.nl/plugins/woocommerce-directcheckout/
 * Description: Link directly to the checkout page.
 * Version: 1.0
 * Author: Lowtone <info@lowtone.nl>
 * Author URI: http://lowtone.nl
 * License: http://wordpress.lowtone.nl/license
 */
/**
 * @author Paul van der Meijs <code@lowtone.nl>
 * @copyright Copyright (c) 2011-2012, Paul van der Meijs
 * @license http://wordpress.lowtone.nl/license/
 * @version 1.0
 * @package wordpress\plugins\lowtone\woocommerce\directcheckout
 */

namespace lowtone\woocommerce\directcheckout {

	add_action("plugins_loaded", function() {
		if (!class_exists("Woocommerce"))
			return;

		add_action("template_redirect", function() {
			if (!isset($_REQUEST["direct_checkout"]))
				return;

			global $woocommerce;

			$woocommerce->cart->empty_cart();

			$products = @$_REQUEST["direct_checkout"]["products"];

			foreach ($products as $product) 
				$woocommerce->cart->add_to_cart(@$product["id"], @$product["quantity"] ?: 1);
				
			wp_safe_redirect($woocommerce->cart->get_checkout_url());

			exit;
		});
	});

}