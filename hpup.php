<?php
/**
 * Plugin Name:  Pop-up Homepage
 * Plugin URI: http://shawarma360.com/
 * Description: Plugin home page pop up open on home page when it close one time it show below pop up show
 * Version: 1.0
 * Author: weblinkindia pvt ltd
 * Author URI:  https://www.weblinkindia.net
 * Author Name:  subash chandra pandey
 */
  
	// Constants
	define( 'HPUP_ROOT_FILE', __FILE__ );
	define( 'HPUP_ROOT_PATH', dirname( __FILE__ ) );
	define( 'HPUP_ROOT_URL', plugins_url( '', __FILE__ ) );
	define( 'HPUP_PLUGIN_VERSION', '1.2.4');
	define( 'HPUP_PLUGIN_SLUG', basename( dirname( __FILE__ ) ) );
	define( 'HPUP_PLUGIN_BASE', plugin_basename( __FILE__ ) );
	define( 'HPUP_DB_TABLE', 'hpup_popup' );
		
 	include_once( HPUP_ROOT_PATH . '/includes/functions.php' ); 
	include_once( HPUP_ROOT_PATH . '/includes/ini.php' );	
 	include_once( HPUP_ROOT_PATH . '/views/admin.php' );  
	
	add_action( 'admin_menu', 'hpup_create_settings_page' );
  	add_action( 'admin_enqueue_scripts', 'hpup_load_scripts' ); 
	add_action( 'plugins_loaded', 'hpup_init' ); 
	add_action( 'wp_footer', 'hpup_popup' );	
	function hpup_function() {
?>
     <div id="pop_video_home_tray" style="bottom:0px;left:0px;width:10%;height:4%;background-color:#0080C0;color:#fff;font-weight:bold;font-size:14px;position:fixed;text-align:center;display:none;z-index:9999999;margin:auto;padding:auto;">Show</div>
<?
}
add_action('wp_head', 'hpup_function');

  	// Installation et initialisation seulement lors de l'installation du plugin
 	register_activation_hook( __FILE__, 'hpup_install' );
 	register_activation_hook( __FILE__, 'hpup_install_data' );
	register_uninstall_hook( __FILE__, 'hpup_uninstall' );
	 