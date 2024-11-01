=== Remove Unwanted Subscribers ===
Contributors: paulvgibbs
Donate link:  https://www.paulvgibbs.com/donation-button/
Tags: Subscribers, spam subscribers, cron job, remove subscribers, spam users
Requires at least: 3.0.1
Tested up to: 5.3
Stable tag: 1.0.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Remove unwanted users automatically using a CRON Job.


== Description ==

Do you get subscribers that register with your WordPress site but never post any comments.  These are probably spam subscribers where someone has set up an automated piece of software to create these users.  

They are a real menace and you can often tell if they are spam by looking at the email address and the registered name.  Usually there is no relationship between the person's name and the email address.

This short plugin will delete the subscriber 7 days after registering if they have not posted a comment or not submitted a post and have a role of subscriber.  A delay of 7 days is included to allow time for the registered user to make their comment.

A scheduled job runs every day and checks for those type of users and deletes them.
                   
WordPress has 5 default roles of: 
* Admininstrator - has access to all adminstrative options and features.
* Editor - can manage and publish posts.
* Author - can publish their own posts.
* Contributer - can write posts but cannot publish them.
* Subscriber - has basic functionality such as leaving comments and changing their profile. This is usually the default role that a registered user will have.
                  
This script specifically targets subscribers as it is those that create comments.
                   
For details of the plugin refer to web site http://www.withinweb.com/withinwebremovespam/

It uses a WordPress type CRON job to automatically run each day, hence once installed you don't have to do anything.

You can set a debugging mode which will send out an email each time that a user is removed.


== Installation ==

This section describes how to install the plugin and get it working.

1. Upload withinweb remove subscribers to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. In the 'Settings' menu, you can enter an email address to send debugging information which will be run whenever a user is deleted.
4. To test, create a new user with a type of 'subscriber'.
5. In the settings page, set debugging to 'Yes' and put in valid email addresses.
6. After 7 days you should get an email that says your user has been deleted.
7. You may also want to create a user with type of 'editor' and you should see that this user is not deleted after 7 days.
8. Another test is to create a user with role of subscriber, create a post or comment by that user.  After 7 days the user should not have been deleted.


== Frequently Asked Questions ==

= Can you change the duration of the CRON job =

At the moment the only way would be to change the duration is editing the main code.  It is currently set to 7 days.


== Screenshots ==

1. screenshot-1.png shows the set up screen.  Setting the debug setting to Yes and entering the email address will send an email each time the CRON job is run.


== Changelog ==

== 1.0.6 ==
Minor text changes.

== 1.0.7 ==
Minor text changes.



