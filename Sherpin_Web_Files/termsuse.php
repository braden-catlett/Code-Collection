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
	<title>Sherpin Terms of Use</title>
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
	<h1>Sherpin.com Terms of Use</h1>
	
	<p>Please read these Terms of Use (collectively with the Sherpin.com Privacy Policy and Sherpin.com 
	DMCA Copyright Policy, the "Terms of Use") fully and carefully before using http://www.Sherpin.com 
	and the services, features, content and applications offered in connection with Sherpin.com (collectively, 
	"Sherpin.com") by News.me, Inc. ("we" or "us"). These Terms of Use set forth the legally binding terms and 
	conditions for your use of Sherpin.com.</p>
	
	<ol type="1">
		<li><b>Acceptance of terms</b></li>
		<ol type="a">
			<li>By registering for and/or using Sherpin.com in any manner, including but not limited to 
			downloading and using the Sherpin.com application, you agree to these Terms of Use and all 
			other operating rules, policies and procedures that may be published from time to time on or 
			within Sherpin.com, each of which is incorporated by reference and each of which may be updated 
			from time to time without notice to you.</li>
			<li>These Terms of Use apply to all users of Sherpin.com, including, without limitation, users 
			who are contributors of content, information, and other materials or services, registered or 
			otherwise.</li>
		</ol>
		<li><b>Modification. </b>We reserve the right, at our sole discretion, to modify or replace any of 
		these Terms of Use, or change, suspend, or discontinue Sherpin.com (including without limitation, 
		the availability of any feature, database, or content) at any time by posting a notice on or within 
		Sherpin.com or by sending you notice through Sherpin.com or by e-mail. We may also impose limits on 
		certain features of Sherpin.com or restrict your access to parts or all of Sherpin.com without notice 
		or liability. It is your responsibility to check these Terms of Use periodically for changes. Your use 
		of Sherpin.com following the posting of any changes to these Terms of Use constitutes acceptance of 
		those changes.</li>
		<li><b>Eligibility. </b>You represent and warrant that you are at least 13 years of age. If you are 
		under age 13, you may not, under any circumstances, use Sherpin.com. We may, at our sole discretion, 
		refuse to offer Sherpin.com to any person or entity and change our eligibility criteria at any time. 
		You are solely responsible for ensuring that these Terms of Use are in compliance with all laws, rules 
		and regulations applicable to you and the right to access Sherpin.com is revoked where these Terms of 
		Use or use of Sherpin.com is prohibited or to the extent offering, sale or provision of Sherpin.com 
		conflicts with any applicable law, rule or regulation. Further, Sherpin.com is offered only for your 
		use, and not for the use or benefit of any third party.</li>
		<li><b>Login/Registration. </b>While some features of Sherpin.com are available to unregistered users, 
		for broader access to Sherpin.com you must login using your Twitter or Facebook login or, if offered by 
		Sherpin.com, register with Sherpin.com by creating an "Account". If registration is made available, you 
		must provide accurate information included on the registration page. You are responsible for updating 
		the accuracy of the information that you provide to us to be associated with your Account. Regarding 
		usernames, you shall not (i) select or use, as your username, the name of another person with the intent 
		to impersonate that person; (ii) select or use, as your username, a name subject to any rights of a person 
		or entity other than you without appropriate authorization or (iii) select or use, as your username, a name 
		that is otherwise offensive, vulgar or obscene.</b>
		<li><b>Account Security. </b>You are solely responsible for the activity that occurs on your Account, and 
		for keeping the password for your Account secure. You are not permitted to use another Account without 
		permission. You must notify us immediately of any breach of security or other unauthorized use of your 
		Account. You should never publish, distribute or post login information for your Account.</li>
		<li><b>Access Rights. </b>Without limiting any other terms of these Terms of Use, by using Sherpin.com 
		you understand and agree that we, as an agent on your behalf, may access content from third party 
		websites and services so that it is available to you through use of Sherpin.com, and you give Sherpin.com 
		permission to do so. You agree that any content that you submit to a Third Party Service, such as Twitter 
		or Facebook, may be stored by us at your direction, although we do not undertake any obligations to maintain 
		such submissions.</li>
		<li><b>Content.</b>
		<ol type="a">
			<li><b>Definition. </b>For purposes of these Terms of Use, the term "Content" includes, without limitation, 
			URLs, curated URLs, content, videos, audio clips, written posts and comments, information, data, text, web 
			pages, images, software, scripts, graphics, and interactive features generated, provided, or otherwise made 
			accessible on or through Sherpin.com.</li>
			<li><b>Third Party Materials and Agreements. </b>You may be able to access, download, store or use Third 
			Party Services, resources, content or information ("Third Party Materials") via Sherpin.com. By using the 
			Sherpin.com to find and collect material on the Internet, you instruct us to present portions of the data 
			sources that you have selected. You acknowledge sole responsibility for and assume all risk arising from 
			your access to or use of any such Third Party Materials and we disclaim any liability that you may incur 
			arising from your access to or use of such Third Party Materials or User Content (defined below) via a 
			Sherpin.com. You acknowledge and agree that we: (i) are not responsible for the availability or accuracy 
			of such Third Party Materials or the products or services on or available from such Third Party Materials; 
			(ii) have no liability to you or any third party for any harm, injuries or losses suffered as a result of 
			your access to or use of such Third Party Materials; and (iii) do not make any promises to remove Third 
			Party Materials from being accessed through Sherpin.com. Your ability to access or link to Third Party 
			Materials or third party services does not imply any endorsement by us of Third Party Materials or any 
			such third party services.</li>
			<li><b>User Content. </b>All Content added, created, uploaded, curated, submitted, distributed, or posted 
			to Sherpin.com by users, whether publicly posted or privately transmitted (collectively "User Content"), 
			is the sole responsibility of the user who originated it. You acknowledge that all Content accessed by you 
			using Sherpin.com is at your own risk and you will be solely responsible for any damage or loss to you or 
			any other party resulting therefrom. When you delete your User Content, it will be removed from Sherpin.com. 
			However, you understand that (i) certain User Content will remain available and (ii) any removed User Content 
			may persist in backup copies for a reasonable period of time (but will not following removal be shared with 
			others).</li>
			<li><b>Our Content. </b>Sherpin.com contains Content specifically provided by us or our partners and such 
			Content is protected by copyrights, trademarks, service marks, patents, trade secrets or other proprietary 
			rights and laws. You shall abide by and maintain all copyright notices, information, and restrictions contained 
			in any Content accessed through Sherpin.com.</li>
			<li><b>Use License. </b>Subject to these Terms of Use, we grant each user of Sherpin.com a worldwide, 
			non-exclusive, non-sublicensable and non-transferable license to use, download, store, display and print 
			the Content, solely for personal, non-commercial use as part of using Sherpin.com. Use, reproduction, 
			modification, distribution or storage of any Content for other than personal, non-commercial use is expressly 
			prohibited without prior written permission from us, or from the copyright holder identified in such Content's 
			copyright notice. You may not use Sherpin.com for any commercial purposes.</li>
			<li><b>Content License Grants.</b>
			<ol type="i">
				<li><b>License to Us. </b>By submitting User Content through Sherpin.com, you hereby do and shall grant us 
				a worldwide, non-exclusive, royalty-free, fully paid, sublicensable and transferable license to use, edit, 
				modify, reproduce, distribute, prepare derivative works of, transmit, stream, display, perform, and 
				otherwise fully exploit the User Content in connection with Sherpin.com and our (and its successors 
				and assigns') business, including without limitation for promoting and redistributing part or all of 
				Sherpin.com, Content posted on Sherpin.com, and derivative works thereof, or Sherpin.com in any media 
				formats and through any media channels (including, without limitation, third party websites and feeds).</li>
				<li><b>License to Users. </b>You also hereby do and shall grant each user of Sherpin.com a non-exclusive 
				license to access, use, download, store, transmit, stream, display, perform and print your User Content 
				through Sherpin.com, and to use, edit, modify, reproduce, distribute, prepare derivative works of, display 
				and perform such User Content.</li>
				<li><b>No Infringement. </b>You represent and warrant that you have all rights to grant such licenses 
				without infringement or violation of any third party rights, including without limitation, any privacy 
				rights, publicity rights, copyrights, contract rights, or any other intellectual property or proprietary 
				rights.</li>
			</ol>
			<li><b>Availability of Content. </b>We do not guarantee that any Content will be made available on or through 
			Sherpin.com. Further, we have no obligation to monitor Sherpin.com. However, we reserves the right to (i) remove, 
			edit or modify any Content in our sole discretion, at any time, without notice to you and for any reason (including, 
			but not limited to, upon receipt of claims or allegations from third parties or authorities relating to such Content 
			or if we are concerned that you may have violated these Terms of Use), or for no reason at all and (ii) remove or 
			block any Content from Sherpin.com.</li>
		</ol>
		</li>
		<li><b>Sherpin.com Application License.</b>
			<ol type="a">
				<li><b>License Grant. </b>Subject to your compliance with the terms and conditions of these Terms of Use, we 
				grant to you a limited, non-exclusive, non-transferable license, without the right to sublicense, to download 
				and install the Sherpin.com application on up to 10 devices that you own and control and run such cop(ies) of 
				the Sherpin.com application solely for your internal personal use. You acknowledge that new versions of the 
				Sherpin.com application may be provided at additional charge. Furthermore, with respect to any Sherpin.com 
				application downloaded through the iTunes App Store, you will only use such application as permitted by the 
				"Usage Rules" set forth in the Apple App Store Terms of Service. We reserve all rights in the Sherpin.com 
				application not expressly granted to you in these Terms of Use.</li>
				<li><b>Restrictions. </b>Except as expressly specified in these Terms of Use, you shall not (i) copy or modify 
				the Sherpin.com application, including, but not limited to adding new features or otherwise making adaptations 
				that alter the functioning of the Sherpin.com application; (ii) transfer, sell, rent, lease, distribute, sublicense 
				or otherwise assign any rights to, or any portion of, the Sherpin.com application to any third party; or (iii) make 
				the functionality of the Sherpin.com application available to multiple users through any means, including, but not 
				limited to distribution of the Sherpin.com application or by uploading the Sherpin.com application to a network or 
				file-sharing service or through any hosting, application services provider or any other type of service. The 
				Sherpin.com application contains trade secrets, and in order to protect those secrets you agree not to disassemble, 
				decompile or reverse engineer the Sherpin.com application, in whole or in part, or permit or authorize a third 
				party to do so, except to the extent such restrictions are expressly prohibited by statutory law. You will comply 
				with any technical restrictions in the Sherpin.com application that allow you to use the Sherpin.com application 
				only in certain ways.</li>
				<li><b>Updates and Upgrades; No Obligation. </b>We are not obligated to maintain or support the Sherpin.com 
				application, or to provide you with updates, upgrades or services related thereto. You acknowledge that 
				Sherpin.com may from time to time in its sole discretion issue updates or upgrades to the Sherpin.com application, 
				and may automatically update or upgrade the version of the Sherpin.com application that you are using on your 
				mobile device. You consent to such automatic updating or upgrading on your mobile device, and agree that the 
				terms and conditions of these Terms of Use will apply to all such updates or upgrades.</li>
				<li><b>U.S. Government Users. </b>The Sherpin.com application and related documentation are "commercial items" 
				as that term is defined in FAR 2.101, consisting of "commercial computer software" and "commercial computer 
				software documentation," respectively, as such terms are used in FAR 12.212 and DFARS 227.7202. If the Sherpin.com 
				application and related documentation are being acquired by or on behalf of the U.S. Government, then, as provided 
				in FAR 12.212 and DFARS 227.7202-1 through 227.7202-4, as applicable, the U.S. Government's rights in the Sherpin.com 
				application and related documentation will be only those specified in these Terms of Use.</li>
				<li><b>Export Control. </b>You may not use, export, re-export, import, or transfer the Sherpin.com application except 
				as authorized by United States law, the laws of the jurisdiction in which you obtained the Sherpin.com application, 
				and any other applicable laws or regulations. In particular, but without limitation, the Sherpin.com application may 
				not be exported or re-exported (i) into any United States embargoed countries or (ii) to anyone on the U.S. Treasury 
				Department's list of Specially Designated Nationals or the U.S. Department of Commerce's Denied Person's List or Entity 
				List. By using the Sherpin.com application, you represent and warrant that you are not located in any such country or 
				on any such list. You also will not use the Sherpin.com application for any purpose prohibited by U.S. law, including 
				the development, design, manufacture or production of missiles, nuclear, chemical or biological weapons.</li>
				<li><b>iTunes App Store. </b>You agree to the Apple iTunes Terms of Service if you download the Sherpin.com 
				application from the iTunes App Store.</li>
			</ol>
			</li>
		<li><b>Rules of Conduct.</b>
			<ol type="a">
			<li>You promise not to use Sherpin.com for any purpose that is prohibited by these Terms of Use. You are responsible 
			for all of your activity in connection with Sherpin.com.</li>
			<li>You shall not, and shall not permit any third party to, either (i) take any action or (ii) upload, download, post, 
			submit or otherwise distribute or facilitate distribution of any Content (including User Content) on or through Sherpin.com 
			that:
				<ol type="i">
				<li>infringes any patent, trademark, trade secret, copyright, right of publicity or other right of any other person 
				or entity or violates any law or contractual duty (the Sherpin.com DMCA Copyright Policy); ii. is unlawful, such as 
				content that is threatening, abusive, harassing, defamatory, libelous, fraudulent, invasive of another's privacy, or 
				tortuous;</li>
				<li>constitutes unauthorized or unsolicited advertising, junk or bulk e-mail ("spamming");</li>
				<li>contains software viruses or any other computer codes, files, or programs that are designed or intended to disrupt, 
				damage, limit or interfere with the proper function of any software, hardware, or telecommunications equipment or to 
				damage or obtain unauthorized access to any system, data, password or other information of us or any third party;</li>
				<li>impersonates any person or entity, including any of our employees or representatives;</li>
				<li>includes anyone's identification documents or sensitive financial information; or</li>
				<li>is otherwise determined by us to be inappropriate at its sole discretion.</li>
				</ol>
			</li>
			<li>You shall not: (i) take any action that imposes or may impose (as determined by us in our sole discretion) an unreasonable 
			or disproportionately large load on our (or our third party providers') infrastructure; (ii) interfere or attempt to interfere 
			with the proper working of Sherpin.com or any activities conducted on Sherpin.com; (iii) bypass any measures we may use to 
			prevent or restrict access to Sherpin.com (or other accounts, computer systems or networks connected to Sherpin.com); 
			(iv) run any form of auto-responder or "spam" on Sherpin.com; (v) use manual or automated software, devices, or other processes 
			to "crawl" or "spider" any web pages associated with Sherpin.com, or any third party web pages accessed through Sherpin.com; 
			(vi) harvest or scrape any Content from Sherpin.com; or (vii) otherwise take any action in violation of our guidelines and policies.</li>
			<li>You shall not (directly or indirectly): (i) decipher, decompile, disassemble, reverse engineer or otherwise attempt to 
			derive any source code or underlying ideas or algorithms of any aspect, feature or part of Sherpin.com, except to the limited 
			extent applicable laws specifically prohibit such restriction; (ii) modify, translate, or otherwise create derivative works 
			of any part of Sherpin.com; or (iii) copy, rent, lease, distribute, or otherwise transfer any of the rights that you receive
			hereunder. You shall abide by all applicable local, state, national and international laws and regulations. You will comply 
			with any technical restrictions of Sherpin.com that allow you to use Sherpin.com only in certain ways.</li>
			<li>We also reserve the right to access, read, preserve, and disclose any information as it reasonably believes is necessary 
			to (i) satisfy any applicable law, regulation, legal process or governmental request; (ii) enforce these Terms of Use, including 
			investigation of potential violations hereof; (iii) detect, prevent, or otherwise address fraud, security or technical issues; 
			(iv) respond to user support requests; or (v) protect our rights, property or safety, or that of our users and the public. This 
			includes exchanging information with other companies and organizations for fraud protection and spam prevention.</li>
		</ol>
		</li>
		<li><b>Third Party Services. </b>Sherpin.com may permit you access content from or to link to other websites, services or 
		resources on the Internet, and those other websites, services or resources may contain links to Sherpin.com. When you access 
		third party resources on the Internet, you do so at your own risk. These other resources are not under our control and you 
		acknowledge that we are not responsible or liable for the content, functions, accuracy, legality, appropriateness or any other 
		aspect of such websites or resources. Such inclusion does not imply endorsement by us or any association with our operators. You 
		further acknowledge and agree that we shall not be responsible or liable, directly or indirectly, for any damage or loss caused 
		or alleged to be caused by or in connection with the use of or reliance on any such Content, goods or services available on or 
		through any such website or resource.</li>
		<li><b>Termination. </b>We may terminate your access to all or any part of Sherpin.com at any time, with or without cause, with 
		or without notice, effective immediately, which may result in the forfeiture and destruction of all information associated with 
		your Account. If you wish to terminate your Account, you may do so by following the instructions in your Account settings. All 
		provisions of these Terms of Use which by their nature should survive termination shall survive termination, including without 
		limitation, ownership provisions, warranty disclaimers, indemnity and limitations of liability.</li>
		<li><b>Warranty Disclaimer.</b>
			<ol type="a">
			<li>We have no special relationship with or fiduciary duty to you. You acknowledge that we have no control over, and no 
			duty to take any action regarding:
				<ol type="i">
				<li>which users gains access to Sherpin.com;</li>
				<li>what Content you access via Sherpin.com;</li>
				<li>what effects the Content may have on you;</li>
				<li>how you may interpret or use the Content; or</li>
				<li>what actions you may take as a result of having been exposed to the Content.</li>
				</ol>
			</li>
			<li>You release us from all liability for you having acquired or not acquired Content through Sherpin.com. The Services 
			may contain, or direct you to websites containing, information that some people may find offensive or inappropriate. We 
			make no representations concerning any Content contained in or accessed through Sherpin.com, and it will not be 
			responsible or liable for the accuracy, copyright compliance, legality or decency of material contained in or accessed 
			through Sherpin.com.</li>
			<li>SHERPIN.COM AND ALL CONTENT ARE PROVIDED "AS IS", "AS AVAILABLE" AND WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, 
			INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF TITLE, NON-INFRINGEMENT, MERCHANTABILITY AND FITNESS FOR A 
			PARTICULAR PURPOSE, AND ANY WARRANTIES IMPLIED BY ANY COURSE OF PERFORMANCE OR USAGE OF TRADE, ALL OF WHICH ARE EXPRESSLY 
			DISCLAIMED. WE, AND OUR DIRECTORS, EMPLOYEES, AGENTS, SUPPLIERS, PARTNERS AND CONTENT PROVIDERS DO NOT WARRANT THAT: 
			(I) SHERPIN.COM WILL BE SECURE OR AVAILABLE AT ANY PARTICULAR TIME OR LOCATION; (II) ANY DEFECTS OR ERRORS WILL BE 
			CORRECTED; (III) ANY CONTENT OR SOFTWARE AVAILABLE AT OR THROUGH SHERPIN.COM IS FREE OF VIRUSES OR OTHER HARMFUL COMPONENTS; 
			OR (IV) THE RESULTS OF USING SHERPIN.COM WILL MEET YOUR REQUIREMENTS. YOUR USE OF SHERPIN.COM IS SOLELY AT YOUR OWN RISK. 
			SOME STATES DO NOT ALLOW LIMITATIONS ON IMPLIED WARRANTIES, SO THE FOREGOING LIMITATIONS MAY NOT APPLY TO YOU.</li>
			<li>ELECTRONIC COMMUNICATIONS PRIVACY ACT NOTICE (18 USC 2701-2711): WE MAKE NO GUARANTY OF CONFIDENTIALITY OR PRIVACY OF 
			ANY COMMUNICATION OR INFORMATION TRANSMITTED ON THE SERVICES OR ANY WEBSITE LINKED TO THE SERVICES. We will not be liable 
			for the privacy of e-mail addresses, registration and identification information, disk space, communications, confidential 
			or trade-secret information, or any other Content stored on our equipment, transmitted over networks accessed by Sherpin.com, 
			or otherwise connected with your use of Sherpin.com.</li>
			</ol>
		</li>
		<li><b>Indemnification. </b>You shall defend, indemnify, and hold harmless us, our affiliates and each of their respective 
		employees, contractors, directors, suppliers and representatives from all liabilities, claims, and expenses, including reasonable 
		attorneys' fees, that arise from or relate to your use or misuse of, or access to, Sherpin.com, Content, or which otherwise arise 
		from your User Content, violation of these Terms of Use, or infringement by you, or any third party using your Account, of any 
		intellectual property or other right of any person or entity. We reserve the right to assume the exclusive defense and control 
		of any matter subject to indemnification by you, in which event you will assist and cooperate with us in asserting any available 
		defenses.</li>
		<li><b>Limitation of Liability. </b>IN NO EVENT SHALL WE, OUR AFFILIATES NOR ANY OF THEIR RESPECTIVE DIRECTORS, EMPLOYEES, 
		CONTRACTORS, AGENTS, PARTNERS, SUPPLIERS, REPRESENTATIVES OR CONTENT PROVIDERS, BE LIABLE UNDER CONTRACT, TORT, STRICT LIABILITY, 
		NEGLIGENCE OR ANY OTHER LEGAL OR EQUITABLE THEORY WITH RESPECT TO SHERPIN.COM (I) FOR ANY LOST PROFITS, DATA LOSS, COST OF PROCUREMENT 
		OF SUBSTITUTE GOODS OR SERVICES, OR SPECIAL, DIRECT, INDIRECT, INCIDENTAL, PUNITIVE, OR CONSEQUENTIAL DAMAGES OF ANY KIND WHATSOEVER, 
		SUBSTITUTE GOODS OR SERVICES (HOWEVER ARISING); OR (II) FOR ANY BUGS, VIRUSES, TROJAN HORSES, OR THE LIKE (REGARDLESS OF THE SOURCE 
		OF ORIGINATION). NOTWITHSTANDING THE FOREGOING, UNDER NO CIRCUMSTANCES SHALL SUCH LIABILITY EXCEED ANY DAMAGES IN EXCESS OF THE AMOUNT 
		YOU PAID FOR SHERPIN.COM OR THE SHERPIN.COM APPLICATION IN THE AGGREGATE. SOME STATES DO NOT ALLOW THE EXCLUSION OR LIMITATION OF 
		INCIDENTAL OR CONSEQUENTIAL DAMAGES, SO THE ABOVE LIMITATIONS AND EXCLUSIONS MAY NOT APPLY TO YOU.</li>
		<li><b>Governing Law and Jurisdiction. </b>These Terms of Use shall be governed by and construed in accordance with the laws of the 
		State of New York, including its conflicts of law rules, and the United States of America. You agree that any dispute arising from 
		or relating to the subject matter of these Terms of Use shall be governed by the exclusive jurisdiction and venue of the state and 
		federal courts of New York County, New York.</li>
		<li><b>Entire Agreement and Severability. </b>These Terms of Use are the entire agreement between you and us with respect to 
		Sherpin.com, and supersede all prior or contemporaneous communications and proposals (whether oral, written or electronic) between 
		you and us with respect to Sherpin.com. If any provision of these Terms of Use is found to be unenforceable or invalid, that provision 
		will be limited or eliminated to the minimum extent necessary so that these Terms of Use will otherwise remain in full force and effect 
		and enforceable.</li>
		<li><b>Miscellaneous.</b>
			<ol type="a">
			<li><b>Force Majeure. </b>We shall not be liable for any failure to perform our obligations hereunder where such failure results 
			from any cause beyond our reasonable control, including, without limitation, mechanical, electronic or communications failure or 
			degradation.</li>
			<li><b>Assignment. </b>These Terms of Use are personal to you, and are not assignable, transferable or sublicensable by you 
			except with our prior written consent. We may assign, transfer or delegate any of its rights and obligations hereunder without 
			consent.</li>
			<li><b>Agency. </b>No agency, partnership, joint venture, or employment relationship is created as a result of these Terms of Use 
			and neither party has any authority of any kind to bind the other in any respect.</li>
			<li><b>Notices. </b>Unless otherwise specified in these Term of Service, all notices under these Terms of Use will be in writing 
			and will be deemed to have been duly given when received, if personally delivered or sent by certified or registered mail, return 
			receipt requested; when receipt is electronically confirmed, if transmitted by facsimile or e- mail; or the day after it is sent, 
			if sent for next day delivery by recognized overnight delivery service.</li>
			<li><b>No Waiver. </b>Our failure to enforce any part of these Terms of Use shall not constitute a waiver of our right to later 
			enforce that or any other part of these Terms of Use. Waiver of compliance in any particular instance does not mean that we will 
			do so in the future. In order for any waiver of compliance with these Terms of Use to be binding, we must provide you with 
			written notice of such waiver, provided by one of its authorized representatives.</li>
			<li><b>Headings. </b>The section and paragraph headings in these Terms of Use are for convenience only and shall not affect</li>
			</ol>
		</li>
		<li><b>Contact. </b>You may contact us: by mail at 416 West 13th Street, Suite 203, New York, NY 10014 or by e-mail at 
		<a href="mailto:support@sherpin.com" style="color:#ededed">support@Sherpin.com</a>.</li>
	</ol>
	<h2>Effective Date of Terms of Use: July 31, 2012</h2>
	</div>
	<script>checkcookie();</script>
</body>
</html>
