<div class="wrap">
        
	<?php if ( ! defined( 'ABSPATH' ) || !is_user_logged_in() ) exit;?>     
        
	<h2><strong>Settings for the Remove Spam Users Plugin</strong></h2>
	<p>This page provides you with the set up that is required to use the Plugin.</p>     
    
    <?php
        if ( isset( $_GET['m'] ) && $_GET['m'] == '1' )
        {
    ?>
           <div id='message' class='updated fade'><p><strong>You have successfully updated your settings.</strong></p></div>
    <?php
        }
    ?>    
    
    <?php
        if ( isset( $_GET['m'] ) && $_GET['m'] == '2' )
        {
    ?>
           <div id='message' class='error'><p><strong>Invalid email address - no data has been saved.</strong></p></div>
    <?php
        }
    ?>
    
    <?php $options = get_option( 'withinweb_wwrs_cron_array' ); ?>        
        
  	<h2><strong>Environment:</strong></h2>
  	<form method="post" action="admin-post.php" style="background-color:#CCC;padding-left:10px;">
    	<input type="hidden" name="action" value="withinweb_wwrs_settings" />
        <?php wp_nonce_field( 'withinweb_wwrs_op_verify', 'withinweb_wwrs_settings' ); ?>
    
       	<table class="form-table">
			<tbody>
                
            	<tr class="form-field form-required">
		        	<th scope="row"><label for="to_email_address">To email address <span class="description">(required)</span></label></th>
		    	    <td><input type="email" value="<?php echo esc_html( $options['withinweb_wwrs_admin_toemail'] ); ?>" id="to_email" name="to_email" style="width:240px;" ></td>
        		</tr>
                
            	<tr class="form-field form-required">
		        	<th scope="row"><label for="from_email_address">Admin email address <span class="description">(required)</span></label></th>
		    	    <td><input type="email" value="<?php echo esc_html( $options['withinweb_wwrs_admin_fromemail'] ); ?>" id="from_email" name="from_email" style="width:240px;" ></td>
        		</tr>
                
            	<tr class="form-field form-required">
		        	<th scope="row"><label for="debug_setting">Debug setting <span class="description"></span></label></th>
		    	    <td>

					<select id="debugsetting" name="debugsetting">           				
           				<option value="false" <?php echo esc_html($options['withinweb_wwrs_debug']) == 'false' ? 'selected="selected"' : ''; ?>>No</option>
                    	<option value="true" <?php echo esc_html($options['withinweb_wwrs_debug']) == 'true' ? 'selected="selected"' : ''; ?>>Yes</option>
          			</select>                
                    
                    </td>
        		</tr>
            
	  		</tbody>
		</table>
         
        <p class="submit">
        <input type="submit" value="Save Environment Settings" class="button-primary"/>
        </p>

  	</form>
    
        
</div>
