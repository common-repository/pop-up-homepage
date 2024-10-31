<?php include_once(ABSPATH . 'wp-includes/pluggable.php');
 // Mise à jour des données
 
  $hpup_error = false;
 
  function hpup_update_data() {
	  if(current_user_can( 'administrator' )){
		  
	  global $wpdb, $hpup_error; 
	  if (wp_verify_nonce( $_POST['name_of_nonce_field'], 'name_of_my_action' ))
	  {
	  $wpdb->show_errors();
	  $table_name		= $wpdb->prefix . HPUP_DB_TABLE;
	  $titre			= sanitize_text_field($_POST['popup_titre']);
	  $text				= get_magic_quotes_gpc() ? stripslashes(sanitize_text_field($_POST['popup_text'])) : sanitize_text_field($_POST['popup_text']);
	  $activate			= sanitize_text_field($_POST['activate'])?	sanitize_text_field($_POST['activate']):		null;
	  $width			= sanitize_text_field($_POST['popup_width'])?	sanitize_text_field($_POST['popup_width']):	'350';
	  $label			= sanitize_text_field($_POST['popup_label']);
	  $link				= sanitize_text_field($_POST['popup_link']);
	  if( ! empty( $link ) && ! filter_var( $link, FILTER_VALIDATE_URL ) ) {
		  $hpup_error = true; return false;
	  }
	  
	  

 
	  $options = serialize( array("activate" 	=> $activate,
	  							  "width" 		=> $width ,
								  "label" 		=> $label ,
								  "link" 		=> $link  
								  )
						   );
		 			   
	   $result =  $wpdb->update( $table_name, 
									array('titre' 		=> $titre,
									      'text' 		=> $text,										  
										  'options' 	=> $options 
										  ), 
									array( 'ID' => 1 ), 
									array( '%s', '%s', '%s' ), 
									array( '%s' ) 
							);
							
	  return $result;
	 
	  }
	  }
  }
  
  function hpup_message() { 
  
	  global $statut, $hpup_error; 
	  switch( $statut ){
		  case'success':
		  echo '<div id="message" class="updated"><p>' . __('Update  successful','hpup_popup') . '</p></div>';
		  break;
		  case'error':
		  echo '<div id="message" class="error"><p> ' . __('Unable to update','hpup_popup') . ' </p></div>'; 
		  break;
	  }
	  
	  if( $hpup_error )
	  echo '<div id="message" class="error"><p> ' . __( 'Your URL ist not valide.<br />
 		  Please provide a valide link. (http://www.example.com)','hpup_popup' ) . ' </p></div>'; 
	  
  }
  
  
  // Si le formulaire est posté
 
  if ( 
    ! isset( $_POST['name_of_nonce_field'] ) 
    || ! wp_verify_nonce( $_POST['name_of_nonce_field'], 'name_of_my_action' ) 
) {

global $hpup_settings_page;
	  
	  if ( function_exists( 'add_options_page' ) ) {
			 $page_title 	= 'Homepage Pop-up';
			 $menu_title 	= 'Homepage Pop-up';
			 $capability 	= 'manage_options';
			 $menu_slug 	= HPUP_PLUGIN_SLUG;
			 $function 		= array( 'hpup_popup','showOptionsPage' );
			 $hpup_settings_page =  add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function );
	  }

} else {
 $updateData =  sanitize_text_field($_POST['hpup_popup_submit'])? sanitize_text_field($_POST['hpup_popup_submit']): '';
   // process form data
}
   
  if( $updateData ) {
	  if( hpup_update_data() ) {
		  $statut = 'success';
		  add_action( 'admin_notices', 'hpup_message' );
	  } else {
		  $statut = 'error';
		  add_action( 'admin_notices', 'hpup_message' );
	  }  
  }
  
  
  // Interface admin  
  function hpup_create_settings_page() {
	  
	  global $hpup_settings_page;
	  
	  if ( function_exists( 'add_options_page' ) ) {
			 $page_title 	= 'Homepage Pop-up';
			 $menu_title 	= 'Homepage Pop-up';
			 $capability 	= 'manage_options';
			 $menu_slug 	= HPUP_PLUGIN_SLUG;
			 $function 		= array( 'hpup_popup','showOptionsPage' );
			 $hpup_settings_page =  add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function );
	  }
	  
  }
 
	  
  // Ajout des CSS et JS
  function hpup_load_scripts( $hook ) {
	  
	  global $hpup_settings_page; 
	   
	  if( $hook != 'settings_page_hpup_popup' ) return; 	  
	  wp_enqueue_style( 'style-name', HPUP_ROOT_URL . '/css/hpup_popup.css' );
	  wp_enqueue_script( 'custom-js', HPUP_ROOT_URL . '/js/hpup_popup.js' );
	  
  }
  
  
  // Ajout de la page popup sur le front si activé
  function hpup_popup(){
	  
	  // Seulement sur la page d'accueil
	  if ( is_home() || is_front_page() )
	  	include_once( HPUP_ROOT_PATH . '/views/popup.php' );
		
  } 
  
  
 


 