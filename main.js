//version: 2.6.9
jQuery(function($) {
    $(document).ready(function() {

        // Auto select an option if there is only one option for a product variation
        $('.variations_form select').on('mouseout', function(event) {
            // Fires whenever variation selects are changed
            var counter = 1;
            $('.variations_form .variations select').each(function() {
                if (counter != 1) {
                    var current_select_box = $(this);
                    // get the values 
                    var current_select_box_choices = $(this).children('option').length;
                    if (current_select_box_choices == 2) {
                        $(this).children('option').each(function() {
                            current_select_option = $(this).val();
                            if (current_select_option != '' && current_select_option != null) {
                                $(current_select_box).val(current_select_option).prop('selected', true);
                            }
                        });
                    }
                }
                $(this).trigger('change');
                counter++;
            });
        });
        $(window).load(function() {
            //Scrolling animation for anchor tags
            if (window.location.hash) {
                smooth_scroll_to_anchor_top($(window.location.hash));
            }
        }); // end window load 

        //check if an anchor was clicked and scroll to the proper place
        $('a[href*=\\#]').on('click', function() {
            if (this.hash != '') {
                if (this.pathname === window.location.pathname) {
                    smooth_scroll_to_anchor_top($(this.hash));
                }
            }
        });
        // scroll to the top of the anchor with an offset on desktops
        function smooth_scroll_to_anchor_top(anchor) {
            if ($(anchor) != 'undefined') {
                var window_media_query_980 = window.matchMedia("(max-width: 980px)")
                if (window_media_query_980.matches) {
                    var offset_amount = 0;
                } else {
                    var top_banner_height = $('.mtsnb-container-outer').first().height();
                    var main_header_height = $('header.centered_logo.page_header').first().height();
                    var admin_bar_height = $('#wpadminbar').height();
                    var offset_amount = top_banner_height + main_header_height;
                    if($('#wpadminbar').length) {
                        var admin_bar_height = $('#wpadminbar').height();
                        offset_amount = offset_amount + admin_bar_height;
                    }
                }
                $('html,body').animate({ scrollTop: ($(anchor).offset().top - offset_amount) + 'px' }, 1000);
            }
        } // end function



        // Add a wrapper for the search form elements
        if ($('#search-filter-form-3789').length) {
            var result = [];
            var container = $('<ul class="search-bar-inner"></ul>');
            $('#search-filter-form-3789 .sf-field-search').each(function() {
                result.push($(this));
            });

            $('#search-filter-form-3789 .sf-field-reset').each(function() {
                result.push($(this));
            });

            $('#search-filter-form-3789 .sf-field-submit').each(function() {
                result.push($(this));
            });
            container.insertBefore(result[0]);
            for (i = 0; i < result.length; i++) {
                result[i].appendTo(container);
            }
            $('.search-bar-inner').wrap('<li class="search-bar"></li>');

        }

        // Hide the add to cart button if the product is on backorder
        $(".single_variation_wrap").on("show_variation", function(event, variation) {

            var product_form = $(this).parentsUntil('.type-product');

            if (product_form.find('.woocommerce-variation-price .hide-price').length) {
                product_form.find('.woocommerce-product-details__short-description').addClass('remove-buttons');
            } else {
                product_form.find('.woocommerce-product-details__short-description').removeClass('remove-buttons');
            }
        });

        // Show the calculate shipping form
        if ($('.shipping-calculator-button').length) {
            $('.shipping-calculator-form').slideToggle('slow');
        }

        // Add a country label to the dropdown
        if ($('.woocommerce-checkout').length) {
            $('#billing_country_field span.select2-selection__placeholder').text('Country');
            $('#shipping_country_field span.select2-selection__placeholder').text('Country');
        }


        /**
         * Listen for the add to quote trigger and redirect to the request a quote page
         */

         $(document).bind( 'yith_wwraq_added_successfully', function(event, response, prod_id){

          $.ajax({
              type: 'POST',
              dataType: 'json',
              url: params.ajaxurl,
              data: {
                  'action': 'gm_check_is_quick_gyro_stabilizer',
                  'prod_id': prod_id,
                  'nonce': params.ajaxnonce,
              },
              success: function(data) {
                  console.log(data);
                  if(data.is_qgs == 'true') {
                    // append a div for the spinner
                    $('body').append('<div id="gm-add-to-quote-overlay" style="display: none;"></div>');
                    // show the spinner
                    $.blockUI({
                        message: $('#gm-add-to-quote-overlay'),
                        css: {
                            backgroundColor: 'transparent',
                            border: '0'
                        }
                    }); 
                    // redirect to the quote page
                    window.location.href = 'https://' + window.location.hostname + '/request-quote/';
                } 

              },
              error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + ' :: ' + textStatus + ' :: ' + errorThrown);
  
              }
          });

  
        });

    });


});