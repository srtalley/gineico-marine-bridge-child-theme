<?php
define( 'THEME_FUNCTIONS__FILE__', __FILE__ );

/**
* Enqueue the theme scripts for Gineico Marine
*/
if(!function_exists('bridge_qode_child_theme_enqueue_scripts')) {

	Function bridge_qode_child_theme_enqueue_scripts() {
		// wp_register_style('bridge-childstyle', get_stylesheet_directory_uri() . '/style.css');
		// wp_enqueue_style('bridge-childstyle');
		wp_enqueue_style( 'bridge-childstyle', get_stylesheet_directory_uri() . '/style.css', '', wp_get_theme()->get('Version'), 'all' );

		wp_enqueue_script( 'gm-main', get_stylesheet_directory_uri() . '/main.js', '', '2.5.4', true );
		wp_localize_script( 'gm-main', 'params', array(
			'ajaxurl'   => admin_url( 'admin-ajax.php' ),
			'ajaxnonce' => wp_create_nonce( 'gm_params_nonce' )
		  ) );
	}

	add_action('wp_enqueue_scripts', 'bridge_qode_child_theme_enqueue_scripts', 11);
}

// require_once( dirname( __FILE__ ) . '/includes/class-advanced-custom-fields.php');
require_once( dirname( __FILE__ ) . '/includes/class-qode-breadcrumbs.php');
require_once( dirname( __FILE__ ) . '/includes/class-woocommerce.php');
require_once( dirname( __FILE__ ) . '/includes/class-trade_customer.php');
require_once( dirname( __FILE__ ) . '/includes/class-woocommerce-account.php');
require_once( dirname( __FILE__ ) . '/includes/class-woocommerce-shipping.php');

// wl(pw_new_user_approve)


/**
* Change the Ninja Form PDF Title 
*/
function custom_pdf_name( $name, $sub_id ) {
    $sub = Ninja_Forms()->form()->get_sub( $sub_id );
     $name = 'MC2X Sizing Form - ' . $sub->get_field_value('name') . ' - ' . $sub_id;
     return $name;
  }
add_filter( 'ninja_forms_submission_pdf_name', 'custom_pdf_name', 20, 2 );

/**
* Logging function to debug.log
*/
function wl ( $log )  {
    if ( is_array( $log ) || is_object( $log ) ) {
        error_log( print_r( $log, true ) );
    } else {
        error_log( $log );
    }
}

/**
* Logging function to a file path specified
*/
function wf( $contents, $filename = '' ) {

	if($filename == '') {
		$filename = 'myfile_'.date('m-d-Y_hia');
	}
	$uploads = wp_upload_dir();
	$upload_path = $uploads['path'];
	$file = $upload_path . '/' . $filename;
	// Open the file to get existing content
	$current = file_get_contents($file);
	// Append a new person to the file
	$current .= $contents;
	// Write the contents back to the file
	file_put_contents($file, $current);
}


/**
* Retrieve a listing of custom taxonomies that have been added to products.
* The taxonomies must be prefixed with 'gm_'
* This is used in various template files so it must exist here.
*/
if(!function_exists('gm_get_gm_product_taxonomies')) {

	function gm_get_gm_product_taxonomies() {
		$gm_search_string = 'gm_';
		$taxonomies = get_object_taxonomies('product');
		$gm_taxonomies = array();
		foreach ($taxonomies as $taxonomy) {
			if(substr($taxonomy, 0, strlen($gm_search_string)) === $gm_search_string) {
				$gm_taxonomies[] = $taxonomy;
			}
		}
		sort($gm_taxonomies);
		return $gm_taxonomies;
	}
}


/* Add the Brands page listing */
if ( ! function_exists( 'bridge_child_product_custom_taxonomies' ) ) {
	function bridge_child_product_custom_taxonomies( $atts ) {
		$product_custom_taxonomies_array = array(
			'gm_brands',
		);

		if ( isset( $atts['number'] ) ) {
			$atts['limit'] = $atts['number'];
		}

		$atts = shortcode_atts( array(
			'taxonomy'   => '',
			'limit'      => '-1',
			'orderby'    => 'name',
			'order'      => 'ASC',
			'columns'    => '5',
			'hide_empty' => 1,
			'parent'     => '',
			'ids'        => '',
		), $atts, 'product_custom_taxonomies' );

		if(empty($atts['taxonomy']) or !in_array($atts['taxonomy'], $product_custom_taxonomies_array)) {
			return '';
		}

		$ids        = array_filter( array_map( 'trim', explode( ',', $atts['ids'] ) ) );
		$hide_empty = ( true === $atts['hide_empty'] || 'true' === $atts['hide_empty'] || 1 === $atts['hide_empty'] || '1' === $atts['hide_empty'] ) ? 1 : 0;

		// Get terms and workaround WP bug with parents/pad counts.
		$args = array(
			'orderby'    => $atts['orderby'],
			'order'      => $atts['order'],
			'hide_empty' => $hide_empty,
			'include'    => $ids,
			'pad_counts' => true,
			'child_of'   => $atts['parent'],
		);

		$product_taxonomies = get_terms( $atts['taxonomy'], $args );

		if ( '' !== $atts['parent'] ) {
			$product_taxonomies = wp_list_filter( $product_taxonomies, array(
				'parent' => $atts['parent'],
			) );
		}

		if ( $hide_empty ) {
			foreach ( $product_taxonomies as $key => $taxonomy ) {
				if ( 0 === $taxonomy->count ) {
					unset( $product_taxonomies[ $key ] );
				}
			}
		}

		$atts['limit'] = '-1' === $atts['limit'] ? null : intval( $atts['limit'] );
		if ( $atts['limit'] ) {
			$product_taxonomies = array_slice( $product_taxonomies, 0, $atts['limit'] );
		}

		$columns = absint( $atts['columns'] );

		wc_set_loop_prop( 'columns', $columns );
		wc_set_loop_prop( 'is_shortcode', true );

		ob_start();

		if ( $product_taxonomies ) {
			woocommerce_product_loop_start();

			foreach ( $product_taxonomies as $taxonomy ) {
				wc_get_template( 'content-product_custom_tax.php', array(
					'taxonomy' => $taxonomy,
				) );
			}

			woocommerce_product_loop_end();
		}

		woocommerce_reset_loop();

		return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
	}
	add_shortcode('product_custom_taxonomies', 'bridge_child_product_custom_taxonomies');
}

/* Add the brands page subcategory thumb */

if ( ! function_exists( 'bridge_child_woocommerce_subcategory_thumbnail' ) ) {
	function bridge_child_woocommerce_subcategory_thumbnail( $category ) {
		$small_thumbnail_size = apply_filters( 'subcategory_archive_thumbnail_size', 'woocommerce_thumbnail' );
		$dimensions           = wc_get_image_size( $small_thumbnail_size );
		if(function_exists('get_field')) {
			$image = get_field('thumbnail', $category);
			$thumbnail_id = $image['id'];
		} else {
			$thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );
		}

		if ( $thumbnail_id ) {
			$image        = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size );
			$image        = $image[0];
			$image_srcset = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $thumbnail_id, $small_thumbnail_size ) : false;
			$image_sizes  = function_exists( 'wp_get_attachment_image_sizes' ) ? wp_get_attachment_image_sizes( $thumbnail_id, $small_thumbnail_size ) : false;
		} else {
			$image        = wc_placeholder_img_src();
			$image_srcset = false;
			$image_sizes  = false;
		}

		if ( $image ) {
			// Prevent esc_url from breaking spaces in urls for image embeds.
			// Ref: https://core.trac.wordpress.org/ticket/23605.
			$image = str_replace( ' ', '%20', $image );

			// Add responsive image markup if available.
			if ( $image_srcset && $image_sizes ) {
				echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" srcset="' . esc_attr( $image_srcset ) . '" sizes="' . esc_attr( $image_sizes ) . '" />';
			} else {
				echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" />';
			}
		}
	}
}


add_filter( 'woocommerce_ajax_variation_threshold', 'gm_ajax_variation_threshold', 10, 2 );

function gm_ajax_variation_threshold( $default, $product ) {
	return 150;
}

/** 
 * Show the thumbnail always on quotes
 */
add_filter('ywraq_item_thumbnail', '__return_true', 100);
