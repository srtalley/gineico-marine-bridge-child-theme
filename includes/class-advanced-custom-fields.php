<?php 

namespace GineicoMarine\Theme;

class GM_Advanced_Custom_Fields {

  
    public function __construct() {

        add_action('plugins_loaded', array($this, 'gm_create_group_custom_taxonomy_images'));
        add_action('plugins_loaded', array($this, 'gm_create_group_product_catalogue_taxonomny'));
        add_action('plugins_loaded', array($this, 'gm_create_group_product_category_images'));
        add_action('plugins_loaded', array($this, 'gm_create_group_product_price_quote_items'));
        add_action('plugins_loaded', array($this, 'gm_create_group_products_pdf_files'));

    } // end function construct


    /**
     * Add Custom Taxonomy Images group
     */
    public function gm_create_group_custom_taxonomy_images() {
        if( function_exists('acf_add_local_field_group') ) {

            acf_add_local_field_group(array(
                'key' => 'group_5e8691fd877aa',
                'title' => 'Custom Taxonomy Images',
                'fields' => array(
                    array(
                        'key' => 'field_5e86920c13c6e',
                        'label' => 'Thumbnail',
                        'name' => 'thumbnail',
                        'type' => 'image',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'array',
                        'preview_size' => 'thumbnail',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => '',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'taxonomy',
                            'operator' => '==',
                            'value' => 'gm_icons',
                        ),
                    ),
                    array(
                        array(
                            'param' => 'taxonomy',
                            'operator' => '==',
                            'value' => 'gm_brands',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => true,
                'description' => '',
            ));
        } //end if function_exists('acf_add_local_field_group')  
    } // end function gm_create_group_custom_taxonomy_images

    /**
     * Add Product Catalogue Taxonomy group
     */
    public function gm_create_group_product_catalogue_taxonomny() {
        if( function_exists('acf_add_local_field_group') ) {
            acf_add_local_field_group(array(
                'key' => 'group_5e93e9d2188d4',
                'title' => 'Product Catalogue Taxonomy',
                'fields' => array(
                    array(
                        'key' => 'field_5e93ea136472c',
                        'label' => 'Catalogue File (PDF, PNG, JPG)',
                        'name' => 'catalogue_file',
                        'type' => 'file',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'array',
                        'library' => 'all',
                        'min_size' => '',
                        'max_size' => '',
                        'mime_types' => 'pdf, png, jpg',
                    ),
                    array(
                        'key' => 'field_5e93efc1ee3f9',
                        'label' => 'Catalogue Link Text',
                        'name' => 'catalogue_link_text',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => 'Catalogue Download',
                        'placeholder' => 'Catalogue Download – Catalogue Name',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'taxonomy',
                            'operator' => '==',
                            'value' => 'gm_catalogue',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => true,
                'description' => '',
            ));
        } //end if function_exists('acf_add_local_field_group')  

    } // end function gm_create_group_product_catalogue_taxonomny
    /**
     * Add Product Category Images group
     */
    public function gm_create_group_product_category_images() {
        if( function_exists('acf_add_local_field_group') ) {
        acf_add_local_field_group(array(
            'key' => 'group_5e966ef92b443',
            'title' => 'Product Category Images',
            'fields' => array(
                array(
                    'key' => 'field_5e966f01863eb',
                    'label' => 'Category Header Image',
                    'name' => 'category_header_image',
                    'type' => 'image',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'library' => 'all',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'taxonomy',
                        'operator' => '==',
                        'value' => 'product_cat',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));
        } //end if function_exists('acf_add_local_field_group')  

    } // end function gm_create_group_product_category_images
    /**
     * Add Product Price & Quote Items group
     */
    public function gm_create_group_product_price_quote_items() {
        if( function_exists('acf_add_local_field_group') ) {
        acf_add_local_field_group(array(
            'key' => 'group_5ebb66a980a77',
            'title' => 'Product Price & Quote Items',
            'fields' => array(
                array(
                    'key' => 'field_5ebb66ba5bcb8',
                    'label' => 'Hide Add to Cart Button',
                    'name' => 'hide_add_to_cart_button',
                    'type' => 'true_false',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'message' => 'Hide the add to cart button for this specific product',
                    'default_value' => 0,
                    'ui' => 0,
                    'ui_on_text' => '',
                    'ui_off_text' => '',
                ),
                array(
                    'key' => 'field_5ecc46a61ccb0',
                    'label' => 'Hide Price',
                    'name' => 'hide_price',
                    'type' => 'true_false',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'message' => 'Hide the price on the product page and in the shop. The price is still displayed in the cart and at checkout.',
                    'default_value' => 0,
                    'ui' => 0,
                    'ui_on_text' => '',
                    'ui_off_text' => '',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'product',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));
        } //end if function_exists('acf_add_local_field_group')  

    } // end function gm_create_group_product_price_quote_items
    /**
     * Add Products PDF Files group
     */
    public function gm_create_group_products_pdf_files() {
        if( function_exists('acf_add_local_field_group') ) {
        acf_add_local_field_group(array(
            'key' => 'group_5bbe75339e188',
            'title' => 'Products PDF Files',
            'fields' => array(
                array(
                    'key' => 'field_5b6fe6c979553',
                    'label' => 'Product Details',
                    'name' => 'product_details',
                    'type' => 'file',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'library' => 'all',
                    'return_format' => 'array',
                    'min_size' => 0,
                    'max_size' => 0,
                    'mime_types' => '',
                ),
                array(
                    'key' => 'field_5b6fe6d179556',
                    'label' => 'Product Details Link Text',
                    'name' => 'product_details_link_text',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => 'PDF Data Sheet',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5b6fe6c879552',
                    'label' => 'Installation Instructions',
                    'name' => 'installation_instructions',
                    'type' => 'file',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'library' => 'all',
                    'return_format' => 'array',
                    'min_size' => 0,
                    'max_size' => 0,
                    'mime_types' => '',
                ),
                array(
                    'key' => 'field_5b6fe6d079555',
                    'label' => 'Installation Instructions Link Text',
                    'name' => 'installation_instructions_link_text',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => 'Installation Instructions',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'html',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5b6fe6c879551',
                    'label' => 'Photometry',
                    'name' => 'photometry',
                    'type' => 'file',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'library' => 'all',
                    'return_format' => 'array',
                    'min_size' => 0,
                    'max_size' => 0,
                    'mime_types' => '',
                ),
                array(
                    'key' => 'field_5b6fe6cf79554',
                    'label' => 'Photometry Link Text',
                    'name' => 'photometry_link_text',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => 'Photometry',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'html',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5cb6d831ca6e8',
                    'label' => 'DWG File',
                    'name' => 'dwg_file',
                    'type' => 'file',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'array',
                    'library' => 'all',
                    'min_size' => '',
                    'max_size' => '',
                    'mime_types' => 'dwg',
                ),
                array(
                    'key' => 'field_5cc89a501d2ee',
                    'label' => 'DWG File Link Text',
                    'name' => 'dwg_file_link_text',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => 'DWG File',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5e86c7e7d3a1d',
                    'label' => 'PNG File',
                    'name' => 'png_file',
                    'type' => 'file',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'array',
                    'library' => 'all',
                    'min_size' => '',
                    'max_size' => '',
                    'mime_types' => 'png',
                ),
                array(
                    'key' => 'field_5e86c807d3a1e',
                    'label' => 'PNG File Link Text',
                    'name' => 'png_file_link_text',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => 'PNG File',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5e86c81ad3a20',
                    'label' => 'DXF File',
                    'name' => 'dxf_file',
                    'type' => 'file',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'array',
                    'library' => 'all',
                    'min_size' => '',
                    'max_size' => '',
                    'mime_types' => 'dxf',
                ),
                array(
                    'key' => 'field_5e86c819d3a1f',
                    'label' => 'DXF File Link Text',
                    'name' => 'dxf_file_link_text',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => 'DXF File',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'product',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));
        } //end if function_exists('acf_add_local_field_group')  

    } // end function gm_create_group_products_pdf_files

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

$gm_advanced_custom_fields = new GM_Advanced_Custom_Fields();