<?php
    include 'lib/MobileDetect.php';
    $detect = new Mobile_Detect();

    $spanfontsize = "14px/24px";
    if ($detect->isMobile())
        $spanfontsize = "24px/32px";
?>
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>sherpin.com</title>
    <link rel="stylesheet" type="text/css" href="css/metro.css" />
    <script type="text/javascript" src="/script/utils.js"></script>
    <script type="text/javascript" src="/script/metro_list.js"></script>
    <script type="text/javascript" src="/script/metro_user.js"></script>
    <script type="text/javascript" src="https://connect.facebook.net/en_US/all.js"></script>
    <script type="text/javascript" src="/script/cookies.js"></script>

    <link media="screen" rel="stylesheet" href="lib/colorbox.css" />
    <script src="lib/jquery-latest.min.js" type="text/javascript"></script>
    <script src="lib/jquery.colorbox-min.js" type="text/javascript"></script>

    <meta property="fb:app_id" content="326133152009"/>
</head>
<body>
    <div style="height:15%;width:100%;background:black">
        <div style="float:left">
            <img src="http://www.sherpin.com/Images/logo.png" alt="" height="60px"/>
        </div>
        <div style="float:left">
	        <a href="http://www.sherpin.com/metro.php" style="margin-left:10px;color:white; font-family:Helvetica, Sans-Serif; font-size:48px; letter-spacing:2px">Sherpin.com</a><br />
	        <span style="margin-left:20px;color:white; font-family:Helvetica, Sans-Serif; font-size:16px"><i>Stop searching ... start watching</i></span>
        </div>
        <div style="float:right">
            <span id="spanUser" style="cursor:pointer;color: white; font: <?php echo $spanfontsize ?> Helvetica, Sans-Serif; padding: 10px; margin: 10px;" onclick="startlogin(<?php echo $detect->isMobile(); ?>)">sign in</span>
            <span id="spanLogout" style="cursor:pointer;color: white; font: <?php echo $spanfontsize ?> Helvetica, Sans-Serif; padding: 10px; margin: 10px;"></span>
        </div>
        <div style="clear:both"></div>
    </div>

    <div id="sherpalist" style="overflow:auto">
    </div>

<!--    <div style="height:5%;width:100%;background:black;margin-left:auto;margin-right:auto;position:absolute;bottom:0px">
	    <a href="http://www.sherpin.com/metro.php" style="margin-left:10px;color:white; font-family:Berlin Sans FB Demi, Lucida Sans Unicode; font-size:14px; letter-spacing:2px">Sherpin.com</a><br />
        <span id="spanDebug" style="color:white"></span>
    </div>-->
    <div style="visibility:collapse" id="fb-root"></div>

    <script>
        checkcookie();
    </script>
</body>
</html>