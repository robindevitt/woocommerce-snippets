<?php
/**
 * For admin emails only, add a "Package Details:" section.
 * Add's the product's combines dimensions and weight.
 */

add_action( 'woocommerce_email_after_order_table', 'rbd_email_after_order_table', 10, 4 );

/**
 * Function for `woocommerce_email_after_order_table` action-hook.
 *
 * @param object $order Order object.
 * @param bool   $sent_to_admin Sent to admin.
 * @param object $plain_text Email format: plain text or HTML.
 * @param object $email The email object.
 *
 * @return void
 */
function rbd_email_after_order_table( $order, $sent_to_admin, $plain_text, $email ) {
	if ( $sent_to_admin ) { // Check if sent to admin is true.
		$shipping_values = array();
		// Setup the shipping values for each product ordered.
		foreach ( $order->get_items() as $item_id => $item ) {
			$product = $item->get_product();
			if ( $product ) {
				$shipping_values[] = array(
					'product' => $item->get_name(),
					'qty'     => $item->get_quantity(),
					'length'  => ( $product->get_length() ? $product->get_length() : '' ),
					'width'   => ( $product->get_width() ? $product->get_width() : '' ),
					'height'  => ( $product->get_height() ? $product->get_height() : '' ),
					'weight'  => ( $product->get_weight() ? $product->get_weight() : '' ),
				);
			}
		}

		if ( ! empty( $shipping_values ) ) { // Check $shipping_values isn't empty.
			$html = '<div style="margin-bottom: 40px;">';

				$html .= '<h4>' . esc_html__( 'Package Details', 'textdomain' ) . ':</h4>';
				$html .= '<table class="td" cellspacing="0" cellpadding="6" style="width:100%; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;" border="1">';

					$html .= '<thead>';

						$html     .= '<tr>';
							$html .= '<td>' . esc_html__( 'Product', 'textdomain' ) . '</td>';
							$html .= '<td>' . esc_html__( 'Quantity', 'textdomain' ) . '</td>';
							$html .= '<td>' . esc_html__( 'Total Dimensions', 'textdomain' ) . '</td>';
							$html .= '<td>' . esc_html__( 'Total Weight', 'textdomain' ) . '</td>';
						$html     .= '</tr>';

					$html .= '</thead>';

					$html .= '<tbody>';
					foreach ( $shipping_values as $shipping_item ) {
						$html .= '<tr>';

							$html .= '<td>' . $shipping_item['product'] . '</td>';
							$html .= '<td>' . $shipping_item['qty'] . '</td>';
							$html .= '<td>' . $shipping_item['length'] . ' x ' . $shipping_item['width'] . ' x ' . ( $shipping_item['height'] * $shipping_item['qty'] ) . ' cm</td>';
							$html .= '<td>' . ( $shipping_item['weight'] * $shipping_item['qty'] ) . ' kg</td>';

						$html .= '</tr>';
					}
					$html .= '</tbody>';

				$html .= '</table>';
			$html     .= '</div>';

			echo $html;
		}
	} // Close of if is set to admin.
}
