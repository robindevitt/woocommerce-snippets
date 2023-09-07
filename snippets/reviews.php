<?php

/**
 * Custom filter to bypass reviews when they are required for logged in users only and you wish to enable reviews for "guests".
 * appending the "reviews" param to the URL and the value is "allow" will let reviews be submitted.
 **/
add_filter('woocommerce_pre_customer_bought_product', 'custom_woocommerce_pre_customer_bought_product', 9999, 4);
function custom_woocommerce_pre_customer_bought_product($bought, $customer_id, $product_id, $quantity) {
	$reviews = '';
	if ( isset( $_SERVER['HTTP_REFERER'] ) ){
		$urlParts = parse_url( $_SERVER['HTTP_REFERER'] );
		if ( isset( $urlParts['query'] ) ) {
			// Parse the query string into an array of parameters
			parse_str( $urlParts['query'], $queryParams );
			// Access individual parameters
			$reviews = isset( $queryParams['reviews'] ) ? $queryParams['reviews'] : false;
		} 
	}
	$reviews = ( ! empty( $_GET ) && isset( $_GET['reviews'] ) ? $_GET['reviews'] : $reviews );
	if( isset( $reviews ) && $reviews === 'allow' ){
		return true;
	}
	return null;
}
