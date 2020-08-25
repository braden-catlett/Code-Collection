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
		onlogin_function = function() { populatevideolist(0, 200); populatesherpas(); };
	
        function checksession() {
            <?php
                if (isset($_SESSION["USER_ID"]) && strlen($_SESSION["USER_ID"]) != 0) {
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
        var sherpaid=<?php echo $_REQUEST["ProfID"];?>;
		<?php if (isset($_REQUEST["QSearch"])) { echo "var qsearch='".$_REQUEST["QSearch"]."';\n"; } ?>
		<?php if (isset($_REQUEST["Offset"])) { echo "var videooffset=".$_REQUEST["Offset"].";"; } else { echo "var videooffset=0;"; } ?>
        var clastvideo = 0;
    </script>
	<script type="text/javascript" src="/script/metro_view.js"></script>
	<script type="text/javascript" src="/script/metro_list.js"></script>
	<script type="text/javascript" src="/script/metro_detail.js"></script>

	<style>
	.searchBox{
		background-image:url('Images/search.png');
		background-repeat:no-repeat;
		padding-left:20px;
	}
	</style>
</head>
<body>
    <?php include "/var/www/sherpa_fb.php" ?>
    <div style="height:100%">
	<?php include "/var/www/sherpa_header.php" ?>

    <div id="divVideo" style="height:80%;width:100%;position:fixed;">
        <div style="background:#4e8db0; float:left;height:100%;width:40%;white-space:nowrap">
			<div id="videotools" style="background:#4e8db0;height:10%;width:100%;white-space:nowrap;color:white"></div>
			<div id="videolist" style="background:#4e8db0;height:88%;width:100%;overflow:auto;white-space:nowrap"></div>
		</div>
		<!--touchscroll.js will make the overflow divs scrollable. http://www.seabreezecomputers.com/tips/scroll-div.htm -->
		<script type="text/javascript" src="/script/touchscroll.js"></script>
        <iframe id="_showvideo" style="float:left;width:56%;height:100%"></iframe>
        <div style="clear:both"></div>
    </div>

    <div id="sherpalistparent" style="overflow-x:hidden;overflow-y:hidden;white-space:nowrap;position:fixed;bottom:30px;left:35px;right:35px;height:100px;visibility:hidden;background:#333333;opacity:0.80;">
		<div id="sherpalist" style="width:9999px;overflow-x:hidden;overflow-y:hidden;white-space:nowrap;position:relative;left:150px">
		</div>
    </div>
	<img id="imgleft" src="Images/left_triangle_arrow.png" class="carouselbutton" style="left:7px;visibility:hidden;height:100px"  onmousedown="startmove(1)" onmouseup="stopmove()" onmouseout="stopmove()">
	<img id="imgright" src="Images/right_triangle_arrow.png" class="carouselbutton" style="right:7px;visibility:hidden;height:100px"  onmousedown="startmove(-1)" onmouseup="stopmove()" onmouseout="stopmove()">

<!--    <div style="height:5%;width:100%;background:black;margin-left:auto;margin-right:auto;position:absolute;bottom:0px">
	    <a href="http://www.sherpin.com/sherpa_view.php" style="margin-left:10px;color:white; font-family:Berlin Sans FB Demi, Lucida Sans Unicode; font-size:14px; letter-spacing:2px">Sherpin.com</a><br />
    </div>-->
	<img src="Images/drawer.png" style="position:fixed;right:20px;bottom:30px;width:50px" onclick="handledrawer(false)">
    <script type="text/javascript">
		checkcookie();
    </script>
	<?php $index = 0; include "/var/www/sherpa_footer.php" ?>
    </div>
</body>
</html>