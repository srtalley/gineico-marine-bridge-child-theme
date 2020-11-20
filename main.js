//version: 1.2.1
jQuery(function($) {
  $(document).ready(function(){

    // Auto select an option if there is only one option for a product variation
    $( '.variations_form select' ).on( 'mouseout', function (event) {
      // Fires whenever variation selects are changed
      var counter = 1;
      $('.variations_form .variations select').each(function(){
          if(counter != 1) {
          var current_select_box = $(this);
          // get the values 
          var current_select_box_choices = $(this).children('option').length;
          if(current_select_box_choices == 2) {
            $(this).children('option').each(function(){
              current_select_option = $(this).val();
              if(current_select_option != '' && current_select_option != null ) {
                $(current_select_box).val(current_select_option).prop('selected', true);
              } 
            });
          }
        }
        $(this).trigger('change');
        counter++;
      });
    });

    // Add a wrapper for the search form elements
    if($('#search-filter-form-3789').length) {
      var result = [];
      var container = $('<ul class="search-bar-inner"></ul>');
      $('#search-filter-form-3789 .sf-field-search').each(function(){
        result.push($(this));
      });
  
      $('#search-filter-form-3789 .sf-field-reset').each(function(){
        result.push($(this));
      });
    
      $('#search-filter-form-3789 .sf-field-submit').each(function(){
        result.push($(this));
      });
      container.insertBefore(result[0]);
      for(i=0;i<result.length;i++)
      {
        result[i].appendTo(container);
      }
      $('.search-bar-inner').wrap('<li class="search-bar"></li>');

    }

    // Hide the add to cart button if the product is on backorder
    $( ".single_variation_wrap" ).on( "show_variation", function ( event, variation ) {

      var product_form = $(this).parentsUntil('.type-product');

      if(product_form.find('.woocommerce-variation-price .hide-price').length) {
        product_form.find('.woocommerce-product-details__short-description').addClass('remove-buttons');
      } else {
        product_form.find('.woocommerce-product-details__short-description').removeClass('remove-buttons');
      }
    } );

    // Show the calculate shipping form
    if($('.shipping-calculator-button').length) {
      $( '.shipping-calculator-form' ).slideToggle( 'slow' );
    }
    
    // Add a country label to the dropdown
    if($('.woocommerce-checkout').length) {
      $('#billing_country_field span.select2-selection__placeholder').text('Country');
      $('#shipping_country_field span.select2-selection__placeholder').text('Country');
    }
  });


});
