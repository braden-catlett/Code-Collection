<?php
	session_start();
    include 'lib/MobileDetect.php';
    $detect = new Mobile_Detect();

    $spanfontsize = "18px/24px";
    //if ($detect->isMobile())
    //    $spanfontsize = "32px/40px";
?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>sherpin.com</title>
    <link rel="stylesheet" type="text/css" href="css/metro.css"/>
    <script type="text/javascript" src="/script/utils.js"></script>
    <script type="text/javascript" src="/script/metro_user.js"></script>
    <script type="text/javascript" src="/script/cookies.js"></script>
    <script type="text/javascript" src="https://connect.facebook.net/en_US/all.js"></script>

    <link media="screen" rel="stylesheet" href="lib/colorbox.css" />
    <script src="lib/jquery-latest.min.js" type="text/javascript"></script>
    <script src="lib/jquery.colorbox-min.js" type="text/javascript"></script>

    <script type="text/javascript">
		onlogin_function = function() { populatevideos(0, 200) };
	
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

    <meta property="fb:app_id" content="326133152009"/>
    <script type="text/javascript">
        var videoid=<?php echo $_REQUEST["VideoID"];?>;
        var clastvideo = 0;
    </script>

	<script type="text/javascript" src="/script/metro_view.js"></script>
	<script type="text/javascript" src="/script/metro_share.js"></script>
</head>
<body>
    <?php include "/var/www/sherpa_fb.php" ?>
    <div style="height:100%">
	<?php include "/var/www/sherpa_header.php" ?>

    <div id="divVideo" style="height:80%;width:100%;position:fixed;">
        <div id="videolists" style="background:#4e8db0; float:left;height:100%;width:45%;overflow:auto;white-space:nowrap">
			<div id="divsave" style="width:100%;overflow:auto;white-space:nowrap;margin-bottom:20px">&nbsp;</div>
			<span style="font-size:24px;color:white">video shared with you<br/></span>
			<div id="sharedvideo" style="width:100%;overflow:auto;white-space:nowrap;margin-bottom:20px">&nbsp;</div>
			<span style="font-size:24px;color:white">other related videos<br/></span>
			<div id="videolist" style="width:100%;overflow:auto;white-space:nowrap">&nbsp;</div>
		</div>
        <iframe id="_showvideo" style="float:left;width:50%;height:100%"></iframe>
        <div style="clear:both"></div>
    </div>

<!--    <div style="height:5%;width:100%;background:black;margin-left:auto;margin-right:auto;position:absolute;bottom:0px">
	    <a href="http://www.sherpin.com/sherpa_view.php" style="margin-left:10px;color:white; font-family:Berlin Sans FB Demi, Lucida Sans Unicode; font-size:14px; letter-spacing:2px">Sherpin.com</a><br />
    </div>-->
    <script type="text/javascript">
		checkcookie();
    </script>
	<?php $index=0; include "/var/www/sherpa_footer.php" ?>
    </div>
</body>
</html>