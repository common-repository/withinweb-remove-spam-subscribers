<div class="wrap">
       
    <?php if ( ! defined( 'ABSPATH' ) || !is_user_logged_in() ) exit;?>
    
	<div style="width:500px">
	
	<h2><strong>About the Remove Spam Users using a CRON job</strong></h2>     
          
	<p>This plugin deletes users from your system who have a role of subscriber and who have made no 
                  contributions of a post or a comment and who registered more that 7 days ago.  A delay of 
                  7 days is included to allow time for the registered user to make their comment.</p>
                   
	<p>A scheduled job runs every 7 days and checks for those type of users and deletes them.</p>
                   
	<p>WordPress has 5 default roles of: 
		
	 <ul>
		 <li>Admininstrator - has access to all adminstrative options and features.</li>
		 <li>Editor - can manage and publish posts.</li>
		 <li>Author - can publish their own posts.</li>
		 <li>Contributer - can write posts but cannot publish them.</li>
		 <li>Subscriber - has basic functionality such as leaving comments and changing their profile.  This is usually the
		 default role that a registered user will have.</li>
	</ul>                 
                  
	<p>This script specifically targets subscribers as it is those that create comments.</p>
                   
    <p>For details of the plugin refer to web site https://www.withinweb.com/withinwebremovespam/</p>
    
	</div>
	
</div>