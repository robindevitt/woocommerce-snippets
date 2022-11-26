<?php
/**
 * Exclude products from a particular category on the shop page
 * Replace 'clothing' with your own cateogry. 
 * You can also list multipel categories to be excluded: 'clothing', 'music'
 */
function rd_exclude_specific_cateogry_from_shop_page( $query ) {

    $tax_query = (array) $query->get( 'tax_query' );

    $tax_query[] = array(
           'taxonomy' => 'product_cat',
           'field' => 'slug',
           'terms' => array( 'clothing' ), // Don't display products in the clothing category on the shop page.
           'operator' => 'NOT IN'
    );


    $query->set( 'tax_query', $tax_query );

}
add_action( 'woocommerce_product_query', 'rd_exclude_specific_cateogry_from_shop_page' );
