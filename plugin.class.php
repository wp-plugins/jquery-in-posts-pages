<?php 
/**
* Main Class of this plugin for saving jquery for each post
*/
class jQuery_in_Posts_Pages
{
	
	function __construct()
	{
		add_action( 'add_meta_boxes', array($this, 'wcp_script_box') );
		add_action( 'save_post', array($this, 'wcp_saving_custom_js') );
		add_action( 'wp_footer', array($this, 'enque_scripts_here') );
	}

	function wcp_script_box(){
		add_meta_box( 'WCP_script', 'jQuery or JavaScript', array($this, 'wcp_script_cb'), '', 'normal', 'default' );
	}

	function wcp_script_cb(){
		$wcp_meta = get_post_custom($post->ID);
		$wcp_js_code = $wcp_meta['wcp_custom_script'][0];
		echo '<div class="wp-editor-container"><textarea class="wp-editor-area" name="wcp_custom_script">'.$wcp_js_code.'</textarea></div>';
	}

	function wcp_saving_custom_js($post_id){

		$wcpd_script = sanitize_text_field( $_POST['wcp_custom_script'] );		

		if (isset($wcpd_script)) {
			update_post_meta( $post_id, 'wcp_custom_script', $wcpd_script );
		}
	}

	function enque_scripts_here(){
		if (!is_singular()) {
			return;
		}
		$wcp_meta = get_post_custom($post->ID);
		$wcp_js_code = $wcp_meta['wcp_custom_script'][0];
		echo '<script>jQuery(document).ready(function($) {'.$wcp_js_code.'});</script>';		
	}
}
?>