<?php
/*
** adding necessarey files
*/

function arrowdesign_add_rtn_to_shop_btn_Style_script() {
	// 25/10 : Caching
    wp_enqueue_style('arrowdesign_add_rtn_to_shop_btn_main_style_file', plugins_url('/css/style.css', __FILE__), '', time());
    wp_enqueue_script('arrowdesign_add_rtn_to_shop_btn_logic_file', plugins_url('/js/logic.js',__FILE__ ), array(), time(), true);
}
add_action('admin_enqueue_scripts', 'arrowdesign_add_rtn_to_shop_btn_Style_script');

/**
 * Adds a new settings page under Setting menu
*/
add_action( 'admin_menu', 'arrowdesign_add_rtn_to_shop_btn_admin_page' );
function arrowdesign_add_rtn_to_shop_btn_admin_page() {
    //only editor and administrator can add a polling
    if ( current_user_can('editor') || current_user_can('administrator') ) {
		
		add_options_page( __( 'Continue Shopping From Cart' ), __( 'Continue Shopping From Cart' ), 'manage_options', 'ContinueShoppingFromCart', 'arrowdesign_add_return_to_shop_button_homepage' );
		
		// 25/10 - Add a nonce on URL
		$page	= menu_page_url('ContinueShoppingFromCart', false);		// Get URL
		$nonce	= arrowdesign_add_return_to_shop_button_commonNonce();  // Get a nonce

		$custom_url = add_query_arg(array(
			'nonce' => $nonce
		), $page);

		// Update the link of admin menu
		global $submenu;
		if (isset($submenu['options-general.php'])) {
			foreach ($submenu['options-general.php'] as &$item) {
				if ($item[2] === 'ContinueShoppingFromCart') {
					$item[2] = $custom_url;
					break;
				}
			}
		}
	}
}

/**
* Tabs Method
*/
function arrowdesign_add_return_to_shop_button_show_tabs_list( $current = 'first' ) {
    $tabs = array(
        'first'   => __( 'Update Button Text', 'plugin-textdomain' ),
	);

    $html = '<h2 class="wooLiveSalenav-tabnav-tab-wrapper">';
    
	foreach( $tabs as $tab => $ad_txt_input_field_for_rtn_to_shop_lbl ){
        $class = ( $tab == $current ) ? 'nav-tab-active' : '';
        $html .= '<a class="nav-tab ' . esc_html($class) . '" href="?page=AddReturnToShopButton&tab=' . esc_html($tab) . '">' . esc_html($ad_txt_input_field_for_rtn_to_shop_lbl) . '</a>';
    }

    $html .= '</h2>';

	// 25/10 : $html → wp_kses_post($html);
    echo wp_kses_post($html);
}

function arrowdesign_add_return_to_shop_button_homepage(){
    ?>
    <div class="cont-p-dashboard">
        <div class="post_like_dislike_header wrap">
        	<h3>Dashboard for changing woocommerce 'Proceed to Checkout' button text.</h3>
			<p>Click the following link to contact Arrow Design for
				<span>
		    		<a href="https://arrowdesign.ie">Web Design</a>, Support or WordPress Plugin Development.
        		</span>
			</p>
    	</div>
    <?php

	// 25/10 - To check nonce
	if ( !empty($_GET['nonce']) && wp_verify_nonce($_GET['nonce'], 'arrowdesign_add_return_to_shop_button_commonNonce') ) {
		
		// ================== Tabs ========================//
		$tab = ( ! empty( $_GET['tab'] ) ) ? esc_attr( $_GET['tab'] ) : 'first';
		arrowdesign_add_return_to_shop_button_show_tabs_list( $tab );
	
	   // =========================== Tab 1 ========================//
		if ( $tab == 'first' ) {
			?>
			<div class="woo-live-saleTabs woo-live-sale-firstTab">
				<!--First tab -->
				<div class="setting-left-sp">
					<div class="list-sp list-sp-left">
	
						<h2>Instructions </h2>
						<h4>Enter text [to display beside button] in the textbox</h4>
						<h4>Enter text [to display on button] in the textbox</h4>
						<h4>Click update to save</h4>
						<h4>The textboxs will display your saved text</h4>
						<h4>A button and descriptive test will display on the cart page</h4>
						<h4>Your saved text will display [beside and on the button] </h4>
	
	
					</div>
					<div class="list-sp list-polling-right">
			<?php
			$ad_rtn_to_shop_txt = "";
	
			if (isset($_POST['btn-to-update-text-rtn-to-shop-ad'])) {
			//add or update lbl txt to db meta from user input on form
			$ad_txt_input_field_for_rtn_to_shop_lbl = sanitize_text_field ( $_POST['text-for-rtn-to-shop-on-lbl-ad'] );
			$ad_rtn_to_shop_txt = get_term_meta('2020', 'ad_rtn_to_shop_lbl_meta', true);
			if(is_null($ad_rtn_to_shop_txt)){
			add_term_meta('2020', "ad_rtn_to_shop_lbl_meta" ,$ad_txt_input_field_for_rtn_to_shop_lbl);
			} //end add term data on first use [lbl txt]
	
			else{
			update_term_meta( '2020', "ad_rtn_to_shop_lbl_meta", $ad_txt_input_field_for_rtn_to_shop_lbl);
			} //end update term data on additional usage [lbl txt]
	
			//add or update btn txt to db meta from user input on form
			$ad_txt_input_field_for_rtn_to_shop_btn = sanitize_text_field ( $_POST['text-for-rtn-to-shop-btn-ad'] );
			$ad_rtn_to_shop_btn_txt = get_term_meta('2020', 'ad_rtn_to_shop_btn_txt_meta', true);
	
			if(is_null($ad_rtn_to_shop_btn_txt)){
			add_term_meta('2020', "ad_rtn_to_shop_btn_txt_meta" ,$ad_txt_input_field_for_rtn_to_shop_btn);
			} //end add term data on first use [btn txt]
	
			else{
			update_term_meta( '2020', "ad_rtn_to_shop_btn_txt_meta", $ad_txt_input_field_for_rtn_to_shop_btn);
			} //end update term data on additional usage [btn txt]
	
	
			}//end if button was clicked
	
	
	
			//form for saving and displaying the text
			$ad_rtn_to_shop_txt_lbl_txtbx = get_term_meta('2020', 'ad_rtn_to_shop_lbl_meta', true);
			$ad_rtn_to_shop_btn_txt_txtbx = get_term_meta('2020', 'ad_rtn_to_shop_btn_txt_meta', true);
	
			?>
							<!-- form to handle user input of text for button and beside button -->
							<br><br>
							<h2>Enter Your Choosen Text In The Fields Below</h2>
							<form method="POST" action="">
								<!-- 25/10 : Add nonce -->
								<input type="hidden" name="nonce" value="<?php echo esc_html(arrowdesign_add_return_to_shop_button_commonNonce()) ?>">
								<label for="text-for-rtn-to-shop-ad">Text Display Beside Button</label>
								<!-- 25/10 : esc_html -->
								<input type="text" name="text-for-rtn-to-shop-on-lbl-ad" class="names-list first-name" value="<?php echo esc_html($ad_rtn_to_shop_txt_lbl_txtbx); ?>">
				
								<label for="text-for-rtn-to-shop-on-btn-ad">Text Display On Button</label>
								<!-- 25/10 : esc_html -->
								<input type="text" name="text-for-rtn-to-shop-btn-ad" class="names-list first-name" value="<?php echo esc_html($ad_rtn_to_shop_btn_txt_txtbx); ?>">
								<label for="text-for-rtn-to-shop-on-btn-ad">Click 'Update' To Save Your Text</label>
								<button class="button-primary update-names-and-titles" name="btn-to-update-text-rtn-to-shop-ad" type="submit">Update</button>
							</form>
						</div>
					</div>
				</div>
				<div class="display-right-sp">
	
				</div>
			</div>	
			<?php
		}
	}
}

// 25/10 - To create nonce
function arrowdesign_add_return_to_shop_button_commonNonce() {
	return wp_create_nonce('arrowdesign_add_return_to_shop_button_commonNonce');
}