<?php
// Application: Dynamic Acquisition of Media Based on User Preferences
// 

require_once 'facebook/facebook.php';

$appapikey = '8d9772759e7d51fe8222a92620c7fbe9';
$appsecret = 'b1f890fc0401981f46fcbee945dc5be1';

$facebook = new Facebook($appapikey, $appsecret);
$user_id = $facebook->require_login();
?>

<img src="/Images/mymediaguide_logo.JPG" height="50%" width="50%"></img>

<fb:tabs>
	<fb:tab-item href="https://apps.facebook.com/mediabup/index.php" title="Media" selected="false" />
	<fb:tab-item href="https://apps.facebook.com/mediabup/invite.php" title="Send Invitations" selected="false" />
	<fb:tab-item href="https://apps.facebook.com/mediabup/preferences.php" title="Set User Preferences" selected="false" />
	<fb:tab-item href="https://apps.facebook.com/mediabup/comments.php" title="Provide Feedback" selected="true" />
</fb:tabs>

<fb:comments xid="mediabup_comments" canpost="true" candelete="false" returnurl="https://apps.facebook.com/mediabup">
	<fb:title>Please offer any feedback you have on the sherpin.com application</fb:title> 
</fb:comments>