<?php
/**
 * Exclude products from a particular category on the shop page
 * Replace 'my-category-slug' with your own cateogry. 
 * You can also list multipel categories to be excluded: 'my-category-slug-one', 'my-category-slug-two'
 */
function rd_exclude_specific_cateogry_from_shop_page( $query ) {

    $tax_query = (array) $query->get( 'tax_query' );

    $tax_query[] = array(
           'taxonomy' => 'product_cat',
           'field' => 'slug',
           'terms' => array( 'my-category-slug' ), // Don't display products in the my-category-slug category on the shop page.
           'operator' => 'NOT IN'
    );


    $query->set( 'tax_query', $tax_query );

}
add_action( 'woocommerce_product_query', 'rd_exclude_specific_cateogry_from_shop_page' );
