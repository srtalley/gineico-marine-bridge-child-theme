<?php 
/**
 * v2.5.2
 */
namespace GineicoMarine\Theme;

class GM_Posts {

    public function __construct() {
        add_filter( 'pre_get_posts', array($this, 'gm_exclude_category_faqs') );

    }
    function gm_exclude_category_faqs( $query ) {
        if ( $query->is_home ) {
            $query->set( 'cat', '-1851' );
        }
        return $query;
    }
        
    

} // end class GM_Posts
$gm_posts = new GM_Posts();