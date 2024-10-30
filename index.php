<?php

/*
	Plugin Name: Continue Shopping From Cart Page
	Plugin URI: https://arrowdesign.ie
	Description: A plugin for adding a button to Continue Shopping From Cart Page. Continue Shopping From Cart Page. The button will then be dislayed on the on the cart page.
	Version: 1.3
	Author: Arrow Design
	Author URI: https://arrowdesign.ie/continue-shopping-from-cart-page/
	License: GPLv2 or later
	License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Exit if accessed directly
	if (!defined('ABSPATH'))
    exit;

/*
* Admin panel for saving proceed to checkout
* button text
*/
include_once 'admin/admin.php';

/*
* Hook function for showing continue shopping from cart page
* text on the front end
*/


	function arrowdesign_add_continue_shopping_button_to_cart() {

	//txt for lbl, set defaults or populate from meta
	$ad_rtn_to_shop_txt_lbl = get_term_meta('2020', 'ad_rtn_to_shop_lbl_meta', true);
	if ( ($ad_rtn_to_shop_txt_lbl =="") || (is_null($ad_rtn_to_shop_txt_lbl)) ) {
		$ad_rtn_to_shop_txt_lbl = "Continue Shopping?";
	}

	// txt for btn, set defaults or populate from meta
	$ad_rtn_to_shop_btn_txt = get_term_meta('2020', 'ad_rtn_to_shop_btn_txt_meta', true);
	if ( ($ad_rtn_to_shop_txt =="") || (is_null($ad_rtn_to_shop_txt)) ) {
	$ad_rtn_to_shop_btn_txt="Back To Shop";
	}//end if

	$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );

	echo '<div class="woocommerce-message">';
	// 25/10 : esc_url, esc_html
	echo ' <a href="'. esc_url($shop_page_url) .'" class="button">'. esc_html($ad_rtn_to_shop_btn_txt) .'</a>'. esc_html($ad_rtn_to_shop_txt_lbl);
	echo '</div>';

	}//end function

	add_action( 'woocommerce_before_cart_table', 'arrowdesign_add_continue_shopping_button_to_cart' );


	//add settings link to plugin page
	function ad_csfc_plugin_settings_link($links) {
	  $settings_link_ad_plugin_csfc_Options = '<a href="options-general.php?page=ContinueShoppingFromCart.php">Settings</a>';
	  array_unshift($links, $settings_link_ad_plugin_csfc_Options);
	  return $links;
	}
	$plugin_ad_csfc_bn = plugin_basename(__FILE__);
	add_filter("plugin_action_links_$plugin_ad_csfc_bn", 'ad_csfc_plugin_settings_link' );

	//add documentation link and support link to plugin page
	function ad_plugin_page_doc_meta_csfc( $ad_plugin_links, $file ) {
		if ( plugin_basename( __FILE__ ) == $file ) {
			$ad_plugin_row_meta_csfc = array(
			  'ad_ptct_docs'    => '<a href="' . esc_url( 'https://arrowdesign.ie/continue_shopping_from_cart/' ) . '" target="_blank" aria-label="' . esc_attr__( 'Plugin Additional Links', 'domain' ) . '" >' . esc_html__( 'Documentation', 'domain' ) . '</a>',

			'ad_csfc_support'    => '<a href="' . esc_url( 'https://arrowdesign.ie/contact-arrow-design-2/' ) . '" target="_blank" aria-label="' . esc_attr__( 'Plugin Additional Links', 'domain' ) . '" >' . esc_html__( 'Support', 'domain' ) . '</a>'
			);

			return array_merge( $ad_plugin_links, $ad_plugin_row_meta_csfc );
		}
		return (array) $links;
	}

		add_filter( 'plugin_row_meta', 'ad_plugin_page_doc_meta_csfc', 10, 2 );



?>