<?php
/**
 * Quick order search / navigation.
 * Works with: Sequential Order Numbers for WooCommerce @link https://wordpress.org/plugins/woocommerce-sequential-order-numbers/
 */

// Add shop order search in the admin bar
add_action( 'admin_bar_menu', 'admin_bar_shop_order_form', 40 );
function admin_bar_shop_order_form() {
	global $wp_admin_bar;

	$search_query = '';

	if ( isset( $_GET['s'] ) && ! empty( $_GET['s'] ) ) {

		$search_query = ! empty ( $_GET['s'] ) ? $_GET['s'] : '';

		// This If statement checks that the search query is a number, then does a lookup against Sequential order numbers plugin.
		if ( is_numeric( $search_query ) && intval( $search_query ) == $search_query ) {
			
			// Set the order number to zero.
			$order_number = 0;

			// Check if wc_sequential_order_numbers is available.
			if ( function_exists( 'wc_sequential_order_numbers' ) ) {
				$order_number = wc_sequential_order_numbers()->find_order_by_order_number( $search_query );
			}

			// When the order number is zero, we have no orders- use the search query instead.
			$search_query = ( 0 === $order_number ? $search_query : $order_number );
		}

		// Setup the redirect.
		$order = get_post( $search_query );

		if ( $order ) {
			// Do the redirect.
			wp_redirect( get_edit_post_link( $order->ID, '' ) );
			exit;
		
		}

	}

	// Add the search box to the admin bar.
  	$wp_admin_bar->add_menu(
		array (
			'id' => 'admin_bar_shop_order_form',
			'title' => '<form method="get" action="'.get_site_url().'/wp-admin/edit.php?post_type=shop_order" style="display: flex; height: 100%; box-sizing: border-box;">
				<input name="s" type="text" placeholder="Order# / Email" value="' . $search_query . '" style="border:0; width:100px; padding: 0 5px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;background-color: #333; color: #fff;"/>
				<input name="post_type" value="shop_order" type="hidden">
			</form>'
		)
	);
}

