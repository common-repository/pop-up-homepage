<?php   

// Ajout du popup sur la page d'accueil
 
  global $wpdb;
  $table_name = $wpdb->prefix . "hpup_popup";
  $result = $wpdb->get_results( "SELECT * FROM $table_name" );
  
  // Ajout des CSS et JS
  wp_enqueue_style( 'style-name', HPUP_ROOT_URL . '/css/hpup_popup.css' );
  wp_enqueue_script( 'script-name', HPUP_ROOT_URL . '/js/jquery.cookie.js', array(), '1.0.0', true); 
  wp_enqueue_script( 'script-name11', HPUP_ROOT_URL . '/js/hpup_popup.js', array(), '1.0.0', true );   
   		
	  
  // Récupération des options
  $options = unserialize( $result[0]->options );
  
  //Affichage du popup si activé dans l'admin 
  if( $options['activate'] ) {
	  
	  // Largeur minimum autorisée = 200
	  $max_width =  $options['width'] <= 199 ? '200': $options['width'];	
	  
	  // On remplace les retour charriot par des retour à la ligne  
	  $text = str_replace( CHR( 13 ) . CHR( 10 ), '<br/>', $result[0]->text );
	  
	  print '<div class="hpup-modal" tabindex="-1" role="dialog" id="my_home_video_pop" style="display: none;">
				<div class="hpup-modal-dialog" style="width:'.$max_width.'px;">
					<div class="hpup-modal-content">
						<div class="hpup-modal-header">
							<img class="hpup-close" src="' . HPUP_ROOT_URL . '/images/close_pop.png" title="' . __( 'Close Window','hpup_popup' ) . '" alt="Close" width="25" height="25"> 
						  	<h4 class="hpup-modal-title">' . $result[0]->titre . '</h4>
						</div>
						<div class="hpup-modal-body">          
						   ' . $text . '
						</div>
						<div class="hpup-modal-footer">';
						if ( ! empty( $options['label'] ) && ! empty( $options['link'] ) ) :
							print '<a href="' . $options['link'] . '" class="hpup-modal-link"><input type="button" class="button button-primary hpup-modal-label" value="' . $options['label'] . '" style=" cursor:pointer"></a>';
						endif;
						print '</div>
					</div><!-- /.hpup-modal-content --> 
				</div><!-- /.hpup-modal-dialog --> 
			</div>';
			 
			 
  }
  
 
  