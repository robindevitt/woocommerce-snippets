<?php

/**
 * This functionality add a button to all products.
 * Simple products will be a add to cart button.
 * Non simple products will say "view product".
 */
add_action( 'woocommerce_after_shop_loop_item', 'rd_add_to_cart_button', 10 );

function rd_add_to_cart_button() {

  global $product;

  if (  $product->is_type( 'simple' ) ) {

   echo '<a href="' . esc_url( $product->add_to_cart_url() ) . '" class="buy-now button">' . esc_html__( 'Add to cart', 'text-domain' ) . '</a>';
   
  } else {

    echo '<a href="' . esc_url( get_permalink( $product->get_id() ) ) . '" class="buy-now button">' . esc_html__( 'View product', 'text-domain' ) . '</a>';

  }

}