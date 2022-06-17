<?php 
/**
 * v2.5.2
 */
namespace GineicoMarine\Theme;

class GM_WP_Forms {

    public function __construct() {
        add_filter( 'wpforms_process_smart_tags', array($this, 'wpf_dev_shortcodes_to_confirmation'), 12, 1 );
        add_action( 'wpforms_wp_footer', array($this, 'wpf_disable_multipage_scroll') );

    }
    /**
     * Run shortcodes in the confirmation message.
     *
     * @link   https://wpforms.com/developers/how-to-display-shortcodes-inside-the-confirmation-message/
     */
    public function wpf_dev_shortcodes_to_confirmation( $content ) {
        
        return do_shortcode( $content );
    }

    /**
     * Disable multipage scroll
     *
     */
    function wpf_disable_multipage_scroll() {
        ?>
        <script type="text/javascript">window.wpforms_pageScroll = false;</script>
        <?php
    }
} // end class GM_WP_Forms
$gm_wp_forms = new GM_WP_Forms();