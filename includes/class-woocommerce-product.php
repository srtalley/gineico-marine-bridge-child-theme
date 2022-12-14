<?php 
/**
 * v2.4.9
 */

namespace GineicoMarine\Theme;

class GM_WooCommerceProduct {

  
    public function __construct() {
        // Add and save Gineico Product ID field for simple products
        add_action( 'woocommerce_product_options_advanced', array($this, 'gc_add_gineico_product_id_to_advanced_tab'), 10, 1 ); 
        // add_action( 'woocommerce_process_product_meta', array($this, 'gc_save_gineico_product_id_main_product') );

        // Add and save Quote Description field for variable products
        add_action( 'woocommerce_product_after_variable_attributes', array($this, 'gc_add_gineico_product_id_to_variations'), 20, 3 );
        // add_action( 'woocommerce_save_product_variation', array($this, 'gc_save_gineico_product_id_variations'), 10, 2 );
        
        // Filter the get_post_meta call for the product ID
        add_filter( 'get_post_metadata', array($this, 'gc_add_product_id_post_meta'), 10, 4 );
        
        // Filter for Zoho to create a product id
        add_filter( 'get_zoho_product_id', array($this, 'get_zoho_product_id'), 10, 1 );
    } // end function construct

    /**
     * Add the Gineico Product ID field for simple or parent products under the general tab
     */
    public function gc_add_gineico_product_id_to_advanced_tab($product) {
        
        // $product = wc_get_product(get_the_ID());
        $site_abbreviation = get_gineico_site_abbreviation();
        // $gineico_product_id =  $site_abbreviation . '-' . $product->get_id();
        $gineico_product_id = get_post_meta( get_the_ID(), 'gineico_product_id', true );
        // echo '<p class="form-field gineico_product_id_field form-row form-row-full">';
		// echo '<label for="gineico_product_id" style="vertical-align:baseline; padding-right: 10px;">' . $site_abbreviation . ' Product ID</label>';
        // echo '<strong style="font-size: 16px;">' . $gineico_product_id . '</strong></p>';

        woocommerce_wp_text_input(
            array(
                'id'            => "gineico_product_id",
                'name'          => "gineico_product_id",
                'placeholder'   => $gineico_product_id,
                'value'         => $gineico_product_id,
                'label'         => __( $site_abbreviation . ' Product ID', 'woocommerce' ),
                'wrapper_class' => 'form-row form-row-full',
                'class'         => 'long gineico-product-id',
                'custom_attributes' => array('readonly' => 'readonly'),

            )
        );
    }

    /**
     * Save the Gineico Product ID field for simple products
     */
    public function gc_save_gineico_product_id_main_product($post_id) {
        $gineico_product_id = $_POST['gineico_product_id_adv'];
        if ( isset( $gineico_product_id ) ) update_post_meta( $post_id, 'gineico_product_id', sanitize_textarea_field( $gineico_product_id ) );       
    }
    /**
     * Add the Gineico Product ID field for variations under Product Data
     */
    public function gc_add_gineico_product_id_to_variations( $loop, $variation_data, $variation ) {

        $site_abbreviation = get_gineico_site_abbreviation();
        // $product_variation = wc_get_product($variation->ID);
        // $parent_id = $product_variation->get_parent_id();
        // $gineico_product_id =  $site_abbreviation . '-' . $parent_id . '-' . $variation->ID;

        // echo '<p class="form-field gineico_product_id_field form-row form-row-full">';
		// echo '<label for="gineico_product_id" style="vertical-align:baseline; padding-right: 10px;">' . $site_abbreviation . ' Product ID</label>';
        // echo '<strong style="font-size: 16px;">' . $gineico_product_id . '</strong></p>';
        $gineico_product_id = get_post_meta( $variation->ID, 'gineico_product_id', true );

        woocommerce_wp_text_input(
            array(
                'id'            => "gineico_product_id{$loop}",
                'name'          => "gineico_product_id[{$loop}]",
                'placeholder'   => $gineico_product_id,
                'value'         => $gineico_product_id,
                'label'         => __( $site_abbreviation . ' Product ID', 'woocommerce' ),
                'desc_tip'      => true,
                'wrapper_class' => 'form-row form-row-full',
                'class'         => 'long gineico-product-id',
                'custom_attributes' => array('readonly' => 'readonly'),

            )
        );
    }
    
    /** 
     * Save the variation Gineico Product ID field
     */   
    public function gc_save_gineico_product_id_variations( $variation_id, $i ) {
        $gineico_product_id = $_POST['gineico_product_id'][$i];
        if ( isset( $gineico_product_id ) ) update_post_meta( $variation_id, 'gineico_product_id', sanitize_textarea_field( $gineico_product_id ) );
    }
 
    /**
     * Add dynamically-generated "post meta" to `\WP_Post` objects
     *
     * This makes it possible to access dynamic data related to a post object by simply referencing `$post->foo`.
     * That keeps the calling code much cleaner than if it were to have to do something like
     * `$foo = some_custom_logic( get_post_meta( $post->ID, 'bar', true ) ); echo esc_html( $foo )`.
     *
     * @param mixed  $value
     * @param int    $post_id
     * @param string $meta_key
     * @param int    $single   @todo handle the case where this is false
     *
     * @return mixed
     *      `null` to instruct `get_metadata()` to pull the value from the database
     *      Any non-null value will be returned as if it were pulled from the database
     */
    public function gc_add_product_id_post_meta( $value, $post_id, $meta_key, $single ) {
        $post = get_post( $post_id );
        if ( 'product' != $post->post_type && 'product_variation' != $post->post_type ) {
            return $value;
        }
        switch ( $meta_key ) {
            case 'gineico_product_id':
                $product = wc_get_product($post_id);

                // detect if product is variation
                if($product->is_type('variation')) {
                    $parent_id = $product->get_parent_id();
                    $id =  $parent_id . '-' . $product->get_id();
                } else {
                    $id = $product->get_id();
                }
        
                $site_abbreviation = get_gineico_site_abbreviation() . '-';
                $value = $site_abbreviation . $id;
                break;
        }
    
        return $value;
    }
    /**
     * Filter to return a custom product ID for Zoho
     */
    public function get_zoho_product_id($product_id) {

        $product = wc_get_product($product_id);

        // detect if product is variation
        if($product->is_type('variation')) {
            $parent_id = $product->get_parent_id();
            $id =  $parent_id . '-' . $product->get_id();
        } else {
            $id = $product->get_id();
        }
        return 'GM-' . $id;
    }
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
} // end class

$gm_woocommerce_product = new GM_WooCommerceProduct();