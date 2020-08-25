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
		<div class="content">
			<div style="width:45%;margin-left:20px;margin-right:20px;margin-top:100px;float:left;">
				<div>
					<img style="max-height:280px" src="Images/mountain2.png">
				</div>
			</div>
			<div style="float:left;background-color:lightgray; opacity:0.8; border-style: solid; border-width 4px;border-color:darkblue;height:300px;margin-top:100px;width:225px;border-radius:45px;text-align:center">
				<!--<p style = "font-size: 24px; margin-left: 15px; color: red; font-family:Helvetica, Sans-Serif; margin-top: 40px"> <i>New User?</i></p>-->
				<p style="font-size:16px;text-align:center;color:darkblue">Sign up through facebook<br/></p>
				<!--<fb:login-button>Login</fb:login-button>-->
				<div style="height:18px;width:63px;text-align:center;margin-left:auto;margin-right:auto">
					<img class="loginbox" src="/Images/fblogin.png" onclick="fblogin()" alt="login" style="text-align:center;margin-left:auto;margin-right:auto;margin-top:5px;cursor:pointer"/>
				</div>

				<p style="font-size:16px;text-align:center;color:darkblue">Or create a new<br/>sherpin.com account:
			<!-- text box-->
				<input name="email" id="email" type="text" value = "email" style ="font-size: 14px; color: grey; height: 40px; width: 200px; margin-top: 10px" onfocus="cleartext('email')" onblur="resettext('email')">
				<input name="password" id="password" type="text" value = "password" style ="font-size: 14px; color: grey; height: 40px; width: 200px; margin-top: 10px" onfocus="cleartext('password')" onblur="resettext('password')">
				</p>
				
				<div style="float:left; margin-left:20px; height:31px;width:72px;">
					<img class="loginbox" style="cursor:pointer" src="Images/signup.png" onclick="sherplogin()"/>
				</div>
				<div style="float:right; margin-right:20px; height:31px;width:72px;">
					<img class="loginbox" style="cursor:pointer" src="Images/trial.png" onclick="window.location='sherpa_view.php'"/>
				</div>
			</div>
		</div>
	</div>
</body>
</html>