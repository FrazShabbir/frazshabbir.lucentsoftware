jQuery(document).ready(function($) {

    /***** Preview Shortcode Start ********/

    $('.wdo-preview-button').click(function(){
         $('.preview-container').toggle();
    });
    /***** Preview Shortcode End ********/

    $(window).load(function(){
       $('.se-pre-con').fadeOut();
       document.getElementById("plugin-alert").focus();
       $(".alert").addClass("animated infinite flash")
    });

    $('.wdo-hover-container').on('change', '.productsview', function(event) {
        event.preventDefault();
        if ($(this).val()==='woo-slider') {
            $(this).closest('.form-table').find('.slides-row').show();
            $(this).closest('.form-table').find('.grid-row').hide();
        } else if ($(this).val()==='grid'){
            $(this).closest('.form-table').find('.grid-row').show();
            $(this).closest('.form-table').find('.slides-row').hide();
        } else{
            $(this).closest('.form-table').find('.grid-row').hide();
            $(this).closest('.form-table').find('.slides-row').hide();
        }
    });

    $('.productsview').each(function(index, el) {
        if ($(this).val()==='woo-slider') {
            $(this).closest('.form-table').find('.slides-row').show();
            $(this).closest('.form-table').find('.grid-row').hide();
        } else if ($(this).val()==='grid'){
            $(this).closest('.form-table').find('.grid-row').show();
            $(this).closest('.form-table').find('.slides-row').hide();
        } else{
            $(this).closest('.form-table').find('.grid-row').hide();
            $(this).closest('.form-table').find('.slides-row').hide();
        }
    });

    setTimeout(function() {
        jQuery('.wdo-hover-container .group').first().addClass('firstelement');
    }, 40);


    var sCounter = Math.floor(1000 + Math.random() * 9000);

    function create_accordian(str) {
        $( str )
            .accordion({
                header: '> div > h3',
                autoHeight: true,
                collapsible: true
            })
            .sortable({
                axis: 'y',
                handle: 'h3',
                stop: function( event, ui ) {
                    // IE doesn't register the blur when sorting
                    // so trigger focusout handlers to remove .ui-state-focus
                    ui.item.children( 'h3' ).triggerHandler( 'focusout' );
                }
            });
    }
    create_accordian('.accordion');

    jQuery('.contentcolor,.woobordercolor,.woocontentbg,.woosalebadgebg,.wootitlebg').wpColorPicker(); 
    

    // Cloning Add More Images 

    jQuery('.wdo-hover-container').on('click', '.addnewgroup', function() { 
            jQuery('.addnewgroup').parents().find('.wdo-hover-container').find('h3:last').css({
                'background': '',
                'color': ''
            });
            var parent = jQuery(this).closest('.category-clone');
            var content = jQuery(this).parents().find('.category-clone > .group:first').clone(true).removeClass('firstelement').appendTo(parent);
            content.find('button.fullshortcode').attr('id', sCounter);
            jQuery(this).parents().find('.category-clone > .group:last').find('h3:first').text('New Group').css({
                'background': '#37cee5',
                'color': '#fff'
            });

            console.log(sCounter);

            jQuery('.accordian').accordion('refresh'); 

    });

    // Removing Category
    jQuery('.wdo-hover-container').on('click', '.removegroup', function(event) {

      if (jQuery(this).closest('.wdo-hover-container > .accordion > .group').hasClass('firstelement')) {
            alert('You can not delete first group.');
        } else {
            if (confirm("Are you sure you want to delete this group?")) {
                var selector = jQuery(this).closest('.wdo-hover-container > .accordion > .group');
                selector.hide('slow', function(){ selector.remove(); });
                jQuery(".accordion").accordion('refresh');
            }
            return false;
            
        }  
    }); 

    jQuery('.head-color,.desc-color,.capbgcolor,.headingbg,.leftbordercolor,.rightbordercolor,.capbordercolor').wpColorPicker();  

    jQuery('.wdo-hover-container').on('click', '.save-meta', function(event) {
        event.preventDefault();     
        jQuery('.se-saved-con').show();
         jQuery('#la-saved').hide();
        var allcats = [];  
          jQuery('.group').each(function(index,val) {
            var cats = {};
            cats.group_name = jQuery(this).find('.groupname').val();
            cats.product_category = jQuery(this).find('.productcategory').val();
            cats.images_per_row = jQuery(this).find('.imagesperrow').val();
            cats.product_hover_effect = jQuery(this).find('.producthovereffect').val();
            cats.animation_direction = jQuery(this).find('.animationdirection').val();
            cats.shortcode = jQuery(this).find('.fullshortcode').attr('id');
            allcats.push(cats);
        });
        var data = {
            action : 'wdo_save_woohover_options',
            nonce: laAjax.nonce,
            posts : allcats       
        } 

         jQuery.post(laAjax.url, data, function(resp) {
            window.location.reload(true);
            jQuery('.se-saved-con').hide();
            jQuery('.overlay-message').show();
            jQuery('.overlay-message').delay(2000).fadeOut();
        });
          
    });

    jQuery('.wdo-hover-container .group').on('click','button.fullshortcode',function(event) {
        event.preventDefault();
        prompt("Copy and use this Shortcode", '[woo-hover-effects id="'+jQuery(this).attr('id')+'"]');
    });

    jQuery('.enableprev').click(function() {

        jQuery(this).siblings('.preview').toggle();
    });

});
