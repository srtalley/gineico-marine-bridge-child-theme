<?php 
/**
 * v2.5.0
 */
namespace GineicoMarine\Theme;

class GM_TradeCustomer {

    public function __construct() {
        add_shortcode( 'trade_customer_registration_form', array($this, 'gm_trade_customer_registration_form') );
        add_shortcode( 'trade_customer_role_only', array($this, 'gm_trade_customer_role_only') );

        // add_action( 'woocommerce_register_post', array($this, 'gm_trade_customer_validate_user_frontend_fields'), 10, 3 );

        add_action( 'show_user_profile', array($this, 'gm_show_trade_customer_user_fields') );
        add_action( 'edit_user_profile', array($this, 'gm_show_trade_customer_user_fields') );

        add_filter( 'woocommerce_registration_errors', array($this,'gm_trade_customer_validate_user_frontend_fields'), 10 );
        add_filter( 'woocommerce_save_account_details_errors', array($this,'gm_trade_customer_validate_user_frontend_fields'), 10 );
        
        add_action( 'user_register', array($this,'gm_create_user_as_trade_customer'), 1); // register/checkout
        add_action( 'personal_options_update', array($this,'gm_trade_customer_save_account_fields') ); // edit own account admin
        add_action( 'edit_user_profile_update', array($this,'gm_trade_customer_save_account_fields') ); // edit other account admin
        // add_action( 'woocommerce_save_account_details', array($this,'gm_trade_customer_save_account_fields') ); // edit WC account

        add_filter( 'gm_trade_customer_account_fields', array($this, 'gm_trade_customer_add_post_data_to_account_fields'), 10, 1 );

        // filter the new user approval plugin 
        add_filter( 'new_user_approve_default_status', array($this,'gm_trade_customer_new_user_approval'), 10, 2);

        // remove the new user approve message on the login page
        remove_filter( 'login_message', array( \pw_new_user_approve::instance(), 'welcome_user' ) );

        // change the admin email
        add_filter('new_user_approve_request_approval_message', array($this, 'gm_trade_customer_new_user_approve_admin_email'), 10, 3 );

        add_filter( 'new_user_approve_email_admins', array($this, 'gm_trade_customer_approval_email_addresses') );
 
        // change the user approve emails
        add_filter( 'new_user_approve_approve_user_message_default', array($this, 'gm_trade_customer_approve_user_message'), 10, 1 );
        add_filter( 'new_user_approve_approve_user_subject', array($this, 'gm_trade_customer_approve_user_subject'), 10, 1 );

        // allow getting the role
        add_filter( 'gm_wc_is_trade_customer', array($this, 'gm_wc_is_trade_customer_role'), 10, 1);

        // send an email notification when download ends
        add_action( 'wpdm_onstart_download', array($this, 'gm_trade_customer_download_notification') ); 

        // remove the HTML content type from the email after it's sent
        add_action( 'new_user_approve_approve_user', array($this, 'remove_html_content_type'), 1000, 1 );

        // Registration date columns
        add_filter( 'manage_users_columns', array($this, 'gm_modify_user_table') );
        add_filter( 'manage_users_custom_column', array($this, 'gm_modify_user_table_row'), 10, 3 );
        add_filter( 'manage_users_sortable_columns', array($this, 'gm_make_registered_column_sortable') );
    }
    
    /**
     * Add a trade customer registration form
     */
    public function gm_trade_customer_registration_form() {

        $is_pending_user = false;
        if(isset($_POST['email']) && $_POST['email'] != '') {
            // lookup to see if account has been created
            $user = get_user_by('email', $_POST['email']);

            if(is_object($user) && $user->ID != '') {
                $status = get_user_meta( $user->ID, 'pw_user_status', true );

                if($status == 'pending') {
                    $is_pending_user = true;
                }
            }
        }

        ob_start();
        
        if($is_pending_user) {
            ?>
            <h3>Your account is currently pending approval. Please wait to hear from Gineico Marine. Thank you.</h3>
            <?php
        } else {

        // these two lines enqueue the login nocaptcha scripts
        wp_enqueue_script('login_nocaptcha_google_api');
        wp_enqueue_style('login_nocaptcha_css');

        // NOTE: THE FOLLOWING <FORM></FORM> IS COPIED FROM woocommerce\templates\myaccount\form-login.php
        // IF WOOCOMMERCE RELEASES AN UPDATE TO THAT TEMPLATE, YOU MUST CHANGE THIS ACCORDINGLY
        // wc_print_notices(); 
        do_action( 'woocommerce_before_customer_login_form' );
        // enqueue the country change script

        wp_enqueue_script('wc-country-select');
        
        ?>
        <script type="text/javascript">
            jQuery(function($) {
                $(document).ready(function(){
                $('#billing_country, #billing_state').select2();
                });
            });
        </script>
        <form method="post" class="woocommerce woocommerce-page trade-customer-registration-form woocommerce-form woocommerce-form-register  woocommerce-billing-fields register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
    
            <?php do_action( 'woocommerce_register_form_start' ); ?>          
    
            <?php 
                $gm_account_fields = $this->gm_get_trade_customer_account_fields();
                foreach ( $gm_account_fields as $key => $field_args ) {   
                    woocommerce_form_field( $key, $field_args, $field_args['value'] );
                }
                echo '<input type="hidden" class="input-hidden" name="register_trade_customer" id="register_trade_customer" value="true">';
                echo '<input type="hidden" class="input-hidden" name="redirect_to" id="redirect_to" value="' . site_url() . '/shop">';
            ?>

            <?php do_action( 'woocommerce_register_form' ); ?>
    
            <p class="woocommerce-FormRow form-row">
                <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                <button type="submit" id="trade-customer-register-submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
            </p>
    
            <?php do_action( 'woocommerce_register_form_end' ); ?>
    
        </form>
        <script type="text/javascript">

            jQuery(document).ready(function(){
                // Login no captcha is disabling this button. Re-enable it
                setTimeout(function(){
                    jQuery('#trade-customer-register-submit').removeAttr('disabled');
                }, 5000) 

            });

        </script>
        <?php
        } // end if pending approval
        return ob_get_clean();
    }

    /**
     * Shortcode to check if a user has the trade customer role
     */
    public function gm_trade_customer_role_only() {
        if(is_admin()) {
            return;
        }
        if ( is_user_logged_in() ) {
            $user = wp_get_current_user();
            $roles = ( array ) $user->roles;
            if (!in_array( 'administrator', $roles ) && !in_array( 'trade_customer', $roles )) {
                wp_redirect( home_url('/trade-customer-registration/') );
                die();
            }
        } else {
            wp_redirect( home_url('/trade-customer-registration/') );
            die();
        }
    }

    /**
     * Function to check if a user has the trade customer role
     */
    public function gm_wc_is_trade_customer_role($user_id) {
        $user = get_user_by('id', $user_id);
        $roles = ( array ) $user->roles;
        if (in_array( 'trade_customer', $roles )) {
            return true;
        } 
        return false;
    }

    /**
    * Get additional account fields.
    *
    * @see https://iconicwp.com/blog/the-ultimate-guide-to-adding-custom-woocommerce-user-account-fields/
    *
    * @return array
    */


    public function gm_get_trade_customer_account_fields() {
        // $woocommerce = WC();
        $checkout = WC()->checkout();
        return apply_filters( 'gm_trade_customer_account_fields', array(
            'billing_company' => array(
                'type'        => 'text',
                'label'       => __( 'Company', 'gineicomarine' ),
                'placeholder' => __( 'Company', 'gineicomarine' ),
                'required'    => true,
            ),
            'email' => array(
                'type'        => 'email',
                'label'       => __( 'Email Address', 'gineicomarine' ),
                'placeholder' => __( 'Email Address', 'gineicomarine' ),
                'required'    => true,
            ),
            'first_name' => array(
                'type'        => 'text',
                'label'       => __( 'First Name', 'gineicomarine' ),
                'placeholder' => __( 'First Name', 'gineicomarine' ),
                'required'    => true,
                'secondary_meta_field' => 'billing_first_name'
            ),
            'last_name' => array(
                'type'        => 'text',
                'label'       => __( 'Last Name', 'gineicomarine' ),
                'placeholder' => __( 'Last Name', 'gineicomarine' ),
                'required'    => true,
                'secondary_meta_field' => 'billing_last_name'
            ),
            'billing_city' => array(
                'type'        => 'text',
                'label'       => __( 'City', 'gineicomarine' ),
                'placeholder' => __( 'City', 'gineicomarine' ),
                'required'    => true,
            ),
            'billing_country' => array(
                'type'        => 'country',
                'label'       => __( 'Country', 'woocommerce' ),
                'placeholder' => __('Choose your country.', 'woocommerce'),
                // 'clear'       => true,
                'required'    => true,
                'class' => ['address-field'],
                'default'     => 'AU'
            ),
            'billing_state' => array(
                'type'        => 'state',
                'label'       => __( 'State', 'woocommerce' ),
                'placeholder' => __('Choose your state.', 'woocommerce'),

                'required'    => true,
                'class' => ['address-field'],
                'validate' => ['state']
            ),
            'billing_position' => array(
                'type'        => 'text',
                'label'       => __( 'Position', 'gineicomarine' ),
                'placeholder' => __( 'Position', 'gineicomarine' ),
                'required'    => false,
                'user_additional' => true
            ),
            'billing_phone' => array(
                'type'        => 'tel',
                'label'       => __( 'Phone', 'gineicomarine' ),
                'placeholder' => __( 'Phone', 'gineicomarine' ),
                'required'    => true,
            ),
            'billing_mobile' => array(
                'type'        => 'tel',
                'label'       => __( 'Mobile', 'gineicomarine' ),
                'placeholder' => __( 'Mobile', 'gineicomarine' ),
                'required'    => false,
                'user_additional' => true
            ),
            // 'trade_customer' => array(
            //     'type'        => 'hidden',
            //     // 'label'       => __( 'Trade Customer', 'gineicomarine' ),
            //     // 'placeholder' => __( 'Trade Customer', 'gineicomarine' ),
            //     'default' => true
            // ),
        ) );
    }
    /**
     * Add fields to admin area.
     *
     * @see https://iconicwp.com/blog/the-ultimate-guide-to-adding-custom-woocommerce-user-account-fields/
     */
    public function gm_show_trade_customer_user_fields($user) {
        // check if this is a trade customer 
        $is_trade_customer = $this->check_if_trade_customer($user->id);

        if($is_trade_customer) {

            $fields = $this->gm_get_trade_customer_account_fields();
            ?>
            <h2><?php _e( 'Additional Information', 'gineicomarine' ); ?></h2>
            <table class="form-table" id="iconic-additional-information">
                <tbody>
                <?php foreach ( $fields as $key => $field_args ) { 
                    if(isset($field_args['user_additional']) && $field_args['user_additional']) :
                    $current_value = esc_html( get_the_author_meta( $key, $user->ID ) );
                    ?>
                    <tr>
                        <th>
                            <label for="<?php echo $key; ?>"><?php echo $field_args['label']; ?></label>
                        </th>
                        <td>
                            <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $current_value; ?>" class="regular-text">
                        </td>
                    </tr>
                <?php 
                endif;
                } ?>
                </tbody>
            </table>
            <?php
        } // end if trade customer

    }

    /**
    * Is field visible.
    *
    * @param $field_args
    *
    * @return bool
    */

    public function gm_trade_customer_is_field_visible( $field_args ) {

        $visible = true;
        $action = filter_input( INPUT_POST, 'action' );

        if ( is_admin() && ! empty( $field_args['hide_in_admin'] ) ) {
            $visible = false;
        } elseif ( ( is_account_page() || $action === 'save_account_details' ) && is_user_logged_in() && ! empty( $field_args['hide_in_account'] ) ) {
            $visible = false;
        } elseif ( ( is_account_page() || $action === 'save_account_details' ) && ! is_user_logged_in() && ! empty( $field_args['hide_in_registration'] ) ) {
            $visible = false;
        } elseif ( is_checkout() && ! empty( $field_args['hide_in_checkout'] ) ) {
            $visible = false;
        }
        return $visible;

    }

    /**
    * Is this field core user data.
    *
    * @param $key
    *
    * @return bool
    */

    public function gm_trade_customer_is_userdata( $key ) {

        $userdata = array(
            'user_pass',
            'user_login',
            'user_nicename',
            'user_url',
            'user_email',
            'display_name',
            'nickname',
            'first_name',
            'last_name',
            'description',
            'rich_editing',
            'user_registered',
            'role',
            'jabber',
            'aim',
            'yim',
            'show_admin_bar_front',
        );

        return in_array( $key, $userdata );

    }

    /**
     * Set the user as a trade customer if that hidden field is selected
     */
    public function gm_create_user_as_trade_customer( $customer_id ) {

        $trade_customer_registration = sanitize_text_field(isset( $_POST[ 'register_trade_customer' ] ) ? $_POST[ 'register_trade_customer' ] : '');

        if($trade_customer_registration == 'true') {
            $user = get_user_by('id', $customer_id);
            $user->set_role('trade_customer');
            $this->gm_trade_customer_save_account_fields($customer_id);
        } else {
            // do not send the new user approval email
            add_filter('new_user_approve_email_admins', array($this, 'gm_trade_customer_remove_admin_emails'));
        }


    }
    /**
     * Returns true or false if the current user has the role "trade_customer"
     */
    public function check_if_trade_customer($user_id) {

        $user = get_user_by('id', $user_id);

        $roles = (array) $user->roles;
        if(in_array( 'trade_customer', $roles )) {
            return true;
        } else {
            return false;
        }
    } // end function check_if_trade_customer
    /**
    * Save registration fields.
    *
    * @param int $customer_id
    *
    * @see https://iconicwp.com/blog/the-ultimate-guide-to-adding-custom-woocommerce-user-account-fields/
    */

    public function gm_trade_customer_save_account_fields( $customer_id ) {

        // check if this is a trade customer 
        $is_trade_customer = $this->check_if_trade_customer($customer_id);

        if($is_trade_customer) {

            $fields = $this->gm_get_trade_customer_account_fields();
            $sanitized_data = array();

            foreach ( $fields as $key => $field_args ) {

                if ( ! $this->gm_trade_customer_is_field_visible( $field_args ) ) {

                    continue;

                }

                $sanitize = isset( $field_args['sanitize'] ) ? $field_args['sanitize'] : 'wc_clean';
                $value    = isset( $_POST[ $key ] ) ? call_user_func( $sanitize, $_POST[ $key ] ) : '';

                if ( $this->gm_trade_customer_is_userdata( $key ) ) {
                    $sanitized_data[ $key ] = $value;
                    continue;
                }        

                update_user_meta( $customer_id, $key, $value );
                if(isset($field_args['secondary_meta_field']) && $field_args['secondary_meta_field'] != '') {
                    update_user_meta( $customer_id, $field_args['secondary_meta_field'], $value );
                }
            }
        
            if ( ! empty( $sanitized_data ) ) {
                $sanitized_data['ID'] = $customer_id;
                wp_update_user( $sanitized_data );
            }
        } // end if trade customer


    }

    /**
    * Validate fields on frontend.
    *
    * @param WP_Error $errors
    *
    * @return WP_Error
    *
    * @see https://iconicwp.com/blog/the-ultimate-guide-to-adding-custom-woocommerce-user-account-fields/
    */

    public function gm_trade_customer_validate_user_frontend_fields( $errors ) {

        $trade_customer_registration = sanitize_text_field(isset( $_POST[ 'register_trade_customer' ] ) ? $_POST[ 'register_trade_customer' ] : '');

        if($trade_customer_registration == 'true') {

            $fields = $this->gm_get_trade_customer_account_fields();
        
            foreach ( $fields as $key => $field_args ) {

                if ( empty( $field_args['required'] ) ) {
                    continue;
                }

                if ( ! isset( $_POST['register'] ) && ! empty( $field_args['hide_in_account'] ) ) {
                    continue;
                }

                if ( isset( $_POST['register'] ) && ! empty( $field_args['hide_in_registration'] ) ) {
                    continue;
                }

                if ( empty( $_POST[ $key ] ) ) {
                    $message = sprintf( __( '%s is a required field.', 'iconic' ), '<strong>' . $field_args['label'] . '</strong>' );
                    $errors->add( $key, $message );
                    // wc_add_notice( __( $message ), 'error' );
                }
            }
        } // end if trade customer registration

        return $errors;
    }


    /**
    * Add post values to account fields if set.
    *
    * @see https://iconicwp.com/blog/the-ultimate-guide-to-adding-custom-woocommerce-user-account-fields/
    *
    * @param array $fields
    *
    * @return array
    */
    
    public function gm_trade_customer_add_post_data_to_account_fields( $fields ) {
        if ( empty( $_POST ) ) {
            return $fields;
        }

        foreach ( $fields as $key => $field_args ) {
    
            if ( empty( $_POST[ $key ] ) ) {
                if(!empty($field_args['default'])) {
                    $fields[ $key ]['value'] = $field_args['default'];  
                } else {
                    $fields[ $key ]['value'] = '';
                }

                continue;
            }

            $fields[ $key ]['value'] = $_POST[ $key ];
        }
 
        return $fields;
    }

    /**
     * Approve all user accounts except the trade customer ones
     */
    public function gm_trade_customer_new_user_approval($status, $user_id){

        $trade_customer_registration = sanitize_text_field(isset( $_POST[ 'register_trade_customer' ] ) ? $_POST[ 'register_trade_customer' ] : '');

        if($trade_customer_registration == 'true') {
            $status = 'pending';

            // remove the woocommerce new customer email
            add_action( 'woocommerce_email', array($this, 'gm_trade_customer_disable_account_creation_email') );

        } else {
            $status = 'approved';
        }

        return $status;

    }
    /**
     * New User Approve Admin email
     */
    public function gm_trade_customer_new_user_approve_admin_email($message, $user_login,$user_email) {

        $user = get_user_by( 'login', $user_login );
        $fields = $this->gm_get_trade_customer_account_fields();
        $message = 'A new Trade Customer registration request has been submitted with the following details:' . "\n\n";
        foreach ( $fields as $key => $field_args ) { 
 
            $current_value = get_user_meta($user->ID ,$key, true);

            $message .= $field_args['label'] . ': ' . $current_value . "\n\n";

        }
        $message .= 'To approve or deny this request, go to to ' . admin_url( 'users.php?s&pw-status-query-submit=Filter&new_user_approve_filter-top=pending&paged=1' ) . "\n\n";

        return $message;
    }

    /**
     * Do not send the WooCommerce new user emails for trade customers
     */
    public function gm_trade_customer_disable_account_creation_email($email_class) {
        remove_action( 'woocommerce_created_customer_notification', array( $email_class, 'customer_new_account' ), 10, 3 );
    }
    
    /**
     * Set the email addresses that the trade customer approvals should go to
     */
    public function gm_trade_customer_approval_email_addresses($emails) {

        $emails = array(get_option("admin_email"),'pg@gineico.com');
        return $emails;
    }

    /**
     * Remove any emails from the admin email so that it won't send
     */
    public function gm_trade_customer_remove_admin_emails($emails) {
        return false;
    }

    /** 
     * Apply the HTML content type to the email
     */
    public function set_html_content_type() {
        return 'text/html';
    }
    /**
     * Remove the HTML content type filter
     */
    public function remove_html_content_type() {
        remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
    }

    /**
     * Change the user approval message
     */
    public function gm_trade_customer_approve_user_message($message) {

        add_filter( 'wp_mail_content_type', array($this, 'set_html_content_type') );
        ob_start();
        require dirname(THEME_FUNCTIONS__FILE__) . '/woocommerce/emails/email-header.php';
        $new_message = ob_get_contents();
        ob_end_clean();
        $new_message .= '<h2>Thank you for registering for a Trade Account. Your Trade Account has now been approved.</h2>';
        $new_message .= '<p>{username}</p>';
        $new_message .= '<p>{password}</p>';

        // $new_message .= '<p>Set your password at this link: <br />';
        // $new_message .= '<strong><a href="' . site_url() . '/my-account/lost-password/' .'" target="_blank" style="color: #242e4a">' . site_url() . '/my-account/lost-password/</a></strong></p>';
        $new_message .= '<p>Please log into your account at <strong><a href="' . site_url() . '/my-account" target="_blank" style="color: #242e4a">' . site_url() . '/my-account</a></strong> then use the website menu tab <strong>TRADE ONLY DOWNLOADS</strong> that sits under the <strong>CONTACT</strong> tab in the main menu.</p>';
        $new_message .= '<p>You may change your password at <strong><a href="' . site_url() . '/my-account/edit-account/" target="_blank" style="color: #242e4a">' . site_url() . '/my-account/edit-account/</a></strong>.</p>';

        ob_start();
        include dirname(THEME_FUNCTIONS__FILE__) . '/woocommerce/emails/email-footer.php';
        $new_message .= ob_get_contents();
        ob_end_clean();

        return $new_message;
    }

    /**
     * Change the user approval subject
     */
    public function gm_trade_customer_approve_user_subject($subject) {
        $subject = 'Gineico Marine - Trade Customer Registration Approved';
        return $subject;
    }
    
    /**
     * Send an email notification on PDF download
     */

    public function gm_trade_customer_download_notification($package){
        $package_data = get_post($package['ID']);
        $user = wp_get_current_user();
        $headers = 'From: Gineico Marine <noreply@gineicomarine.com.au>' . "\r\n";
        $headers .= 'Content-type: text' . "\r\n";
        $subject = 'Trade Customer Download Notification';
        
        $message = 'Name: ' . get_the_author_meta( 'first_name', $user->ID ) . ' ' . get_the_author_meta( 'last_name', $user->ID ) . "\n\n";
        $message .= 'Email: ' . $user->user_email . "\n\n";
        $message .= 'Download: '  . $package_data->post_title . "\n\n";
        // $message .= "Downloader's IP: ". $_SERVER['REMOTE_ADDR'];
        $group_emails = array( get_option("admin_email"), 'pg@gineico.com', 'sales@gineico.com' );

        wp_mail($group_emails, $subject, $message, $headers); 
    } 

    /*
    * Create a column. And maybe remove some of the default ones
    * @param array $columns Array of all user table columns {column ID} => {column Name} 
    */


    public function gm_modify_user_table( $columns ) {
    
        // unset( $columns['posts'] ); // maybe you would like to remove default columns
        $columns['registration_date'] = 'Registration date'; // add new
    
        return $columns;
    
    }
    
    /*
    * Fill our new column with the registration dates of the users
    * @param string $row_output text/HTML output of a table cell
    * @param string $column_id_attr column ID
    * @param int $user user ID (in fact - table row ID)
    */

    public function gm_modify_user_table_row( $row_output, $column_id_attr, $user ) {
    
        $date_format = 'j M, Y H:i';
    
        switch ( $column_id_attr ) {
            case 'registration_date' :
                return date( $date_format, strtotime( get_the_author_meta( 'registered', $user ) ) );
                break;
            default:
        }
    
        return $row_output;
    
    }
    
    /*
    * Make our "Registration date" column sortable
    * @param array $columns Array of all user sortable columns {column ID} => {orderby GET-param} 
    */
    
    public function gm_make_registered_column_sortable( $columns ) {
        return wp_parse_args( array( 'registration_date' => 'registered' ), $columns );
    }
        

} // end class GM_TradeCustomer
$gm_tradecustomer = new GM_TradeCustomer();