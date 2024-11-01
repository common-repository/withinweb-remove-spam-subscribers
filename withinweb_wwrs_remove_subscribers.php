<?php

/*
Plugin Name: WithinWeb Remove Spam Subscribers
Plugin URI: http://www.withinweb.com/withinwebremovespam/
Description: Remove unwanted spam subscribers automatically using a CRON job  
Author: Paul Gibbs
Version: 1.0.7
Author URI:  https://www.withinweb.com/aboutus/
*/

if ( ! defined( 'ABSPATH' )  ) exit;

//--------------------------------------------------------------
//Activate the plugin
register_activation_hook(__FILE__, 'withinweb_wwrs_remove_subscribers_install' );

//--------------------------------------------------------------
//Deactivate the plugin
register_deactivation_hook(__FILE__, 'withinweb_wwrs_remove_subscribers_deactivate' );


//--------------------------------------------------------------
//Create the menus
add_action( 'admin_menu', 'withinweb_wwrs_remove_subscribers_menu' );


//--------------------------------------------------------------
//Create process hooks
add_action( 'admin_post_withinweb_wwrs_settings', 'withinweb_wwrs_cron_settings' );



//--------------------------------------------------------------
/**
* Create the menus
*/
function withinweb_wwrs_remove_subscribers_menu() {	
	//main menu
	add_menu_page( 'Remove Subscribers', 'Remove Subs', 'manage_options', __FILE__, 'withinweb_wwrs_remove_subscribers_help_page');	
	
	//sub menu
	add_submenu_page(__FILE__, 'Setting for Remove Subscribers', 'Settings', 'manage_options', __FILE__.'_settings', 'withinweb_wwrs_remove_subscribers_settings_page' );	
}


//----------------------------------------------------------------------
// Install plugin
function withinweb_wwrs_remove_subscribers_install() {
	if (version_compare( get_bloginfo( 'version' ), '3.1', '<' ) ) {
	
        	echo "<p>Plugin requires WordPress 3.1 or higher</p>";
        	exit;
	
			//deactivate_plugins( basename( __FILE__ ) );		//deactivate the plugin	
	}
	else
	{
		//Verifiy event has not been sheduled
		if (!wp_next_scheduled( 'withinweb_wwrs_cron_hook' ) ) {
		
			//Scheduled the event to run daily
			wp_schedule_event( time(), 'daily', 'withinweb_wwrs_cron_hook' );
			
			
			if ( get_option( 'withinweb_wwrs_cron_array' ) === false )
			{
      			$options_array['withinweb_wwrs_admin_toemail'] = '';
	      		$options_array['withinweb_wwrs_admin_fromemail'] = '';
		  		$options_array['withinweb_wwrs_debug'] = '';	  			
	      		add_option( 'withinweb_wwrs_cron_array', $options_array );
   			}	
			
			
		
		}
	}
}


//----------------------------------------------------------------------
// On deactivation, remove all functions from the scheduled action hook.
function withinweb_wwrs_remove_subscribers_deactivate() {
	wp_clear_scheduled_hook( 'withinweb_wwrs_cron_hook' );
	//delete_option('withinweb_wwrs_cron_array');	delete the options
}


//----------------------------------------------------------------------
//Create the function that actually removes the spam comments`using a hook
add_action( 'withinweb_wwrs_cron_hook', 'withinweb_wwrs_cron_remove_spam' );
	
	function withinweb_wwrs_cron_remove_spam() {			
	

		//Get settings	-----------------------------------	
		$options = get_option( 'withinweb_wwrs_cron_array' );
		
		$toemailaddress 	= $options[ 'withinweb_wwrs_admin_toemail' ];
		$fromemailaddress 	= $options[ 'withinweb_wwrs_admin_fromemail' ];
		$debugsetting 		= $options[ 'withinweb_wwrs_debug' ];		
	
		//validate values
		if ( ! is_email( $toemailaddress ) ) { 	wp_die("Error in to email address"); }		
		if ( ! is_email( $fromemailaddress ) ) { wp_die("Error in from email address"); }
		$safe_values = array( "true", "false" );
		if ( ! in_array( $debugsetting, $safe_values, true ) )
		{
			wp_die("Error in debugging setting");
		}
		//-------------------------------------------------
	
		global $wpdb;
		
		//------------------------------------------------------
		//First delete the users (subscribers only) who have no posts or comments and who registered more than 7 days ago
		$sql = " DELETE FROM " . $wpdb->prefix . "users 
		WHERE		
		ID IN (SELECT user_id FROM " . $wpdb->prefix ."usermeta WHERE meta_key = 
		'wp_capabilities' AND meta_value LIKE '%subscriber%')		
		AND		
		( DATEDIFF ( now(), user_registered ) > 7 )
		AND 
		ID NOT IN 
		( SELECT post_author FROM " . $wpdb->prefix . "posts UNION
		SELECT user_id FROM " . $wpdb->prefix . "comments ) ";
		
		/*
		//use for testing 
		SELECT * FROM wp_users WHERE ID IN (SELECT user_id FROM wp_usermeta WHERE meta_key = 'wp_capabilities' 
		AND meta_value LIKE '%subscriber%') AND	( DATEDIFF ( now(), user_registered ) > 7 )
		AND ID NOT IN ( SELECT post_author FROM wp_posts UNION 
		SELECT user_id FROM wp_comments )
		*/		
	
		$rows_affected = $wpdb->query( $sql	);		
	
		//send email only when number of records affected > 0
		if ($rows_affected > 0 && $debugsetting == "true")
		{
			$headers .= "From:$fromemailaddress\r\n";   //header with separater for headers
			wp_mail( "$toemailaddress", "CRON Remove Subscribers", "Number of records removed from table users: " . $rows_affected, $headers );
		}


		if ($rows_affected > 0)
		{		
			//------------------------------------------------------
			//Then delete the orphan records in wp_usermeta.
			$sql = " DELETE FROM " . $wpdb->prefix . "usermeta WHERE " . $wpdb->prefix . "usermeta.user_id NOT IN (SELECT ID from " . $wpdb->prefix ."users) ";
			$rows_affected = $wpdb->query( $wpdb->prepare( $sql ));
		}
		
	
	}
	

//==================================================================================================
/**
* Pages
*/
function withinweb_wwrs_remove_subscribers_settings_page() {
	if ( is_admin() )		//Check if admin user
	{
		//we are in wp-admin
		require (plugin_dir_path(__FILE__) .'views/adminsettings.php' );
	}

}
	
function withinweb_wwrs_remove_subscribers_help_page() {
	if ( is_admin() )		//Check if admin user
	{
		//we are in wp-admin
		require (plugin_dir_path(__FILE__) .'views/adminhelp.php' );
	}
}
		

//==================================================================================================
//Include any include files
include('scripts/process.php');			
		

?>