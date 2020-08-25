<?php
	session_start();
    include 'lib/MobileDetect.php';
    $detect = new Mobile_Detect();

    $spanfontsize = "18px/24px";
    //if ($detect->isMobile())
    //    $spanfontsize = "32px/40px";
?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" >
<!-- saved from url=(0014)about:internet -->
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>Sherpin Feedback</title>
    <link rel="stylesheet" type="text/css" href="css/metro.css" />
    <script type="text/javascript" src="/script/utils.js"></script>
    <script type="text/javascript" src="/script/metro_list.js"></script>
    <script type="text/javascript" src="/script/metro_user.js"></script>
    <script type="text/javascript" src="https://connect.facebook.net/en_US/all.js"></script>
    <script type="text/javascript" src="/script/cookies.js"></script>

    <link media="screen" rel="stylesheet" href="lib/colorbox.css" />
    <script src="lib/jquery-latest.min.js" type="text/javascript"></script>
    <script src="lib/jquery.colorbox-min.js" type="text/javascript"></script>

    <script type="text/javascript">
        function checksession() {
            <?php
                if (isset($_SESSION["USER_ID"])) {
                    echo "USERID = " . $_SESSION["USER_ID"] . ";";
                }
                else {
                    echo "USERID = -1;";
                }
                if (isset($_SESSION["USER_NAME"])) {
                    echo "USERNAME = '" . $_SESSION["USER_NAME"] . "';";
                }
                else {
                    echo "USERNAME = '';";
                }
            ?>
        }
    </script>
</head>

<body>
    <?php include "/var/www/sherpa_fb.php" ?>
	<?php include "/var/www/sherpa_header.php" ?>

	<div style="color:#aaaaaa;margin:20px;overflow:auto;word-wrap:break-word;height:80%">
	<h1>Sherpin.com Privacy Policy</h1>
	
	<p>Sherpin.com knows that you care about how your personal information is used and shared, and we take your privacy very 
	seriously. Please read the following to learn more about our privacy policy.</p>
	<p>This Privacy Policy describes the policies and procedures of Sherpin.com, Inc. ("we" or "us") on the collection, use 
	and disclosure of your information on http://www.Sherpin.com.com and the related services, features, content or applications 
	we offer (collectively, "Sherpin.com"). In connection with your use of Sherpin.com, we receive information about you from 
	various sources, including: (i) through your Sherpin.com user account (your "Account"); (ii) your use of Sherpin.com generally; 
	and (iii) from third party websites and services. When you use Sherpin.com, you are consenting to the collection, transfer, 
	manipulation, storage, transmission, disclosure and other uses of your information as described in this Privacy Policy.</p>
	
	<h2>What Does This Privacy Policy Cover?</h2>
	<p>This Privacy Policy covers the treatment of personally identifiable information ("Personal Information") we gather when 
	you are using or accessing Sherpin.com. This Privacy Policy also covers our treatment of any Personal Information that our 
	business partners share with us or that we share with our business partners.</p>
	<p>This Privacy Policy does not apply to the practices of third parties that we do not own or control, including but not 
	limited to any third party websites, content sources, services and applications ("Third Party Services") that you elect to 
	access through Sherpin.com, or to individuals that we do not manage or employ. While we attempt to facilitate access only to 
	those Third Party Services that share our respect for your privacy, we cannot take responsibility for the content or privacy 
	policies of those Third Party Services. We encourage you to carefully review the privacy policies of any Third Party Services 
	you access.</p>
	
	<h2>What Information Is Collected by Sherpin.com?</h2>
	<p>The information we gather enables us to personalize, improve and continue to operate Sherpin.com. In connection with certain 
	aspects of Sherpin.com, we may request, collect and/or display some of your Personal Information. We collect the following types 
	of information from our users.</p>
	
	<h3>Sign-In Information:</h3>
	<p>When you create an Account or login using your Twitter and/or Facebook credentials, you will provide information that could 
	be Personal Information, such as your username, password and email address. You acknowledge that this information may be personal 
	to you, and by creating an account with Sherpin.com and providing Personal Information to us, you allow others, including us, to 
	identify you and therefore may not be anonymous. We may use your contact information to send you information about our Services, 
	including without limitation, notifications regarding the Services and, upon your request, email digests of content shared by 
	those that you follow on Sherpin.com, Twitter, and Facebook. You may unsubscribe from these messages through your Account settings, 
	although we regardless reserve the right to contact you when we believe it is necessary, such as for account recovery purposes.</p>
	
	<h3>User Content and URL Information:</h3>
	<p>Sherpin.com allows you to provide content to Sherpin.com, such as the ability to Sherpin.com and Submit collections of content 
	and uniform resource locators ("URLs"), written descriptions of content or URLs, comments, text, images and video. We also collect 
	and store information regarding the content in your Sherpin.com, Twitter, and Facebook feeds and the original URL, and associate 
	that information with your Account. We also collect and store (i) the time and date on which the content was first submitted, 
	or shared and (ii) information on the channels through which the content was shared, e.g., to other Sherpin.com users, Twitter 
	followers, and/or Facebook friends.</p>
	<p>We share certain information about you, such as your username, any avatar or image you elect to post, your Twitter and/or 
	Facebook username, your reading feeds through Sherpin.com, Twitter, Facebook and other Third Party Services, and other information 
	you elect to make public to your followers in Sherpin.com, your followers on Twitter, and your friends on Facebook,. This may 
	include Personal Information, but only to the extent that you decide to share such information with others.</p>
	<p>We may retain content submitted by you to Sherpin.com indefinitely, even after you terminate your Account.</p>
	
	<h3>Metrics and Analytics:</h3>
	<p>We collect information about accesses of content curated through Sherpin.com. This information includes, but is not limited 
	to: (i) the IP address and physical location of the devices accessing the curated content; (ii) the time and date of each access; 
	and (iii) information about sharing of curated content.</p>
	
	<h3>Information Collected From Third Party Services:</h3>
	<p>Some features of Sherpin.com allow you to share your Sherpin.com curated content through Third Party Services and your content 
	from Third Party Services through Sherpin.com. If you choose to connect Sherpin.com to such Third Party Services, we may collect 
	information related to your use of those Third Party Services, such as authentication tokens that allow us to connect to your Third 
	Party Service accounts. We may otherwise collect information about how you are using Sherpin.com to interact with those connected 
	Third Party Services. Note that Third Party Services may have the ability to restrict the information that is provided to us.</p>
	
	<h3>IP Address Information and Other Information Collected Automatically:</h3>
	<p>We automatically receive and record information from the Sherpin.com application or your web browser when you interact with 
	Sherpin.com, Including your IP address and cookie information. This information is used to facilitate collection of data concerning 
	your interaction with Sherpin.com (e.g., what content you have clicked on).</p>
	<p>Generally, Sherpin.com automatically collects usage information, such as the number and frequency of users accessing Sherpin.com 
	and various curated streams of content. We may use this data in aggregate form, that is, as a statistical measure, but not in a 
	manner that would identify you personally. This type of aggregate data enables us and third parties authorized by us to figure out 
	how often individuals use parts of Sherpin.com so that we can analyze and improve them.</p>
	
	<h3>Information Collected Using Cookies:</h3>
	<p>Cookies are pieces of text that may be provided to your computer through your web browser or application when you access a 
	website or service. Your browser stores cookies in a manner associated with each website or service you visit. We use cookies 
	to enable our servers to recognize your web browser or Sherpin.com application and tell us how and when you visit and use 
	Sherpin.com through the web or through an application.</p>
	<p>Sherpin.com cookies also allow us to track when you have accessed content through Sherpin.com. Each access is tracked using 
	a unique identifier assigned to you in one or more cookies stored by your web browser or application and associated with 
	Sherpin.com.</p>
	<p>Sherpin.com cookies do not, by themselves, contain Personal Information, and we do not combine the general information 
	collected through cookies with other Personal Information to tell us who you are. As noted, however, we do use cookies to 
	identify that your web browser or application has accessed content through Sherpin.com and may associate that information 
	with your Account if you have one.</p>
	<p>This Privacy Policy covers our use of cookies only and does not cover the use of cookies by third parties. We do not control 
	when or how third parties place cookies on your computer or device. For example, third party websites may set their own cookies.</p>
	
	<h3>Aggregate Information:</h3>
	<p>We collect statistical information about how people use Sherpin.com ("Aggregate Information"). Some of this information is derived 
	from Personal Information, such as your location (which, in turn, can be derived from your IP address or through location based 
	services used by your device). This statistical information is not Personal Information and cannot be tied back to you, your Account, 
	your web browser or your Sherpin.com application.</p>
	
	<h2>How and To Whom Is My Information Shared?</h2>
	<p>Sherpin.com is designed to help you share information that you or people you choose to follow locate on the web with others. As 
	a result, much of the information generated through Sherpin.com is shared publicly or with third parties. All Sherpin.com content 
	is public. Your activity on the Sherpin.com network is public and can be distributed to anyone that follows you. We may also distribute 
	content and feeds through an email digest to users who have elected to receive such email digests.</p>
	
	<h3>Public Sherpin.com Activity Information:</h3>
	<p>Much of your activity on and through Sherpin.com is public by default. This includes, but is not limited to:<br>
	URLs within your feeds from Third Party Services that you access through Sherpin.com and feeds from third parties 
	that you elect to follow.<br>
	Content that you have selected to curate on your Account, the corresponding URL(s), the time and date that content was curated, 
	and metrics and analytics information for your curated content, as described above; and<br>
	Aggregate non-personal information about what content you have accessed through Sherpin.com and associated metrics and analytics 
	information, as described above.<br>
	</p>
	<p>Some of this information may be associated with your Account and some of this information is publicly accessible to other 
	Sherpin.com users who choose to follow your curated content. This information may still be accessible through other means, such 
	as our API services.</p>
	<p>Please also remember that if you choose to provide Personal Information using certain features of Sherpin.com, then that 
	information is governed by the privacy settings of those particular features and may be publicly available. Individuals reading 
	this information may use or disclose it to other individuals or entities without our control and without your knowledge. Therefore, 
	we urge you to think carefully about including any specific information you may deem private in content that you create or submit 
	through Sherpin.com.</p>
	
	<h3>Information You Elect to Share:</h3>
	<p>In addition to reviewing this Privacy Policy, you should also review the terms of services and privacy policies of any Third 
	Party Services that you access through Sherpin.com. Sherpin.com respects the privacy settings/ policies that you have selected 
	with Third Party Services, and only shares information consistent with those privacy settings and policies.</p>
	<p>You may otherwise access Third Party Services through Sherpin.com, for example by accessing curated content. We are not 
	responsible for the privacy policies and/or practices of these Third Party Services, and you are responsible for reading and 
	understanding those privacy policies. This Privacy Policy only governs information collected on or through Sherpin.com.</p>
	
	<h3>User Profile Information:</h3>
	<p>User profile information including your username, avatars or images you elect to upload and other information you enter may 
	be displayed to other users to facilitate user interaction within Sherpin.com. We will not directly reveal users' email addresses 
	to other users.</p>
	
	<h3>Aggregate Information:</h3>
	<p>We share Aggregate Information with our partners, service providers and other persons with whom we conduct business. We share 
	this type of statistical data so that our partners can understand how and how often people use Sherpin.com and their services or 
	websites, which facilitates improving both their services and how we interface with them. In addition, these third parties may share 
	with us non-private, aggregated or otherwise non Personal Information about you that they have independently developed or acquired.</p>
	
	<h3>Information Shared with Our Agents:</h3>
	<p>We employ and contract with people and other entities that perform certain tasks on our behalf and who are under our control (our 
	"Agents"). We may need to share Personal Information with our Agents in order to provide products or services to you. Unless we tell 
	you differently, our Agents do not have any right to use Personal Information or other information we share with them beyond what is 
	necessary to assist us. You hereby consent to our sharing of Personal Information with our Agents.</p>
	
	<h3>Information Disclosed Pursuant to Business Transfers:</h3>
	<p>In some cases, we may choose to buy or sell assets. In these types of transactions, user information is typically one of the 
	transferred business assets. Moreover, if we, or substantially all of our assets associated with Sherpin.com, were acquired, or 
	in the unlikely event that we go out of business or enter bankruptcy, user information would be one of the assets that is transferred 
	or acquired by a third party. You acknowledge that such transfers may occur, and that any acquirer of us may continue to use your 
	Personal Information as set forth in this policy.</p>
	
	<h3>Information Disclosed for the Protection of Us and Others:</h3>
	<p>We also reserve the right to access, read, preserve, and disclose any information as it reasonably believes is necessary to 
	(i) satisfy any applicable law, regulation, legal process or governmental request, (ii) enforce these Terms of Service, including 
	investigation of potential violations hereof, (iii) detect, prevent, or otherwise address fraud, security or technical issues, 
	(iv) respond to user support requests, or (v) protect our rights, property or safety, our users and the public. This includes exchanging 
	information with other companies and organizations for fraud protection and spam prevention.</p>
	
	<h3>Information We Share With Your Consent:</h3>
	<p>Except as set forth above, you will be notified when your Personal Information may be shared with third parties, and will be able to 
	prevent the sharing of this information.</p>
	
	<h3>Email Communications:</h3>
	<p>If you sign up for The Daily Sherpin.com email via the Sherpin.com website or in any other Sherpin.com application, you will receive 
	an email once daily summarizing popular content on Sherpin.com. Sherpin.com users that follow you will occasionally receive email digests 
	that include information about what you have shared through Sherpin.com.</p>
	<p>Regardless of whether you decide to receive The Daily Sherpin.com, as part of Sherpin.com, you may occasionally receive from us email 
	and other communication relating to your Account. These emails will only be sent for purposes important to Sherpin.com, such as 
	password recovery.</p>
	<p>We may receive a confirmation when you open an email from us. We use this confirmation to improve our customer service.</p>
	
	<h2>Is Information About Me Secure?</h2>
	<p>Your Account information (including your Twitter and Facebook logins) is protected for your privacy and security. You need 
	to prevent unauthorized access to your account and Personal Information by selecting and protecting your password appropriately 
	and limiting access to your computer and browser by signing off after you have finished accessing your account.</p>
	<p>We endeavor to protect Account information to ensure that it is kept private; however, we cannot guarantee the security of any 
	Account information. Unauthorized entry or use, hardware or software failure, and other factors, may compromise the security of user 
	information at any time.</p>
	<p>We otherwise store all of our information, including your IP address information, using industry-standard security techniques. We 
	do not guarantee or warrant that such techniques will prevent unauthorized access to information about you we store, Personal 
	Information or otherwise.</p>
	
	<h2>What Information of Mine Can I Access?</h2>
	<p>You can access information associated with your Account by logging into the web version of Sherpin.com, or through the Sherpin.com 
	application. You can adjust settings and privacy preferences through your Account settings.</p>
	<p>Registered and unregistered users can access all of the above information.</p>
	
	<h2>How Can I Delete My Account?</h2>
	<p>Should you ever decide to delete your Account, you may do so by visiting Sherpin.com.com/settings or by visiting Account Settings in 
	the Sherpin.com iPhone application. If you terminate and delete your Account, any association between your Account and information 
	stored by in connection with Sherpin.com will no longer be accessible. However, given the nature of sharing using Sherpin.com, any 
	public activity on your Account prior to deletion will remain stored on our servers and will remain accessible to the public. If you 
	would like us to remove such stored information, please send us an email at 
	<a href="mailto:support@sherpin.com" style="color:#ededed">support@Sherpin.com</a>.</p>
	
	<h2>What Choices Do I Have Regarding My Information?</h2>
	<p>As stated previously, you can opt not to disclose certain information to us, even though it may be needed to take advantage of 
	some Sherpin.com features.</p>
	<p>You can delete your Account or adjust your Account's privacy settings. Please note that we will need to verify that you have the 
	authority to delete the Account, and activity generated prior to deletion will remain stored by us and may be publicly accessible.</p>
	
	<h2>What Happens When There Are Changes to this Privacy Policy?</h2>
	<p>We may amend this Privacy Policy from time to time. Use of information we collect now is subject to the Privacy Policy in effect 
	at the time such information is used. If we make changes in the way we collect or use information, we will notify you by posting an 
	announcement on or within Sherpin.com or sending you an email. A user is bound by any changes to the Privacy Policy when he or she uses 
	Sherpin.com after such changes have been first posted.</p>
	
	<h2>What If I Have Questions or Concerns?</h2>
	<p>If you have any questions or concerns regarding privacy using Sherpin.com, please send us a detailed message to: 
	<a href="mailto:support@sherpin.com" style="color:#ededed">support@Sherpin.com</a>. 
	We will make every effort to resolve your concerns.</p>
	
	<h3>Effective Date: July 31, 2012</h3>
	</div>

	<script>checkcookie();</script>
</body>
</html>
