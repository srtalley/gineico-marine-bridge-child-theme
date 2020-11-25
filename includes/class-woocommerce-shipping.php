<?php 

namespace GineicoMarine\Theme;

class GM_WooCommerce_Shipping{

    public function __construct() {

        add_filter( 'woocommerce_package_rates', array($this, 'businessbloomer_hide_free_shipping_for_shipping_class'), 10, 2 );
    }
   
    function businessbloomer_hide_free_shipping_for_shipping_class( $rates, $package ) {

        $shipping_classes = get_terms( array('taxonomy' => 'product_shipping_class', 'hide_empty' => false ) );
        foreach($shipping_classes as $shipping_class) {
            if($shipping_class->slug == 'foresti-suardi-under-5kg') {
                $shipping_class_foresti_suardi = $shipping_class->term_id; 
            }
        }

        // Get the shipping rates
        // foreach ($rates as $rate_key => $rate) {
        //     if($rate->label == 'Flat rate F&amp;S') {
        //         $shipping_rate_foresti_suardi = $rate_key;
        //     }
        // }
        $shipping_rate_foresti_suardi = 'flat_rate:8';
        $in_cart_shipping_class_foresti_suardi = false;
        $in_cart_shipping_class_other = false;
        foreach ( WC()->cart->get_cart_contents() as $key => $values ) {
            if ( $values[ 'data' ]->get_shipping_class_id() == $shipping_class_foresti_suardi ) {

                $in_cart_shipping_class_foresti_suardi = true;
                break;
            } else {
                $in_cart_shipping_class_other = true;
            }
        }
        if ( $in_cart_shipping_class_foresti_suardi && !$in_cart_shipping_class_other  ) {
            unset($rates['Mamis_Shippit_standard']);
            unset($rates['Mamis_Shippit_express']);
            unset($rates['Mamis_Shippit_priority']);
        } else if ($in_cart_shipping_class_other) {
            unset($rates[$shipping_rate_foresti_suardi]);
        }
        return $rates;
    }

} // end class GM_WooCommerce_Account
$gm_woocommerce_shipping = new GM_WooCommerce_Shipping();