<?php
/**
 * HTML Template Email
 *
 * @package YITH Woocommerce Request A Quote
 * @since   1.0.0
 * @version 2.2.7
 * @author  YITH
 */

/**
 * @var $order    WC_Order
 */

$border   = true;
$order_id = yit_get_prop( $order, 'id', true );

if ( function_exists( 'icl_get_languages' ) ) {
	global $sitepress;
	$lang = yit_get_prop( $order, 'wpml_language', true );
	YITH_Request_Quote_Premium()->change_pdf_language( $lang );
}
add_filter( 'woocommerce_is_attribute_in_product_name', '__return_false' );

// BEGIN GM CUSTOM
$hide_price = false;
$order = wc_get_order( $order_id );

if ( $order->get_status() === 'ywraq-new' ) {
	$hide_price = true;
}
// END GM CUSTOM
?>

<?php
$after_list = yit_get_prop( $order, '_ywcm_request_response', true );
if ( '' !== $after_list ) :
	?>
	<div class="after-list">
		<p><?php echo wp_kses_post( apply_filters( 'ywraq_quote_before_list', nl2br( $after_list ), $order_id ) ); ?></p>
	</div>
<?php endif; ?>

<?php do_action( 'yith_ywraq_email_before_raq_table', $order ); ?>

<?php
	$columns = get_option( 'ywraq_pdf_columns', 'all' );
	/* be sure it is an array */
	if ( ! is_array( $columns ) ) {
		$columns = array( $columns );
	}
	$colspan = 0;
?>
<div class="table-wrapper">
	<div class="mark"></div>
	<table class="quote-table" cellspacing="0" cellpadding="6" style="width: 100%;" border="0">
		<thead>
		<tr>
			<?php if ( get_option( 'ywraq_show_preview' ) === 'yes' || in_array( 'all', $columns, true ) || in_array( 'thumbnail', $columns, true ) ) : ?>
				<th scope="col" style="text-align:left; border: 1px solid #eee;">
					<?php esc_html_e( 'Preview', 'yith-woocommerce-request-a-quote' ); ?>
				</th>
			<?php endif ?>
			<?php if ( in_array( 'all', $columns, true ) || in_array( 'product_name', $columns, true ) ) : ?>
				<th scope="col" style="text-align:left; border: 1px solid #eee;">
					<?php esc_html_e( 'Product', 'yith-woocommerce-request-a-quote' ); ?>
				</th>
			<?php endif ?>
			<?php //if ( in_array( 'all', $columns, true ) || in_array( 'unit_price', $columns, true ) ) : ?>
			<!--BEGIN GM CUSTOM-->
			<?php if ( !$hide_price && (in_array( 'all', $columns, true ) || !$hide_price && in_array( 'unit_price', $columns, true )) ) : ?>
			<!--END GM CUSTOM-->
				<!-- <th scope="col" style="text-align:left; border: 1px solid #eee;"> -->
				<!--Begin GM CUSTOM-->
				<th scope="col" style="text-align:right; border: 1px solid #eee;">
				<!--END GM CUSTOM-->					
				<?php esc_html_e( 'Unit&nbsp;Price', 'yith-woocommerce-request-a-quote' ); ?>
				</th>
			<?php endif ?>
			<?php if ( in_array( 'all', $columns, true ) || in_array( 'quantity', $columns, true ) ) : ?>
			<!--END GM CUSTOM-->
				<!-- <th scope="col" style="text-align:left; border: 1px solid #eee;"> -->
				<!--Begin GM CUSTOM-->
				<th scope="col" style="text-align:center; border: 1px solid #eee;">
				<!--END GM CUSTOM-->		
					<?php esc_html_e( 'QTY', 'yith-woocommerce-request-a-quote' ); ?>
				</th>
			<?php endif ?>
			<?php //if ( in_array( 'all', $columns, true ) || in_array( 'product_subtotal', $columns, true ) ) : ?>
			<!--BEGIN GM CUSTOM-->
			<?php if ( !$hide_price && (in_array( 'all', $columns, true ) || !$hide_price && in_array( 'product_subtotal', $columns, true )) ) : ?>
			<!--END GM CUSTOM-->
				<!-- <th scope="col" style="text-align:left; border: 1px solid #eee;"> -->
				<!--Begin GM CUSTOM-->
				<th scope="col" style="text-align:right; border: 1px solid #eee;">
				<!--END GM CUSTOM-->
					<?php esc_html_e( 'Subtotal', 'yith-woocommerce-request-a-quote' ); ?>
				</th>
			<?php endif ?>
		</tr>
		</thead>
		<tbody>
		<?php
		$items    = $order->get_items();
		$currency = $order->get_currency();

		if ( ! empty( $items ) ) :

			foreach ( $items as $item ) :

				if ( isset( $item['variation_id'] ) && $item['variation_id'] ) {
					$_product = wc_get_product( $item['variation_id'] );
				} else {
					$_product = wc_get_product( $item['product_id'] );
				}

				$title = $_product->get_title();

				if ( $_product->get_sku() !== '' && get_option( 'ywraq_show_sku' ) === 'yes' ) {
					$sku    = apply_filters( 'ywraq_sku_label', __( ' SKU:', 'yith-woocommerce-request-a-quote' ) ) . $_product->get_sku();
					$title .= ' ' . apply_filters( 'ywraq_sku_label_html', $sku, $_product );
				}

				$subtotal   = wc_price( $item['line_total'], array( 'currency' => $currency ) );
				$unit_price = wc_price( $item['line_total'] / $item['qty'], array( 'currency' => $currency ) );

				if ( get_option( 'ywraq_show_old_price' ) === 'yes' ) {
					$subtotal   = ( $item['line_subtotal'] !== $item['line_total'] ) ? '<small><del>' . wc_price( $item['line_subtotal'], array( 'currency' => $currency ) ) . '</del></small> ' . wc_price( $item['line_total'], array( 'currency' => $currency ) ) : wc_price( $item['line_subtotal'], array( 'currency' => $currency ) );
					$unit_price = ( $item['line_subtotal'] !== $item['line_total'] ) ? '<small><del>' . wc_price( $item['line_subtotal'] / $item['qty'], array( 'currency' => $currency ) ) . '</del></small> ' . wc_price( $item['line_total'] / $item['qty'] ) : wc_price( $item['line_subtotal'] / $item['qty'], array( 'currency' => $currency ) );
				}

				$im = false;

				?>
				<tr>
					<?php if ( get_option( 'ywraq_show_preview' ) === 'yes' || in_array( 'all', $columns, true ) || in_array( 'thumbnail', $columns, true ) ) : ?>
						<!--<td scope="col" style="text-align:center;">-->
						<!--BEGIN GM CUSTOM-->
						<td scope="col" style="text-align:center;border-left: 1px solid #eee;">
						<!--END GM CUSTOM-->
							<?php
							$image_id = $_product->get_image_id();
							if ( $image_id ) {
								$thumbnail_id  = $image_id;
								$thumbnail_url = apply_filters( 'ywraq_pdf_product_thumbnail', get_attached_file( $thumbnail_id ), $thumbnail_id );
							} else {
								$thumbnail_url = function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src() : '';
							}
							$thumbnail = sprintf( '<img src="%s" style="max-width:100px;"/>', $thumbnail_url );

							++$colspan;
							if ( ! $_product->is_visible() ) {
								echo $thumbnail; //phpcs:ignore
							} else {
								printf( '<a href="%s">%s</a>', esc_url( $_product->get_permalink() ), $thumbnail ); //phpcs:ignore
							}
							?>
						</td>
					<?php endif ?>

					<?php if ( in_array( 'all', $columns, true ) || in_array( 'product_name', $columns, true ) ) : ?>
						<!--<td scope="col" style="text-align:center;">-->
						<!--BEGIN GM CUSTOM-->
						<td scope="col" style="text-align:left;border-left: 1px solid #eee;">
						<!--END GM CUSTOM-->
							<?php
							// echo esc_html( $title );
							//BEGIN GM CUSTOM
							echo '<a style="text-decoration: none; color: #e2ad68; font-weight: bold;" target="_blank" href="' . esc_url( $_product->get_permalink() ) . '">' . esc_html( $title ) . '</a>';
							// END GM CUSTOM
							++$colspan;
							?>
							<small>
								<?php
							//BEGIN GM CUSTOM	
							echo '<div class="product-description">';
							$product_id  = '';
							$variation_description = '';
							if($_product->is_type('variable') || $_product->is_type('variation')) {
								$product_id = $_product->get_parent_id();
								$variation_description_raw = strip_tags($_product->get_variation_description());
								if($variation_description_raw != '' && $variation_description_raw != null) {
									$variation_description = '<ul class="wc-item-meta" style="margin-bottom: -4px !important;"><li><strong class="wc-item-meta-label">DESCRIPTION:&nbsp;</strong><p>' . $variation_description_raw . '</p></li></ul>';
								}

							} else if($_product->is_type('simple')) {
								$product_id = $_product->get_id();
							}
							if($product_id != '') {
								$product = wc_get_product($product_id);
								$product_short_description = $product->get_short_description();

									echo strip_tags( substr($product->get_short_description(), 0 , 200)) . '&hellip; <a style="text-decoration: none; color: #e2ad68;" target="_blank" href="' . esc_url( $_product->get_permalink() ) . '">Read More</a>';
								
							}
							echo '</div>';
							echo $variation_description;

							//END GM CUSTOM
							if ( $im ) {
								$im->display();
							} else {
								wc_display_item_meta( $item );
							}

							?>
							</small>
						</td>
					<?php endif ?>
					<?php //if ( in_array( 'all', $columns, true ) || in_array( 'unit_price', $columns, true ) ) : ?>
					<!--BEGIN GM CUSTOM-->
					<?php if ( !$hide_price && (in_array( 'all', $columns, true ) || !$hide_price &&  in_array( 'unit_price', $columns, true )) ) : ?>
					<!--END GM CUSTOM-->
						<?php ++$colspan; ?>
						<!-- <td scope="col" style="text-align:center;"><?php //echo wp_kses_post( $unit_price ); ?></td> -->
						<!--BEGIN GM CUSTOM-->
						<td scope="col" style="text-align:right;"><?php echo wp_kses_post( $unit_price ); ?></td>
						<!--END GM CUSTOM-->
					<?php endif ?>
					<?php if ( in_array( 'all', $columns, true ) || in_array( 'quantity', $columns, true ) ) : ?>
						<?php ++$colspan; ?>
						<td scope="col" style="text-align:center;"><?php echo esc_html( $item['qty'] ); ?></td>
					<?php endif ?>
					<?php //if ( in_array( 'all', $columns, true ) || in_array( 'product_subtotal', $columns, true ) ) : ?>
					<!--BEGIN GM CUSTOM-->
					<?php if ( !$hide_price && (in_array( 'all', $columns, true ) || !$hide_price && in_array( 'product_subtotal', $columns, true )) ) : ?>
					<!--END GM CUSTOM-->
						<?php ++$colspan; ?>
						<td scope="col" class="last-col" style="text-align:right;  border-right: 1px solid #eee">
							<?php echo wp_kses_post( apply_filters( 'ywraq_quote_subtotal_item', ywraq_formatted_line_total( $order, $item ), $item['line_total'], $_product ) ); ?>
						</td>
					<?php endif ?>
				</tr>

				<?php
			endforeach;
			?>

			<?php
			if ( !$hide_price && 'no' === get_option( 'ywraq_pdf_hide_total_row', 'no' ) ) {
				foreach ( $order->get_order_item_totals() as $key => $total ) {
					if ( ! apply_filters( 'ywraq_hide_payment_method_pdf', false ) || $key !== 'payment_method' ) :
						?>
						<tr>
							<th scope="col" colspan="4"
								style="text-align:right;"><?php echo esc_html( $total['label'] ); ?></th>
							<td scope="col" class="last-col"
								style="text-align:right;"><?php echo wp_kses_post( $total['value'] ); ?></td>
						</tr>

					<?php endif; ?>
					<?php
				}
			}
			?>
		<?php endif; ?>


		</tbody>
	</table>
</div>
<?php if ( get_option( 'ywraq_pdf_link' ) === 'yes' ) : ?>
	<div>
		<table>
			<tr>
				<?php if ( get_option( 'ywraq_show_accept_link' ) !== 'no' ) : ?>
					<td><a href="<?php echo esc_url( ywraq_get_accepted_quote_page( $order ) ); ?>"
						   class="pdf-button"><?php ywraq_get_label( 'accept', true ); ?></a></td>
					<?php
				endif;
				echo ( get_option( 'ywraq_show_accept_link' ) !== 'no' && get_option( 'ywraq_show_reject_link' ) !== 'no' ) ? '<td><span style="color: #666666">|</span></td>' : '';
				if ( get_option( 'ywraq_show_reject_link' ) !== 'no' ) :
					?>
					<td><a href="<?php echo esc_url( ywraq_get_rejected_quote_page( $order ) ); ?>"
						   class="pdf-button"><?php ywraq_get_label( 'reject', true ); ?></a></td>
				<?php endif ?>
			</tr>
		</table>
	</div>
<?php endif ?>

<?php do_action( 'yith_ywraq_email_after_raq_table', $order ); ?>

<?php $after_list = apply_filters( 'ywraq_quote_after_list', yit_get_prop( $order, '_ywraq_request_response_after', true ), $order_id ); ?>

<?php if ( '' !== $after_list ) : ?>
	<div class="after-list">
		<p><?php echo wp_kses_post( nl2br( $after_list ) ); ?></p>
	</div>
<?php endif; ?>
