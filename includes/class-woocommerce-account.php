<?php 

namespace GineicoMarine\Theme;

class GM_WooCommerce_Account {

    public function __construct() {

        add_filter( 'woocommerce_account_menu_items', array($this, 'gm_wc_account_new_tabs') );

        add_filter( 'woocommerce_get_endpoint_url', array($this, 'gm_wc_account_hook_endpoint'), 10, 4 );

    }

    /**
     * Custom help to add new items into an array after a selected item.
     *
     * @param array $items
     * @param array $new_items
     * @param string $after
     * @return array
     */
    public function gm_wc_custom_insert_after_helper( $items, $new_items, $after ) {
        // Search for the item position and +1 since is after the selected item key.
        $position = array_search( $after, array_keys( $items ) ) + 1;

        // Insert the new item.
        $array = array_slice( $items, 0, $position, true );
        $array += $new_items;
        $array += array_slice( $items, $position, count( $items ) - $position, true );

        return $array;
    }
    /**
     * Insert the new endpoint into the My Account menu.
     *
     * @param array $items
     * @return array
     */
    function gm_wc_account_new_tabs( $items ) {
        $new_items = array();
        // check if trade customer
        $user = wp_get_current_user();
        $is_trade_customer = \apply_filters('gm_wc_is_trade_customer', $user->ID);
        if($is_trade_customer || current_user_can('administrator')) {
            $new_items['gianneschi-downloads'] = __( 'PDF Trade Downloads', 'woocommerce' );
        }

        // remove Downloads 
        unset($items['downloads']);

        // Add the new item after `orders`.
        return $this->gm_wc_custom_insert_after_helper( $items, $new_items, 'orders' );
    }

     
   public function gm_wc_account_hook_endpoint( $url, $endpoint, $value, $permalink ){

        if( $endpoint === 'gianneschi-downloads' ) {
            // ok, here is the place for your custom URL, it could be external
            $url = site_url() . '/gianneschi-trade-downloads/';
     
        }
        return $url;
     
    }

} // end class GM_WooCommerce_Account
$gm_woocommerce_account = new GM_WooCommerce_Account();