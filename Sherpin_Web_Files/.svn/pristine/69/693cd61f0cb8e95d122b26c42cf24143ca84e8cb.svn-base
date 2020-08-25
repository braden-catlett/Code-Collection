<?php
	session_start();
    include 'lib/MobileDetect.php';
    $detect = new Mobile_Detect();

    $spanfontsize = "18px/24px";
	$blackbartop = "167px";
    if ($detect->isMobile()) {
        $spanfontsize = "32px/40px";
		$blackbartop = "107px";
	}
?>
<html>
<head>
    <meta charset="utf-8" />
    <title>sherpin.com</title>
    <link rel="stylesheet" type="text/css" href="css/metro.css" />
	<style type="text/css">
		.header {
			height: 8%;
			min-height:40px;
			width: 100%;
			background: black
		}
		.content {
			background:url('/Images/background.png') no-repeat center center fixed;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
			height:87%;
			width:auto;
		}
	</style>
    <script type="text/javascript" src="/script/utils.js"></script>
    <script type="text/javascript" src="/script/metro_list.js"></script>
    <script type="text/javascript" src="/script/metro_user.js"></script>
    <script type="text/javascript" src="https://connect.facebook.net/en_US/all.js"></script>
    <script type="text/javascript" src="/script/cookies.js"></script>

    <link media="screen" rel="stylesheet" href="lib/colorbox.css" />
    <script src="lib/jquery-latest.min.js" type="text/javascript"></script>
    <script src="lib/jquery.colorbox-min.js" type="text/javascript"></script>

    <script type="text/javascript">
		onlogin_function = function() {
			if (USERID != -1)
				window.location='sherpa_view.php';
		};

		checkcookie();
		
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
		
		function cleartext(tb) {
			var dtb = document.getElementById(tb);
			if (dtb.value == tb) {
				if (tb == "password") {
					var newtb = dtb.cloneNode(false);
					newtb.type = 'password';
					newtb.value = "";
					dtb.parentNode.replaceChild(newtb, dtb);
					newtb.focus();
				}
				else
					dtb.value = "";
			}
		}
		
		function resettext(tb) {
			var dtb = document.getElementById(tb);
			if (dtb.value.length == 0) {
				if (tb == "password") {
					var newtb = dtb.cloneNode(false);
					newtb.type = 'text';
					newtb.value = 'password';
					dtb.parentNode.replaceChild(newtb, dtb);
				}
				else
					dtb.value = 'email';
			}
		}

		function haveThumbnails(titles, tnails) {
			var img = document.getElementById("imgThumbnail");
			var txt = document.getElementById("txtThumbnail");
			var i = 0;
			var nextThumbnail = function() {
				img.src = tnails[i];
				txt.innerHTML = titles[i];
				i = (i+1) % tnails.length;
			}
			nextThumbnail();
			setInterval(nextThumbnail, 10000);
		}

		<?php 
		if ($detect->isMobile())
			echo "var ismobile=1;\n";
		else
			echo "var ismobile=0;\n";
		?>
    </script>
    <meta property="fb:app_id" content="326133152009"/>
</head>
<body style="width:100%">
	<div class = "bigbox" style="height: 100%; width:100%;background:#00263a;min-height:630px;min-width:1000px"> 
		<div class="header">
			<span id="spanLogout" style="float:right;cursor:pointer;color: white; font: <?php echo $spanfontsize ?> Helvetica, Sans-Serif; padding: 10px; margin: 10px;"></span>
			<a id="spanUser" style="float:right;cursor:pointer;color: white; font: <?php echo $spanfontsize ?> Helvetica, Sans-Serif; padding: 10px; margin: 10px;" href="usersignin.php">returning user? sign in</a>
		</div>
		<div class="content">
			<div style="width:45%;margin-left:20px;margin-right:20px;float:left;">
				<div>
					<p style="font-size:36px;color:black">Welcome to Sherpin.com</p>
					<p style="font-size:20px;color:black">
						Personalized entertainment media about the things that interest you. Stop searching and start watching.
						Billions of media files categorized and indexed from across the Web, including most popular entertainment 
						sites. NO ads, NO spam, NO popups, NO tracking cookies ... just YOU Sherpin, watching and enjoying!
					</p>
					<div style="background:white;border-color:white;border-radius:15px;text-align:center">
						<a href="newuser.php" style="text-align:center;font-weight:bold;font-size:20px;color:black;margin-left:auto;margin-right:auto">new user? sign up!</a>
					</div>
				</div>
				<div>
					<img style="max-height:280px" src="Images/mountain2.png">
				</div>
			</div>
			<div id="divThumbnails" style="float:left;height:400px;margin-top:100px;margin-right:100px;width:400px;background:#00263a;text-align:center">
				<a style="font-size:20px;color:white" href="sherpa_view.php">Trending now on sherpin.com<br/>
				<span id="txtThumbnail" style="font-size:16px;color:white"></span></a>
				<img id="imgThumbnail" style="width:90%;max-height:90%;margin:5px"><br/>
			</div>
			<!--
			<div style="float:right;width:300px;margin-right:40px;margin-top:100px">
				<img style="margin-right: 30px; height: 58px; width: 190px; " src="Images/sherpin.png"/><br/>
				<img style="margin-right: 30px; width:300px"  src="Images/slogan.png"/>
			</div>
			-->
			<div style="clear:both"></div>
		</div>
		<?php $index = 1; include "/var/www/sherpa_footer.php" ?>
	</div>
    <?php include "/var/www/sherpa_fb.php" ?>
    <script type="text/javascript">
    	gettrendingimgs(haveThumbnails);
    </script>
</body>
</html>
