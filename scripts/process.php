<?php

if ( ! defined( 'ABSPATH' ) ) exit;

//--------------------------------------------------------
//Environment settings
function withinweb_wwrs_cron_settings()
{
	
   if ( !current_user_can( 'manage_options' ) )
   {
      wp_die( 'You are not allowed to be on this page.' );
   }

   // Check the nonce field
   if (!check_admin_referer( 'withinweb_wwrs_op_verify', 'withinweb_wwrs_settings' ))
   {
	   //echo("error in referer");
	   exit();
   }
   
   $options = get_option( 'withinweb_wwrs_cron_array' );

   if ( isset( $_POST['to_email'] ) )
   {
		//Sanitize the email
      	$options['withinweb_wwrs_admin_toemail'] = sanitize_email( $_POST['to_email'] );
   }

   if ( isset( $_POST['from_email'] ) )
   {
  		//Sanitize the email
      	$options['withinweb_wwrs_admin_fromemail'] = sanitize_email( $_POST['from_email'] );
   }

   if ( isset( $_POST['debugsetting'] ) )
   {
	   	//Sanitize the text field
		$debugsetting = sanitize_text_field( $_POST['debugsetting'] );
		if ($debugsetting == "true")
			{
		      	$options['withinweb_wwrs_debug'] = "true";
			}
			else
			{
		      	$options['withinweb_wwrs_debug'] = "false";	
			}
   }

	//Get plug in base name
	$pluginfolder = str_replace( '/scripts', '',  dirname(plugin_basename(__FILE__)) );			

   	update_option( 'withinweb_wwrs_cron_array', $options );	
	wp_redirect(  admin_url( 'admin.php?page=' . $pluginfolder . '/withinweb_wwrs_remove_subscribers.php_settings&m=1' ) );
   	exit;
	
}

?>