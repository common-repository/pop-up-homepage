<?php

// Class hpup_popup pour l'admin

class hpup_popup {
	
	 
	public static function showOptionsPage( ) {
			 
		 global $wpdb;	
		 $table_name 	= $wpdb->prefix . HPUP_DB_TABLE;	 
		 $result		= $wpdb->get_results( "SELECT * FROM $table_name" );
		 $options 		= unserialize($result[0]->options);
		 
		 // Ajout des CSS et JS
 		 wp_enqueue_style( 'style-name', HPUP_ROOT_URL . '/css/hpup_popup.css' );
		 wp_enqueue_script( 'script-name', HPUP_ROOT_URL . '/js/hpup_popup.js', array(), '1.0.0', true );     
		 get_screen_icon( 'options-general' );  ?>

<div class="wrap">
  <div id="poststuff">
    <div id="post-body" class="metabox-holder columns-2"> 
      <!-- /post-body-content -->
      <form method="post" action="" enctype="multipart/form-data">
       <?php wp_nonce_field( 'name_of_my_action', 'name_of_nonce_field' ); ?>
        <div id="postbox-container-1" class="postbox-container">
          <div id="side-sortables" class="meta-box-sortables ui-sortable">
            <div id="postimagediv" class="postbox ">
              <div class="handlediv"><br>
              </div>
              <h3 class="hndle"><span><?php _e( 'Action', 'hpup_popup'); ?></span></h3>
              <div class="inside">
                <div class="misc-pub-section misc-pub-post-status">
                  <label for="post_status"><?php _e( 'Stat', 'hpup_popup'); ?>&nbsp;:</label>
                  <span id="post-status-display"><?php $options['activate'] == '1'? _e( 'Active', 'hpup_popup'): _e( 'Inactive', 'hpup_popup'); ?></span>
                  <div id="post-status-select">
                    <select name="activate" id="activate">
                      <option <?php echo $options['activate'] == '1'? 'selected="selected"':'';?> value="1">
                      <?php   _e('Active','hpup_popup') ?>
                      </option>
                      <option <?php echo $options['activate'] == '0'? 'selected="selected"':'';?>value="0">
                      <?php _e( 'Inactive', 'hpup_popup'); ?>
                      </option>
                    </select>
                  </div>
                  <p class="submit">
                    <input type="submit" name="hpup_popup_submit" id="hpup_popup_submit" class="button button-primary" value="<?php _e('Save','hpup_popup')?>">
                    <input type="button" name="hpup_popup_preview" id="hpup_popup_preview" class="button button-primary" value="<?php _e('Preview','hpup_popup')?>">
                  </p>
                  <p id="preview_help" class="description">
                    <?php _e('Preview is only available in text mode','hpup_popup')?>
                    .</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div id="postbox-container-2" class="postbox-container">
          <div id="normal-sortables" class="meta-box-sortables ui-sortable">
            <div id="team_metabox" class="postbox ">
              <div class="handlediv" title="Cliquer pour inverser."><br>
              </div>
              <h3 class="hndle"><span>Magneticlab Homepage Pop-up</span></h3>
              <div class="inside">
                <table class="form-table">
                  <tbody>
                    <tr valign="top">
                      <th scope="row"> <label for="popup_width">
                          <?php   _e('Width','hpup_popup') ?>
                        </label></th>
                      <td><input name="popup_width" type="text" id="popup_width" size="10" value="<?php echo $options['width'];?>" >
                        px (min 200px) </td>
                    </tr>
                    <tr valign="top">
                      <th scope="row"><label for="popup_titre">
                          <?php _e('Heading','hpup_popup')?>
                        </label></th>
                      <td><input name="popup_titre" type="text" id="popup_titre" value="<?php echo $result[0]->titre; ?>" class="regular-text"></td>
                    </tr>
                    <tr valign="top">
                      <th scope="row"><label for="popup_text">
                          <?php _e('Content','hpup_popup')?>
                        </label></th>
                      <td><?php wp_editor( $result[0]->text, 'popup_text', $settings = array('teeny' => true) ); ?></td>
                    </tr>
                    <tr valign="top">
                      <th scope="row"><label for="popup_text">
                          <?php _e('Call to action','hpup_popup')?>
                        </label></th>
                      <td><input name="popup_label" type="text" id="popup_label" value="<?php echo $options['label']; ?>" class="regular-text" placeholder="<?php _e('Label','hpup_popup')?>"> &nbsp;                        
                          <input name="popup_link" type="text" id="popup_link" value="<?php echo $options['link']; ?>" class="regular-text" placeholder="<?php _e('Link','hpup_popup')?> (http://www.example.com)"></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <!-- /post-body --> 
    
    <br class="clear">
    <p><span>Version <?php echo get_option( "hpup_db_version" ) ?></span> <?php printf(__('by %1$s | %2$s', 'hpup_popup'), '<strong>weblinkindia pvt. ltd.</strong>', '<strong><a href="http://www.weblinkindia.net" title="Web design lab">weblinkindia.net</a></strong>'); ?></p>
  </div>
</div>
<?php		
// Preview
// Largeur minimum autorisée = 200
$max_width =  $options['width'] <= 199? '200': $options['width'];	 

print '<div class="hpup-modal fades in "tabindex="-1" role="dialog" style="display: none;">
    <div class="hpup-modal-dialog" style="width:'.$max_width.'px;">
      <div class="hpup-modal-content">
        <div class="hpup-modal-header">
         <img class="hpup-close" src="' . HPUP_ROOT_URL . '/images/close_pop.png" title="' . __('Close Window','hpup_popup') . '" alt="Close" width="25" height="25"> 
          <h4 class="hpup-modal-title">'.$result[0]->titre.'</h4>
        </div>
        <div class="hpup-modal-body">  
        </div>
        <div class="hpup-modal-footer" style="display:none">
			<a href="" class="hpup-modal-link"><input type="button" class="button button-primary hpup-modal-label" value=""></a>
		</div>
      </div>
      <!-- /.modal-content --> 
    </div>
    <!-- /.modal-dialog --> 
  </div>';
	 }
	 
 }








