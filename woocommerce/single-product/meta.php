<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
$separator = ', ';
?>
<div class="product_meta_container">
	<div class="product_meta">
		<?php do_action( 'woocommerce_product_meta_start' ); ?>

		<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

			<span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?> <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span></span>

		<?php endif; ?>

		<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>

		<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>

		<?php
			$gm_product_taxonomies = gm_get_gm_product_taxonomies();
			$gm_product_icons = array();
			foreach($gm_product_taxonomies as $gm_product_taxonomy) {
				$gm_product_term_list = wp_get_post_terms($product->get_id(), $gm_product_taxonomy);

				if(!empty($gm_product_term_list) && $gm_product_term_list != null && $gm_product_term_list != '') {

					if($gm_product_taxonomy != 'gm_icons' && $gm_product_taxonomy != 'gm_catalogue') {

						$gm_product_taxonomy_obj = get_taxonomy($gm_product_taxonomy);

						echo '<!-- Product ' . $gm_product_taxonomy_obj->label . ' -->';
						echo '<div class="product-gm-meta"><div class="product-meta-label"><span class="product-' . $gm_product_taxonomy . '">' . $gm_product_taxonomy_obj->label . ':</div><div class="product-meta-value"><span class="gm-product-value">';

						$number_of_gm_product_terms = count($gm_product_term_list);
						$gm_product_terms_counter = 1;
						foreach ($gm_product_term_list as $gm_product_term) {
							echo '<a href="' . esc_url(get_term_link($gm_product_term->slug, $gm_product_taxonomy)) . '">' . $gm_product_term->name . '</a>';
							if($gm_product_terms_counter < $number_of_gm_product_terms) {
								echo ', ';
							}
							$gm_product_terms_counter++;
						}
						echo '</span></span></div></div>';
					} else if($gm_product_taxonomy == 'gm_icons') {
						foreach ($gm_product_term_list as $gm_product_term) {

							// get the term thumbnail if it exists 
							if(function_exists('get_field')) { 
								$gm_product_icons[] = array(
									'term' => $gm_product_term,
									'thumbnail' => get_field('thumbnail', $gm_product_term),
								);
							}
						}
					}
				} // end if
			} // end foreach

			if(function_exists('get_field')) {
				echo '<!-- Product Attached PDF Files -->';
				$product_details = get_field('product_details', $product->get_id());
				$installation_instructions = get_field('installation_instructions', $product->get_id());
				$photometry = get_field('photometry', $product->get_id());
				$dwg_file   = get_field('dwg_file', $product->get_id());
				$png_file   = get_field('png_file', $product->get_id());
				$dxf_file   = get_field('dxf_file', $product->get_id());
				if(!empty($product_details) or !empty($installation_instructions) or !empty($photometry) or !empty($dwg_file) or !empty($png_file) or !empty($dxf_file)) {
					// prepare product details link
					if(!empty($product_details)) {
						$product_details_alt       = $product_details['alt'];
						$product_details_url       = $product_details['url'];
						$product_details_link_text = get_field('product_details_link_text', $product->get_id());
						$product_details_link_obj  = get_field_object('product_details_link_text', $product->get_id());
						$product_details_title     = $product_details_link_obj['default_value'];
						if(!empty($product_details_link_text)) {
							$product_details_title = $product_details_link_text;
						}
					}
					// prepare installation instructions link
					if(!empty($installation_instructions)) {
						$installation_instructions_alt       = $installation_instructions['alt'];
						$installation_instructions_url       = $installation_instructions['url'];
						$installation_instructions_link_text = get_field('installation_instructions_link_text', $product->get_id());
						$installation_instructions_link_obj  = get_field_object('installation_instructions_link_text', $product->get_id());
						$installation_instructions_title     = $installation_instructions_link_obj['default_value'];
						if(!empty($installation_instructions_link_text)) {
							$installation_instructions_title = $installation_instructions_link_text;
						}
					}
					// prepare photometry link
					if(!empty($photometry)) {
						$photometry_alt       = $photometry['alt'];
						$photometry_url       = $photometry['url'];
						$photometry_link_text = get_field('photometry_link_text', $product->get_id());
						$photometry_link_obj  = get_field_object('photometry_link_text', $product->get_id());
						$photometry_title     = $photometry_link_obj['default_value'];
						if(!empty($photometry_link_text)) {
							$photometry_title = $photometry_link_text;
						}
					}
					// prepare dwg link
					if(!empty($dwg_file)) {
						$dwg_file_alt       = $dwg_file['alt'];
						$dwg_file_url       = $dwg_file['url'];
						$dwg_file_link_text = get_field('dwg_file_link_text', $product->get_id());
						$dwg_file_link_obj  = get_field_object('dwg_file_link_text', $product->get_id());
						$dwg_file_title     = $dwg_file_link_obj['default_value'];
						if(!empty($dwg_file_link_text)) {
							$dwg_file_title = $dwg_file_link_text;
						}
					}
					// prepare png link
					if(!empty($png_file)) {
						$png_file_alt       = $png_file['alt'];
						$png_file_url       = $png_file['url'];
						$png_file_link_text = get_field('png_file_link_text', $product->get_id());
						$png_file_link_obj  = get_field_object('png_file_link_text', $product->get_id());
						$png_file_title     = $png_file_link_obj['default_value'];
						if(!empty($png_file_link_text)) {
							$png_file_title = $png_file_link_text;
						}
					}
					// prepare dxf link
					if(!empty($dxf_file)) {
						$dxf_file_alt       = $dxf_file['alt'];
						$dxf_file_url       = $dxf_file['url'];
						$dxf_file_link_text = get_field('dxf_file_link_text', $product->get_id());
						$dxf_file_link_obj  = get_field_object('dxf_file_link_text', $product->get_id());
						$dxf_file_title     = $dxf_file_link_obj['default_value'];
						if(!empty($dxf_file_link_text)) {
							$dxf_file_title = $dxf_file_link_text;
						}
					}
					echo '<div class="product-attached-pdf">';
					echo '<div class="product-attached-pdf-label">Downloads: </div>';
					echo '<div class="product-attached-pdf-files"><span>';
					
					$gm_product_downloads_counter = 0;
					if(!empty($product_details)) {
						echo '<a alt="' . $product_details_alt . '" href="' . $product_details_url . '" target="_blank">' . $product_details_title . '</a>';
						$gm_product_downloads_counter++;
					}
					if(!empty($installation_instructions)) {
						if($gm_product_downloads_counter > 0) echo ', ';
						echo '<a alt="' . $installation_instructions_alt . '" href="' . $installation_instructions_url . '" target="_blank">' . $installation_instructions_title . '</a>';
						$gm_product_downloads_counter++;
					}
					if(!empty($photometry)) {
						if($gm_product_downloads_counter > 0) echo ', ';
						echo '<a alt="' . $photometry_alt . '" href="' . $photometry_url . '" target="_blank">' . $photometry_title . '</a>';
						$gm_product_downloads_counter++;
					}
					if(!empty($dwg_file)) {
						if($gm_product_downloads_counter > 0) echo ', ';
						echo '<a alt="' . $dwg_file_alt . '" href="' . $dwg_file_url . '" target="_blank">' . $dwg_file_title . '</a>';
						$gm_product_downloads_counter++;
					}
					if(!empty($png_file)) {
						if($gm_product_downloads_counter > 0) echo ', ';
						echo '<a alt="' . $png_file_alt . '" href="' . $png_file_url . '" target="_blank">' . $png_file_title . '</a>';
						$gm_product_downloads_counter++;
					}
					if(!empty($dxf_file)) {
						if($gm_product_downloads_counter > 0) echo ', ';
						echo '<a alt="' . $dxf_file_alt . '" href="' . $dxf_file_url . '" target="_blank">' . $dxf_file_title . '</a>';
					}
					echo '</span></div>';
					echo '</div>';
				}
			}
		?>
		<?php do_action( 'woocommerce_product_meta_end' ); ?>
	</div>
</div>
<div class="product-icons">
	<?php
	if(!empty($gm_product_icons)) {
		foreach($gm_product_icons as $gm_product_icon) {
			if(!empty($gm_product_icon['thumbnail']) && $gm_product_icon['thumbnail'] != null && $gm_product_icon['thumbnail'] != '') {

				$image = $gm_product_icon['thumbnail'];
				$url = $image['url'];
				$title = $image['title'];
				$alt = $image['alt'];
				$caption = $image['caption'];
				$size = 'thumbnail';
				$thumb = $image['sizes'][ $size ];
				$width = $image['sizes'][ $size . '-width' ];
				$height = $image['sizes'][ $size . '-height' ];
				echo '<div class="product-icon">';
				echo '<div class="product-icon-details">';
				echo '<div class="product-icon-title"><strong>' . $title . '</strong></div>';
				echo '<div class="product-icon-alt">' . $alt . '</div>';
				echo '</div>';
				echo '<img src="' . esc_url($thumb) . '" alt="' . esc_attr($alt) . '" />';
				echo '</div>';
			} // end if
		} // end foreach
	} // end if
	?>
</div>
<?php
if(function_exists('magictoolbox_WooCommerce_MagicZoom_init')) {
	wc_get_template_part('single-product/product-images-lightbox-links');
}
?>