<?php 

namespace GineicoMarine\Theme;

class GM_WooCommerce {

  
    public function __construct() {
        add_filter('loop_shop_per_page', array($this, 'gm_show_all_products_in_shop'), 100);

        add_action( 'woocommerce_before_add_to_cart_form', array($this, 'gm_show_product_catalogue'), 20 );

        add_action( 'woocommerce_single_product_summary', array($this,'gm_after_add_to_cart_download_pdf'),39 );

        add_filter( 'gettext', array($this,'gm_change_wc_text_strings'), 20, 3 );

        add_action( 'current_screen', array($this,'gm_woocommerce_product_admin'), 10, 1 );

        // remove price from shop pages 
        add_action( 'woocommerce_init', array($this, 'gm_remove_shop_price') );

        // add_action('woocommerce_price_format', array($this,'gm_add_currency_suffix'), 1, 2);
        
        add_action( 'woocommerce_before_single_product', array($this, 'gm_add_currency_suffix_action') );
        // add_action( 'woocommerce_before_cart', array($this, 'gm_add_currency_suffix_action') );
        add_action( 'woocommerce_cart_totals_before_order_total', array($this, 'gm_add_currency_suffix_for_total_action') );        
        add_action( 'woocommerce_review_order_before_order_total', array($this, 'gm_add_currency_suffix_for_total_action') );

        add_filter( 'woocommerce_cart_item_subtotal', array($this, 'gm_subtotal_suffix') );
        // add ex. GST to the subtotal in the cart
        add_filter( 'woocommerce_cart_subtotal', array($this, 'gm_subtotal_suffix'));

        // change the tax label in the cart/checkout
        add_filter( 'woocommerce_countries_tax_or_vat', array($this,  'gm_change_email_tax_label') );


        add_action('wp_head', array($this,'gm_customize_product_archive_header'), 10);

        add_action('woocommerce_init', array($this,'gm_change_category_title_tag'), 10);

        add_action( 'pre_get_posts', array($this, 'gm_remove_products_from_shop_page') );

        // add_filter( 'woocommerce_product_stock_status_options', array($this, 'gm_woocommerce_product_stock_status_options') );

        // Change the backorder text in the admin area
        add_filter ('woocommerce_admin_stock_html', array($this, 'gm_woocommerce_admin_stock_html'), 10, 2 );

        // Change backorder text
        add_filter('woocommerce_get_availability_text', array($this, 'gm_change_available_on_backorder_text'), 10, 2);

        // Add wrappers to shift the position of buttons
        add_action('woocommerce_before_add_to_cart_quantity', array($this, 'gm_woocommerce_before_add_to_cart_quantity'), 1);
        add_action('woocommerce_after_add_to_cart_quantity', array($this, 'gm_woocommerce_after_add_to_cart_quantity'), 1);
        add_action('woocommerce_after_add_to_cart_button', array($this, 'gm_woocommerce_after_add_to_cart_button'), 1);
              
        // Allow hiding the add to cart button
        add_action('woocommerce_before_add_to_cart_form', array($this,'gm_hide_add_to_cart_button'), 100);

        // Change the add to cart button text 
        add_filter( 'woocommerce_product_single_add_to_cart_text', array( $this, 'gm_woocommerce_product_single_add_to_cart_text') ); 

        // Hide Add to Cart in the Shop or Change the Shop Button
        add_filter('woocommerce_loop_add_to_cart_link', array($this, 'gm_hide_add_to_cart_button_in_shop'), 2, 10);

        // Always show price when selecting variation
        add_filter( 'woocommerce_show_variation_price', '__return_true' );

        // If the price is zero, do not display that
        add_action('woocommerce_before_single_product_summary', array($this, 'gm_filter_zero_dollar_prices'));

        // Make all items purchaseable even with an empty price (used to make 
        // the quantity buttons show up for quotes)
        add_filter('woocommerce_is_purchasable', '__return_TRUE'); 

        // Force an empty price to return zero as a price
        add_filter( 'woocommerce_product_get_price', array($this, 'gm_filter_woocommerce_empty_price'), 10, 2 );
        add_filter( 'woocommerce_product_variation_get_price', array($this, 'gm_filter_woocommerce_empty_price'), 10, 2 );
        // add_filter( 'woocommerce_product_get_regular_price', array($this, 'gm_filter_woocommerce_empty_price'), 10, 2 );
        // add_filter( 'woocommerce_product_get_sale_price', array($this, 'gm_filter_woocommerce_empty_price'), 10, 2 );

        // Allow hiding the price if the box is checked or the item is backordered
        add_filter( 'woocommerce_get_price_html', array($this, 'gm_hide_price'), 10, 2 );
        // add_filter( 'woocommerce_variation_price_html', array($this, 'gm_hide_price'), 10, 2 );
        // add_filter( 'woocommerce_variation_sale_price_html', array($this, 'gm_hide_price'), 10, 2 );

        // Force the quantity buttons to always show
        add_filter( 'woocommerce_quantity_input_args', array($this, 'gm_force_quantity_buttons_to_show'), 20, 2 );        

        add_filter( 'wc_add_to_cart_message_html', array($this, 'gm_add_continue_shopping_button'), 20 );
 
        // Remove the coupon forms while leaving them enabled for YITH Request a Quote
        add_filter( 'woocommerce_cart_contents', array($this, 'gm_remove_coupon_forms'), 20 );
        add_action('woocommerce_init', array($this,'gm_remove_checkout_coupon_forms'), 10);

        // Move the proceed to checkout button to the bottom
        add_action( 'woocommerce_after_cart_totals', array($this, 'gm_move_cart_proceed_to_checkout_button'), 11);

        // Change how the Buy Now Stripe button appears
        if(class_exists('WC_Stripe_Payment_Request')) {
            remove_action( 'woocommerce_after_add_to_cart_quantity', array( \WC_Stripe_Payment_Request::instance(), 'display_payment_request_button_html' ), 1 );
            remove_action( 'woocommerce_after_add_to_cart_quantity', array( \WC_Stripe_Payment_Request::instance(), 'display_payment_request_button_separator_html' ), 2 );
    
            add_action( 'woocommerce_after_add_to_cart_quantity', array( \WC_Stripe_Payment_Request::instance(), 'display_payment_request_button_html' ), 2 );
            add_action( 'woocommerce_after_add_to_cart_quantity', array( \WC_Stripe_Payment_Request::instance(), 'display_payment_request_button_separator_html' ), 3 );
        }

        // Add a diagonal banner for in stock items
        add_action('woocommerce_before_shop_loop_item_title', array($this, 'gm_add_product_thumb_banner'), 5);
        
        // Set the default country at checkout
        add_filter( 'default_checkout_billing_country', array($this, 'gm_change_default_checkout_country') );


        // PDF file name
        add_filter( 'ywraq_pdf_file_name', array($this, 'gm_ywraq_pdf_file_name'), 10, 2 );
        
        // PDF paper orientation
        add_filter('ywraq_change_paper_orientation' , array($this, 'gm_ywraq_change_paper_orientation'));

        // Set an auto generated quote back to the "New" status
        // add_action( 'ywraq_after_create_order', array( $this, 'gm_reset_auto_generated_quote_order_status' ), 20, 2 );

        // Add the terms at the bottom of the PDF quote
        add_action( 'yith_ywraq_quote_template_after_content', array($this, 'gm_quote_terms'));

        // Check for YITH emails and add the terms to the bottom
        add_action ( 'woocommerce_email_footer', array($this, 'gm_woocommerce_email_footer'), 10, 1);

        // Change the hide quote button text in the admin area
        // add_filter( 'gettext', array($this,'gm_yith_change_text'), 20, 3 );
        /**
         * Add a "Continue Shopping" button after adding to quote list
         */
        // add_action( 'woocommerce_before_single_product', array($this, 'gm_add_quote_continue_shopping_button_setup') );

        add_filter( 'add_to_cart_redirect', array($this, 'misha_skip_cart_redirect_checkout') );
        add_action('template_redirect', array($this,'wholesale_product_page_redirect'));

    } // end function construct
 
    function misha_skip_cart_redirect_checkout( $url ) {
        wl('my url is ' . $url); 
        return $url;
        // return wc_get_checkout_url();
    }
    public function wholesale_product_page_redirect(){
        // wl($_SERVER);
        wl($_POST);
        if (class_exists('WooCommerce')){
            if(is_product() && !current_user_can('administratdor')){
//                 global $product;
//                 wl($product);
wl($_SERVER);
                wl('referrrerrrre: ' . $_SERVER['HTTP_REFERRER']);
//    wl('?add-to-cart=' . $product->get_id());

if(substr($_SERVER['HTTP_REFERRER'], 0, strlen('?add-to-cart')) === '?add-to-cart') {
    wl('heeeee');

} else {
    wl('llllll');
}
                if(isset($_SERVER['HTTP_REFERRER']) && substr($_SERVER['HTTP_REFERRER'], 0, strlen('?add-to-cart')) === '?add-to-cart') {
                    
                    // if(isset($_SERVER['HTTP_REFERRER']) && $_SERVER['HTTP_REFERRER'] === '?add-to-cart=' . $product->get_id()) {

                    wl('matched this parrrrt');
                    $product_term_ids = wc_get_product_term_ids($post->ID, 'product_cat');
                    // Wholesale Items
                    $wholesale_category_id = '93d8';
                    if ( in_array( $wholesale_category_id, $product_term_ids ) ) {
                        $query_access = isset($_GET['access']) ? $_GET['access'] : '';
                        if($query_access != 'wholesaler') {
                            wp_redirect(home_url('/shop/'));
                            exit();
    
                        }
                    }

                }
                
            }
        } 
        return;
    } 
    /**
     * Remove the price from shop pages
     */
    public function gm_remove_shop_price() {
        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
    }

    /**
     * Make the shop category pages show all items
     */

    public function gm_show_all_products_in_shop($cols) {
        $cols = -1;
        return $cols;
    }

    /**
    * Add the download catalogue links
    */
    
    public function gm_show_product_catalogue(){
        global $product;
        $gm_product_term_list = wp_get_post_terms($product->get_id(), 'gm_catalogue');
        if(!empty($gm_product_term_list) && $gm_product_term_list != null && $gm_product_term_list != '') {

            foreach ($gm_product_term_list as $gm_product_term) {

                if(function_exists('get_field')) { 
                    $catalogue_link_type = get_field('catalogue_link_type', $gm_product_term);
                    if($catalogue_link_type == '' || $catalogue_link_type == 'PDF') {
                        $current_catalogue = get_field('catalogue_file', $gm_product_term);

                        if(!empty($current_catalogue) && $current_catalogue != '') {
                            
                            $current_catalogue_alt       = $current_catalogue['alt'];
                            $current_catalogue_url       = $current_catalogue['url'];
                            $current_catalogue_link_text = get_field('catalogue_link_text', $gm_product_term);

                            // get the default value if one was not defined
                            $current_catalogue_link_obj  = get_field_object('catalogue_link_text', $gm_product_term);
                            $current_catalogue_title     = $current_catalogue_link_obj['default_value'];
    
                            if(!empty($current_catalogue_link_text)) {
                                $current_catalogue_title = $current_catalogue_link_text;
                            }
                            
                            echo '<div class="product-catalogue-link">';
                            echo '<a alt="' . $current_catalogue_alt . '" href="' . $current_catalogue_url . '" target="_blank">' . $current_catalogue_title . '</a>';
                            echo '</div>';
                        }
                    } else if($catalogue_link_type == 'URL') {
                        $current_url = get_field('catalogue_url', $gm_product_term);
                        $current_catalogue_link_text = get_field('catalogue_link_text', $gm_product_term);

                        // get the default value if one was not defined
                        $current_catalogue_link_obj  = get_field_object('catalogue_link_text', $gm_product_term);
                        $current_catalogue_title     = $current_catalogue_link_obj['default_value'];
                        if(!empty($current_catalogue_link_text)) {
                            $current_catalogue_title = $current_catalogue_link_text;
                        }
                        echo '<div class="product-catalogue-link">';
                        echo '<a href="' . $current_url . '">' . $current_catalogue_title . '</a>';
                        echo '</div>';

                    }


                }

            }
        }
    } // end function gm_show_product_catalogue

    /**
    * Add Download PDF button to single product pages
    */    
    public function gm_after_add_to_cart_download_pdf(){

        global $product;

        if(function_exists('get_field')) {
            echo '<!-- Product Attached PDF Files -->';
            $product_details = get_field('product_details', $product->get_id());
            $installation_instructions = get_field('installation_instructions', $product->get_id());
            $photometry = get_field('photometry', $product->get_id());
            $dwg_file   = get_field('dwg_file', $product->get_id());
            if(!empty($product_details) or !empty($installation_instructions) or !empty($photometry) or !empty($dwg_file)) {
                // prepare product details link
                $product_details_alt       = $product_details['alt'];
                $product_details_url       = $product_details['url'];
                $product_details_link_text = get_field('product_details_link_text', $product->get_id());
                $product_details_link_obj  = get_field_object('product_details_link_text', $product->get_id());
                $product_details_title     = $product_details_link_obj['default_value'];
                if(!empty($product_details_link_text)) {
                    $product_details_title = $product_details_link_text;
                }
                echo '<div class="product-attached-pdf-buttons" style="margin: 0 0 20px;">';

                if(!empty($product_details)) {
                    echo '<p><a class="button" alt="' . $product_details_alt . '" href="' . $product_details_url . '" target="_blank">Download: ' . $product_details_title . '</a></p>';
                }
                echo '</div>';
            }
        }
    } // end function gm_after_add_to_cart_download_pdf


    /**
    * Change WooCommerce Single Product Page Strings
    *
    * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/gettext
    */
    function gm_change_wc_text_strings( $translated_text, $text, $domain ) {

        if($domain == 'woocommerce') {
            switch ( $translated_text ) {

                // Switching these headings but they need to be slightly different
                // or it enters a loop where it keeps trying to replace the other
                // one over and over.
                case 'You may also like&hellip;':
                    $translated_text = __( 'Related Products', 'woocommerce' );
                    break;
                case 'Related products':
                    $translated_text = __( 'You may also like&hellip;&nbsp;', 'woocommerce' );
                    break;
                case 'In stock':
                    $translated_text = __( 'LEAD TIME: In Stock', 'woocommerce');
                    break;
                case 'Clear':
                    $translated_text = __( 'Clear Selection', 'woocommerce');
                    break;
                case 'Coupon(s):':
                    $translated_text = __( 'Discount:', 'woocommerce');
            }
        } 
        if($domain == 'bridge') {
            switch ( $translated_text ) {

                case 'Calculate shipping':
                    $translated_text = __( 'Add your details to calculate your shipping', 'bridge');
                    break;
            }
        } 
        


        return $translated_text;
    } // end function gm_change_wc_text_strings

    /*
    * Move the product metaboxes to the left in the admin area.
    * 
    */
    public function gm_woocommerce_product_admin($current_screen) {
        if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

            // if($current_screen->id == 'edit-product') {
            //     add_action('admin_head', array($this, 'gm_woocomerce_edit_product_admin_area_changes'));
            // }
            if($current_screen->id == 'product') {
                add_action('admin_head', array($this, 'gm_woocomerce_product_admin_area_changes'));

                // add the one for YITH 
                add_action('admin_head', array($this, 'gm_yith_admin_css'));
            }
        } // end if 
    } // end function gm_woocommerce_product_admin

    /**
     * Adds CSS to show the product icons when editing the product
     */
    public function gm_woocomerce_product_admin_area_changes() {
        $gm_product_taxonomies = gm_get_gm_product_taxonomies();
        $gm_product_icons = array();

        foreach($gm_product_taxonomies as $gm_product_taxonomy) {
            remove_meta_box( $gm_product_taxonomy . 'div', 'product', 'normal');
            $gm_product_taxonomy_obj = get_taxonomy($gm_product_taxonomy);
            add_meta_box( $gm_product_taxonomy . 'div', $gm_product_taxonomy_obj->label, 'post_categories_meta_box', 'product', 'normal', 'default', array( 'taxonomy' => $gm_product_taxonomy ));
            if($gm_product_taxonomy == 'gm_icons') {
                $gm_product_term_list = get_terms($gm_product_taxonomy);
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
            if(!empty($gm_product_icons)) {
                echo '<style type="text/css">';
                echo '#gm_iconschecklist > li {position: relative; height: 40px;padding-top: 5px;} #gm_iconschecklist > li .selectit:before{ content: ""; position: absolute; width: 35px; height: 35px; background-repeat:no-repeat; background-position:center; background-size: cover; top: 0; margin-left: 24px; } #gm_iconschecklist > li .selectit input[type="checkbox"] { margin-right:44px;}';

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
                        echo '#gm_icons-' . $gm_product_icon['term']->term_id . ' .selectit:before {background-image:url(' . esc_url($thumb) . ');}';
                    } // end if
                } // end foreach
                echo '</style>';
            } // end if
        }
        echo '<style type="text/css">#acf-group_5bbe75339e188 .inside.acf-fields {column-count: 2; column-width: 380px; position: relative; display: block; } #acf-group_5bbe75339e188 .acf-field { position: relative; display: block; -webkit-column-break-inside: avoid; break-inside: avoid;page-break-inside: avoid;}</style>';

    } // end function gm_woocomerce_product_admin_area_changes

    
    /**
     * Add the currency after the price
     */
    public function gm_add_currency_suffix($format, $currency_position) {
        switch ( $currency_position ) {
            case 'left' :
                $currency = '<span class="currency-suffix" style="padding-left:5px;">' . get_woocommerce_currency() . ' ex. GST</span>';
                $format = '%1$s%2$s' . $currency;
            break;
        }
    
        return $format;
    } // end function gm_add_currency_suffix
    
    public function gm_add_currency_suffix_action() {
        add_action('woocommerce_price_format', array($this,'gm_add_currency_suffix'), 1, 2);
    }
    /**
     * add ex. GST to the checkout product subtotal
     */
    // public function gm_woocommerce_cart_item_subtotal($html) {
    //     $currency = '<span class="currency-suffix"> ex. GST</span>';
    //     return $html . $currency;
    // }

    /**
     * Add the currency after the price for the total
     */
    public function gm_add_currency_suffix_for_total($format, $currency_position) {
        switch ( $currency_position ) {
            case 'left' :
                $currency = '<span class="currency-suffix" style="padding-left:5px;">' . get_woocommerce_currency() . ' incl. GST</span>';
                $format = '%1$s%2$s' . $currency;
            break;
        }
    
        return $format;
    } // end function gm_add_currency_suffix
    
    public function gm_add_currency_suffix_for_total_action() {
        add_action('woocommerce_price_format', array($this,'gm_add_currency_suffix_for_total'), 1, 2);
    }

    /**
     * add ex. GST to the cart/checkout product subtotal and overall subtotal
     */
    public function gm_subtotal_suffix($html) {
        $currency = '<span class="currency-suffix"> ex. GST</span>';
        return $html . $currency;
    }
    /**
     * Change the tax label in the cart and in checkout
     */
    function gm_change_email_tax_label( $label ) {
        $label = 'Tax - GST';
        return $label;
    }
     /**
      * Add images for categories 
      */
    public function gm_customize_product_archive_header() {
        $current_term = get_queried_object();

        if(!empty($current_term) && property_exists($current_term, 'taxonomy') && $current_term->taxonomy == 'product_cat') {
            // See if there's an image defined
            if(function_exists('get_field')) { 
                $product_cat_header_image = get_field('category_header_image', $current_term);
            }
            if(!empty($product_cat_header_image) && $product_cat_header_image != null && $product_cat_header_image != '') {
                echo '<style type="text/css">';

                $url = $product_cat_header_image['url'];
                echo 'div.title {background-image:url(' . esc_url($url) . ') !important; background-size: cover; background-position: center;} ';
                echo '</style>';
            } // end if
        }
    } // end function gm_customize_product_archive_header
    /*
     * Change the category title tag from h2 to h6
     */ 
    public function gm_change_category_title_tag() {
        remove_action('woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10);
        add_action('woocommerce_shop_loop_subcategory_title', array($this, 'gm_woocommerce_shop_loop_subcategory_title'), 10);
    } // end function gm_change_category_title_tag

    /**
     * Show the subcategory title in the product loop.
     */
    public function gm_woocommerce_shop_loop_subcategory_title($category) {
        ?>
        <h6 class="woocommerce-loop-category__title">
            <?php
            echo esc_html($category->name);

            if ($category->count > 0) {
                echo apply_filters('woocommerce_subcategory_count_html', ' <mark class="count">(' . esc_html($category->count) . ')</mark>', $category); // WPCS: XSS ok.
            }
            ?>
        </h6>
        <?php
    } // end function gm_woocommerce_shop_loop_subcategory_title
    

    /*
    * Remove the product loop on our custom shop page
    */    
    public function gm_remove_products_from_shop_page( $query ) {
        if ( ! $query->is_main_query() ) return;
        if ( ! $query->is_post_type_archive() ) return;
        if ( ! is_admin() && is_shop() ) {
            $query->set( 'post__in', array(0) );
        }
        remove_action( 'pre_get_posts', array($this, 'gm_remove_products_from_shop_page') );
        remove_action( 'woocommerce_no_products_found', 'wc_no_products_found' );

    } // end function gm_remove_products_from_shop_page

    /**
     * Add On Order status for products
     */
    public function gm_woocommerce_product_stock_status_options( $status ) {
        $status['onbackorder'] = 'On Order';
        return $status;
    }

    /**
     * Add the On Order status in the product list
     */
    public function gm_woocommerce_admin_stock_html($stock_html, $product) {
        if($product->get_stock_status() == 'onbackorder') {
            $stock_html = '<mark class="onbackorder">On Order</mark>';
        }
        return $stock_html;
    }
    /**
     * Wrap the cart quantity buttons in a div so it can be styled.
     */
    public function gm_woocommerce_before_add_to_cart_quantity(){
        echo '<div class="quantity-wrapper">';
    } // end function gm_woocommerce_before_add_to_cart_quantity

    /**
     * End wrap the cart quantity buttons in a div so it can be styled.
     */

    public function gm_woocommerce_after_add_to_cart_quantity(){

        echo '</div><!--quantity-wrapper-->';
        echo '<div class="buttons-wrapper">';

    } // end function gm_woocommerce_after_add_to_cart_quantity

    /**
     * End wrap the cart buttons in a div so it can be styled.
     */

    public function gm_woocommerce_after_add_to_cart_button(){
        echo '</div><!--buttons-wrapper-->';
    } // end function gm_woocommerce_after_add_to_cart_button

    
    /**
     * Hide the add to cart button on the product if the checkbox is set by adding a 
     * div that can be referenced in CSS
     */
    public function gm_hide_add_to_cart_button() {

        global $product;
        if($product->get_price() == 0 || $product->get_price() == '' || $product->get_stock_status() == 'onbackorder') {
            echo '<div class="remove-buttons"></div>';
        } else if(function_exists('get_field')) { 
            $hide_add_to_cart_button_setting = get_field('hide_add_to_cart_button', $product->get_id());
            if($hide_add_to_cart_button_setting){
                echo '<div class="remove-buttons"></div>';
            }
        }

    }

    /**
     * Hide the add to cart button in the shop if needed.
     * Otherwise change the buttons to say "Buy Now" and link to the product page.
     */
    public function gm_hide_add_to_cart_button_in_shop($add_to_cart_html, $product) {
        // wl($add_to_cart_html);
        // wl($product->getType)
        // $product_type = get_the_terms( $product->get_id(),'product_type')[0]->slug;
        if($product->is_type( 'variable' )) {
            $product_term_ids = wc_get_product_term_ids($product->ID, 'product_cat');
            $wholesale_category_id = '945';
            if ( in_array( $wholesale_category_id, $product_term_ids ) ) {

                // Change the permalink
                $permalink = get_permalink( $product->get_id() );
                $add_to_cart_html = str_replace($permalink, $permalink . '?access=wholesaler', $add_to_cart_html);
         
            }
            
        }

        return $add_to_cart_html;
// wl($product_type);
        // if(function_exists('get_field')) { 
        //     $hide_add_to_cart_button_setting = get_field('hide_add_to_cart_button', $product->get_id());
        //     if($hide_add_to_cart_button_setting || $product->get_stock_status() == 'onbackorder'){
        //         $add_to_cart_html = '<span class="add-to-cart-button-outer"><span class="add-to-cart-button-inner"><a href="' . get_permalink( $product->get_id() ) . '" data-quantity="1" class="button product_type_simple add_to_cart_button qbutton add-to-cart-button" data-product_id="'. $product->get_id() . '" aria-label="View &ldquo;' . $product->get_title() . '&rdquo; Now" rel="nofollow">View Product</a></span></span>';
        //         return $add_to_cart_html;
        //     }
        // }

        $add_to_cart_html = '<span class="add-to-cart-button-outer"><span class="add-to-cart-button-inner"><a href="' . get_permalink( $product->get_id() ) . '" data-quantity="1" class="button product_type_simple add_to_cart_button qbutton add-to-cart-button" data-product_id="'. $product->get_id() . '" aria-label="Buy &ldquo;' . $product->get_title() . '&rdquo; Now" rel="nofollow">Buy Now</a></span></span>';

        return $add_to_cart_html;

    }
    /**
     * Change the add to cart button text
     */
    public function gm_woocommerce_product_single_add_to_cart_text() {
        return __( 'Buy Now', 'woocommerce' ); 
    }
    /** 
     * Filter out $0.00 prices from showing
     */
    public function gm_filter_zero_dollar_prices() {
        global $product;
        if($product->get_price() == '0') {
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
        }
    }

    /**
     * Hide the price on the frontend if the checkbox is set or if on backorder
     */
    public function gm_hide_price($price_html, $product) {

        if(function_exists('get_field')) { 
            if($product->get_type() == 'variation'){
                $product_id = $product->get_parent_id();
            } else if( $product->get_type() == 'simple' || $product->get_type() == 'variable') {
                $product_id = $product->get_id();
            }

            $hide_price = get_field('hide_price', $product_id);

            if($hide_price) {
                // add_action('wp_footer', array($this,'gm_hide_variation_price_css'));
                return '';
            } 
        }
        
        if($product->get_stock_status() == 'onbackorder') {
            return '<div class="hide-price"></div>';
        }

        return $price_html;
    }

    /**
     * Add simple CSS to the footer to hide the variation price that's shown
     * when a selection is made
     */
    // public function gm_hide_variation_price_css() {
    //     echo '<style type="text/css">.woocommerce-variation-price{display:none!important;}</style>';
    // }

    /**
     * Force $0 price if it's empty
     */
    public function gm_filter_woocommerce_empty_price( $price, $product ) { 
        if($price == '') {
            $price = '0';
        }  
        return $price; 
    } 
    /** 
     * Force the quantity buttons to always show
     */
    public function gm_force_quantity_buttons_to_show( $args, $product ) {
        if( $product->get_stock_quantity() == 1 && is_product() ){
            $args['min_value'] = 0;
        }
        return $args;
    }
     /**
     * Change lead time text
     */
    public function gm_change_available_on_backorder_text($availability, $product) {

        $availability_backorder = $this->starts_with($availability, 'Available on backorder');
        if($availability_backorder) {

            $availability = str_replace('Available on backorder', '', $availability);
            $availability = str_replace('class="wclt_lead_time">&nbsp;| ', 'class="wclt_lead_time">', $availability);
        }
            // Available on backorder<span style="color: #1c1d20;" class="wclt_lead_time">&nbsp;| LEAD TIME: 8 - 10 weeks
        return $availability;
    }

    public function starts_with($string, $startString) { 
        $len = strlen($startString); 
        return (substr($string, 0, $len) === $startString); 
    } 

    /**
     * Add a "Continue Shopping" button after adding an item to the cart. This is 
     * also called by the gm_add_quote_continue_shopping_button_action function.
     */
    public function gm_add_continue_shopping_button($html = '') {
        
        $html = str_replace('</a>', '</a><span class="gm-added-message">', $html);
        $html = $html . '</span>';

        $return_to_shop_link = get_permalink(woocommerce_get_page_id('shop'));
        return '<div class="gm-added-to-cart-message"><a href="' . $return_to_shop_link . '" class="gm-continue-shopping button">Continue Shopping</a>' . $html . '</div>';
    }
    /**
     * Remove the coupon forms from the cart while leaving the coupons enabled
     * for YITH Request a Quote
     */
    public function gm_remove_coupon_forms() {
        add_filter( 'woocommerce_coupons_enabled', '__return_false' );
    }
    /**
     * Remove the coupon forms from the cart while leaving the coupons enabled
     * for YITH Request a Quote
     */
    public function gm_remove_checkout_coupon_forms() {
        remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
    }
    /**
     * Move the Proceed to Checkout button to the bottom of the totals
     */
    public function gm_move_cart_proceed_to_checkout_button() {
        do_action( 'woocommerce_proceed_to_checkout' );
    }

    /**
     * Change the PDF file name
     */
    public function gm_ywraq_pdf_file_name($pdf_file_name, $order_id) {
        $order = wc_get_order($order_id);
        $customer_firstname = yit_get_prop( $order, '_billing_first_name', true );
        $customer_lastname  = yit_get_prop( $order, '_billing_last_name', true );
        
        $user_name_concatenated = $customer_firstname . '_' . $customer_lastname;

		if($customer_lastname == null || $customer_lastname == '') {
            $user_name = yit_get_prop( $order, 'ywraq_customer_name', true );
            $user_name_parts = explode(" ", $user_name);
            $user_name_concatenated = implode("_", $user_name_parts);
		}

        $order_date = yit_get_prop($order, 'date_created', true);
		$order_date = substr($order_date, 0, 10);
		$order_date = str_replace('-', '_', $order_date);
        $pdf_file_name = sanitize_file_name('Gineico Marine Quote-' . $user_name_concatenated . '-' . $order_date . '-' . $order_id . '.pdf');
        
        return $pdf_file_name;
    }

    /** 
     * Change the PDF paper orientation
     */
    public function gm_ywraq_change_paper_orientation($orientation) {
		return 'landscape';
    }
    
    public function gm_quote_terms($order_id = null) {
		?>
		<p style="margin-top: 0; font-style: italic; font-size: 12px;">
            PLEASE TAKE NOTE OF ALL THE CONDITIONS OF THIS QUOTE AS STATED BELOW, BEFORE PLACING AN ORDER
			<ol>
                <li style="font-style: italic; margin-bottom: 5px; font-size: 12px; color: #232323 !important">Until fully Paid, goods remain the sole property of Gineico Queensland Pty Ltd.</li>

                <li style="font-style: italic; margin-bottom: 5px; font-size: 12px; color: #232323 !important">Unless otherwise specified, indicated costs are unit costs.</li>

                <li style="font-style: italic; margin-bottom: 5px; font-size: 12px; color: #232323 !important">Prices are quoted in Australian Dollars not including G.S.T</li>

                <li style="font-style: italic; margin-bottom: 5px; font-size: 12px; color: #232323 !important">Prices are quoted for goods ex our store. Delivery charges will apply if goods are required to be on-forwarded.</li>

                <li style="font-style: italic; margin-bottom: 5px; font-size: 12px; color: #232323 !important">Unless otherwise stated, lead time is approximately 8-10 weeks from confirmation of order (not including holiday closures). Faster air freight delivery can be requested.</li>

                <li style="font-style: italic; margin-bottom: 5px; font-size: 12px; color: #232323 !important">Terms of sale: 50% deposit with written order. Balance in full prior to consignment.</li>

                <li style="font-style: italic; margin-bottom: 5px; font-size: 12px; color: #232323 !important">Balance of payment and collection of goods, to take place within 7 calendar days from date when goods become available. </li>

                <li style="font-style: italic; margin-bottom: 5px; font-size: 12px; color: #232323 !important">Failure to pay and collect goods by the stated time may incur storage costs or the forfeit of the deposit and goods.</li>

                <li style="font-style: italic; margin-bottom: 5px; font-size: 12px; color: #232323 !important">Payments made by cheque, credit card or telegraphic transfer, will be subject to clearance of funds (in our account), prior to goods being released. </li>

                <li style="font-style: italic; margin-bottom: 5px; font-size: 12px; color: #232323 !important">This offer is valid for 30 calendar days from this date.</li>

                <li style="font-style: italic; margin-bottom: 5px; font-size: 12px; color: #232323 !important">Reduction of the indicated quantity will be cause for revision of quoted prices.</li>

				<li style="font-style: italic; margin-bottom: 5px; font-size: 12px; color: #232323 !important">Restocking fee of 50% applies to all items returned and can only be accepted with a prior written consent by gineico QLD p/l. Goods returned at client's expense.</li>

                <li style="font-style: italic; margin-bottom: 5px; font-size: 12px; color: #232323 !important">Custom or non standard stock hardware cannot be returned.</li>

			</ol>
		</p>
		<?php
	}

    /**
     * Add a banner to product thumbs
     */
    public function gm_add_product_thumb_banner() {
        global $product;
        if( $product->get_stock_status() == 'instock' ) {
            echo '<div class="woocommerce-product-banner instock">In Stock</div>';
        }
    }

    /**
     * Change the default checkout country to Australia
     */
    public function gm_change_default_checkout_country() {
        return 'AU'; 
    }
      

    /**
     * Check for YITH Request a Quote emails and call the function to add the 
     * terms for the footer
     */
    public function gm_woocommerce_email_footer($email) {
        switch ($email->id) {
            case 'ywraq_email':
            case 'ywraq_email_customer':
            case 'yith_ywraq_quote_status':
            case 'yith_ywraq_send_quote':
            case 'yith_ywraq_send_email_request_quote_customer':
                $this->gm_quote_terms();
                
            break;
        }
    } // end gm_woocommerce_email_footer
   
    /**
     * Change the hide quote button text in the admin area
     */
    function gm_yith_change_text( $translated_text, $text, $domain ) {
        switch ( $translated_text ) {

            // Switching these headings but they need to be slightly different
            // or it enters a loop where it keeps trying to replace the other
            // one over and over.
            case '"Add to quote" button':
                $translated_text = __( 'Hide "Add to quote" button', 'woocommerce');
            break;
        }
        return $translated_text;
    } // end gm_yith_change_text


    function gm_yith_admin_css() {
        echo '<style type="text/css">.yith-plugin-fw #settings .the-metabox.checkbox {margin: 20px 0 10px !important; } .yith-plugin-fw #settings .the-metabox.checkbox label { margin-left: 0 !important; float: none; display: block !important; } .yith-plugin-fw #settings .the-metabox.checkbox .clear { display: none !important;clear: unset !important; }.yith-plugin-fw-checkbox-field-wrapper { width: auto !important;margin-right: 1px !important; }.yith-plugin-fw span.description { display: inline-block !important; }</style>';
    }
    /** 
     * Set the quotes back to new status after auto generating email
     */
    // public function gm_reset_auto_generated_quote_order_status( $raq, $order ) {
    //     if ( current_action() === 'ywraq_after_create_order' ) {
    //         $order = wc_get_order( $raq );
    //         if(!empty($order) && $order != null) {
    //             $order->update_status( 'ywraq-new' );

    //         }
    //     }
    // }
    /**
     * Set up where the Continue Shopping button should appear after the add to quote
     * button.
     */
    // public function gm_add_quote_continue_shopping_button_setup() {

    //     global $product;
    //     if ( ! $product ) {
    //         global $post;
    //         if ( ! $post || ! is_object( $post ) || ! is_singular() ) {
    //             return;
    //         }
    //         $product = wc_get_product( $post->ID );
    //         if ( ! $product ) {
    //             return;
    //         }

    //     }
    //     // see if the add to quote button is showing or not
    //     $yith_show_button = apply_filters( 'yith_ywraq-show_btn_single_page', true );

    //     if($yith_show_button){
    //         if ( $product->is_type( 'variable' ) ) {
    //             add_action( 'woocommerce_after_single_variation', array( $this, 'gm_add_quote_continue_shopping_button_action' ), 16 );
    //         } else {
    //             add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'gm_add_quote_continue_shopping_button_action' ), 16 );
    //         }
    //     }

    // }
    /**
     * Call and echo the function that creates the Continue Shopping button.
     */
    // public function gm_add_quote_continue_shopping_button_action() {
    //     echo $this->gm_add_continue_shopping_button();
    // }
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

$gm_woocommerce = new GM_WooCommerce();