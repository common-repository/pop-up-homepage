// hpup_popup.js v1.0.0, 15.12.2014
// Copyright (c) 2014 Magneticlab (http://www.magneticlab.ch)

jQuery(document).ready(function($){
	
	jQuery('#preview_help').hide();	
	
	if($.cookie('my_home_video_pop')==null){
		$('#my_home_video_pop').show();
		$('#pop_video_home_tray').hide();
		
	}else{
		$('#pop_video_home_tray').show();
	}
	
	$('#pop_video_home_tray').mouseover(function(){
		$(this).css({'cursor':'pointer'});	
	}).click(function(e){
		$(this).hide();
		$('#my_home_video_pop').show();
	});
	
/*	if ( jQuery( "#wp-popup_text-wrap" ).hasClass( "tmce-active" ) ) {
		 jQuery( '#hpup_popup_preview' ).prop('disabled', true); 
		 jQuery( '#preview_help' ).show();		
	}*/
							   		   
	//Close Popups and Fade Layer
	jQuery( '.hpup-close' ).on( 'click', function() {
		//When clicking on the close or fade layer...
		$.cookie('my_home_video_pop',true);
		$('#pop_video_home_tray').show();
	  	jQuery( '.hpup-modal' ).fadeOut( function() {
			 jQuery( '#hpup-modal-backdrops' ).hide();  
		}); //fade them both out		
		return false;
	});
	
	// Preview function in admin page
	jQuery('#hpup_popup_preview').on('click', function() { 
		//reset
		jQuery('.hpup-modal-title').html('');
		jQuery('.hpup-modal-body').html('');
		jQuery('.hpup-modal-label').val('');
		jQuery('.hpup-modal-link').attr("href", "#")
		jQuery( '.hpup-modal-footer' ).hide();
		//get		
		var titre = jQuery('#popup_titre').attr( 'value' );
		var text  = jQuery('#popup_text').val(); 
		var width = jQuery('#popup_width').attr( 'value' ); 
		var label = jQuery('#popup_label').attr( 'value' ); 
		var url = jQuery('#popup_link').attr( 'value' );  
		//set
		if ( url.length > 0 && label.length > 0){ 
			jQuery( '.hpup-modal-footer' ).show(); 			
		}
		jQuery('.hpup-modal-title').html( titre );
		jQuery('.hpup-modal-body').html( text ); 
		jQuery('.hpup-modal-dialog').css( "width", width+'px' );
		jQuery('.hpup-modal-label').val(label);
		jQuery('.hpup-modal-link').attr("href", url) 
		jQuery('.hpup-modal').fadeIn(); 
	}); 
	
	if ( jQuery( '#hpup_popup_preview' ).is( ':disabled' ) == true ){ 
			jQuery( '#hpup_popup_preview' ).prop( 'disabled', false );
			jQuery( '#preview_help' ).hide(); 	
		}
	
	// Preview only available on text editor	
	jQuery('#popup_text-tmce').on('click', function() {			 
		if ( jQuery('#hpup_popup_preview').is(':disabled') == false ){ 
			jQuery('#hpup_popup_preview').prop('disabled', true); 
			jQuery('#preview_help').show();	
		} 
	}); 
	
	// Preview only available on text editor	
	jQuery('#popup_text-html').on('click', function() {		 
		if ( jQuery( '#hpup_popup_preview' ).is( ':disabled' ) == true ){ 
			jQuery( '#hpup_popup_preview' ).prop( 'disabled', false );
			jQuery( '#preview_help' ).hide();
		} 
	}); 
	
	// Preview image from new src in admin page
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			
			reader.onload = function (e) {
				jQuery("#preview_image").attr("src", e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	jQuery("#popup_img").change(function(){
		readURL(this);
	});
	
});


