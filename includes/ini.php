<?php
// Installation du plugin  
   
  // Base de Données
  function hpup_install() {
	 global $wpdb;
	 
	 add_option( "hpup_db_version", HPUP_PLUGIN_VERSION );
  
	 $table_name = $wpdb->prefix . HPUP_DB_TABLE;
	 
	 $charset_collate = '';
	 if ( ! empty( $wpdb->charset ) ) {  
		 $charset_collate = "  CHARACTER SET {$wpdb->charset}";
	 }	
	 if ( ! empty( $wpdb->collate ) ) {
		$charset_collate .= " COLLATE {$wpdb->collate}";
	 }
	 
	 $sql = "CREATE TABLE $table_name (
			  id mediumint(9) NOT NULL AUTO_INCREMENT,
			  options mediumtext NULL,
			  titre tinytext NOT NULL,
			  text text NOT NULL,
			  hpup_key VARCHAR(55) DEFAULT '' NULL,
			  UNIQUE KEY id (id)
			  ) $charset_collate;";	  
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );		
	 
	 
	 
  }

  // Données initiales
  function hpup_install_data() {
	 global $wpdb;
	 $table_name = $wpdb->prefix . HPUP_DB_TABLE;
	 $result	 = $wpdb->get_results( "SELECT * FROM $table_name WHERE id = 1" );
	 
	 $titre		= ( empty( $result ) )? "GST Managment System": $result[0]->titre;
	 $text		= ( empty( $result ) )? __('Enter your text here','hpup_popup'): $result[0]->text;
	 $options 	= serialize( array("activate" 	=> '0',
	 							   "width" 		=> '350'
								  )
						   );
	 $options	= ( empty( $result ) )? $options: $result[0]->options;
	 $hpup_key 	= "";	 
	 $wpdb->replace( $table_name, 
	 				 array('id' => 1,
						   'options' => $options,
						   'titre' => $titre,
						   'text' => $text,
						   'hpup_key' => $hpup_key 
						  )
				    );
  }
  
  function hpup_init() {	   
	  load_plugin_textdomain('hpup_popup', false, HPUP_PLUGIN_SLUG . '/lang' );
	  if ( get_site_option( 'hpup_db_version' ) != HPUP_PLUGIN_VERSION ) {
		  hpup_install();
	  }
  }
  
  function hpup_uninstall(){
	   
	  //drop hpup_popup db table
	  global $wpdb;
	  $table_name = $wpdb->prefix . HPUP_DB_TABLE;
	  $wpdb->query( "DROP TABLE IF EXISTS $table_name " ); 
	  delete_option( 'hpup_db_version' );  
	  
  }
  
  
