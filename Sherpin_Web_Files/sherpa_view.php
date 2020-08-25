<?php
	session_start();
    include 'lib/MobileDetect.php';
    $detect = new Mobile_Detect();

    $spanfontsize = "18px/24px";
    //if ($detect->isMobile())
    //    $spanfontsize = "32px/40px";
?>
<?php
	$lastprof = -2;
	$uid = -1;
	$uname = "";
	if (isset($_SESSION["USER_ID"])) {
		$uid = $_SESSION["USER_ID"];
		
		$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
		if ($mysqli->connect_errno) {
			$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
		}
		$mysqli->select_db("mediabup");
		$profidres = $mysqli->query("call GetLastProfileByID(".$_SESSION["USER_ID"].");");
		while ($mysqli->next_result());
		if ($profidres->num_rows > 0) {
			$profrow = $profidres->fetch_assoc();
			$lastprof = $profrow['LastProfile'];
		}
	}
	if (isset($_SESSION["USER_NAME"])) {
		$uname = $_SESSION["USER_NAME"];
	}
	
?>
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
	<!--<meta name="viewport" content="width=device-width" />-->
    <title>sherpin.com</title>
    <link rel="stylesheet" type="text/css" href="css/metro.css" />
    <script type="text/javascript" src="/script/utils.js"></script>
    <script type="text/javascript" src="/script/metro_list.js"></script>
	<script type="text/javascript" src="/script/metro_view.js"></script>
    <script type="text/javascript" src="/script/metro_user.js"></script>
    <script type="text/javascript" src="https://connect.facebook.net/en_US/all.js"></script>
    <script type="text/javascript" src="/script/cookies.js"></script>

    <link media="screen" rel="stylesheet" href="lib/colorbox.css" />
    <script src="lib/jquery-latest.min.js" type="text/javascript"></script>
    <script src="lib/jquery.colorbox-min.js" type="text/javascript"></script>

    <script type="text/javascript">
		onlogin_function = function() {
			populatesherpas();
			addsearchfunction();
			var pos = setInterval(function() {
				if (cachedSherpas.length > 0) {
					<?php echo "// ".$uid."\n"; ?>
					positionsherpalist(<?php echo $lastprof;?>);
					getnewcounts();
					clearInterval(pos);
				}
			}, 500);
		};
		
        function checksession() {
			USERNAME='<?php echo $uname;?>';
			USERID=<?php echo $uid;?>;
        }
    </script>

    <meta property="fb:app_id" content="326133152009"/>
</head>
<body id="sherpa_view" style="background:#00263a;">
	<div style="height:100%;width:100%">
    <?php include "/var/www/sherpa_fb.php" ?>
	<?php include "/var/www/sherpa_header.php" ?>
	
	<div style="height:100%;">
		<div class="topmenu">
			<div class="topmenuitem"><a class="topmenulink" href="https://www.sherpin.com/sherpa_view.php">Home</a></div>
			<div class="topmenuitem"><span onclick="togglesherpamenu()">My Sherpas</span></div>
			<div class="topmenuitem"><span onclick="populatevideos(-1, 0, 200)">My Backpack</span></div>
			<div class="topmenuitem"><span>New Sherpa</span></div>
			<div style="clear:both"></div>
		</div>
		<div id="sherpamenu" class="sherpamenu" style="visibility:hidden"></div>
		
		<div id="videohighlight" class="videohighlight">
			<div id="highlightheader" class="highlightheader" onclick="highlightpause();">
				<div class="pausesection" style="float:left">
					<img id="pause1" class="pausebutton" src="Images/emptycircle.png">
					<img id="pause2" class="pausebutton" src="Images/emptycircle.png">
					<img id="pause3" class="pausebutton" src="Images/emptycircle.png">
					<img id="pause4" class="pausebutton" src="Images/emptycircle.png">
					<div style="clear:both"></div>
				</div>
				<div style="float:left">
					<h2 style="margin-top:0px"><span id="spanSherpa"></span> <span id="spanProgress"></span>:<span id="spanTitle"></span></h2>
				</div>
				<div style="clear:both;"></div>
			</div>
			<div style="height:90%;width:95%;">
				<div style="height:100%;width:10%;float:left">
					<p style="margin-top:100px">
						<span id="sherpaname" class="sherpicontitle"></span><br/>
						<img id="sherpaicon" style="width:85px">
						<br/><span class="sherpicontitle">sherpa</span>
					</p>
					
					<p style="margin-top:30px">
						<span class="sherpicontitle">Media brought to you by:</span><br/>
						<img id="sourceicon" style="width:40px">
					</p>
					
					<div id="spot-im-root" style="margin-top:30px"></div><script>!function(t,e,o){function p(){var t=e.createElement("script");t.type="text/javascript",t.async=!0,t.src=("https:"==e.location.protocol?"https":"http")+":"+o,e.body.appendChild(t)}t.spotId="79c2ee112673bec73598f51b00598f57",t.spotName="",t.allowDesktop=!0,t.allowMobile=!1,t.containerId="spot-im-root",p()}(window.SPOTIM={},document,"//www.spot.im/embed/scripts/launcher.js");</script>
				</div>
				<iframe id="_showvideo" src="/loading.html" style="height:100%;width:85%;border-style:none;float:left"></iframe>
				<div style="clear:both"></div>
			</div>
		</div>
		<!--
		<div id="previewlist" style="background:#4e8db0;max-height:100%;width:30%;margin:10px;overflow-y:hidden;float:left">
		</div>
		<div id="ads" style="background:#4e8db0;max-height:100%;width:15%;margin:10px;overflow-y:hidden;float:left">
		</div>
		-->
		<div style="clear:both;"></div>
	</div>
	
    <div id="sherpalistparent" class="sherpalistparent">
		<div id="sherpalist" class="sherpalisttop">
		</div>
    </div>
	<!--
	<img src="Images/left_triangle_arrow.png" class="sherpalistbutton" style="left:10px;" onmousedown="startmove(1)" onmouseup="stopmove()" onmouseout="stopmove()">
	<img src="Images/right_triangle_arrow.png" class="sherpalistbutton" style="right:10px;" onmousedown="startmove(-1)" onmouseup="stopmove()" onmouseout="stopmove()">
	-->
	
	<div id="videolistparent" class="videolistparent"  onmouseover="showdrawer()" onmouseout="hidedrawer()">
		<div id="videolist" class="videolist" style="left:50px">
		</div>
	</div>
	
	<img id="imgNew" src="Images/all.png" alt="show new videos" title="show new videos" class="videolistbutton" style="left:20px;bottom:100px;width:25px;height:25px" onmouseup="filterresults()">
	<img id="imgleft" src="Images/left_triangle_arrow.png" class="videolistbutton" style="left:10px;" onmousedown="startvideomove(1)" onmouseup="stopvideomove()" onmouseout="stopvideomove()">
	<img id="imgright" src="Images/right_triangle_arrow.png" class="videolistbutton" style="right:10px;" onmousedown="startvideomove(-1)" onmouseup="stopvideomove()" onmouseout="stopvideomove()">
	
	<img id="btnmenu" src="Images/menu.png" class="menubutton" style="visibility:visible" onclick="configdrawer(true)">
	<div id="config" class="config" style="right:-100px;height:85%">
		<p><img src="Images/forwardbutton.png" class="configbutton" onclick="configdrawer(false)"></p>
		<p><img src="Images/logout.png" class="configbutton" onclick="logout()"></p>
		<p><img id="sherpaeditbutton" src="Images/gear.png" class="configbutton"></p>
		<p><img src="Images/pinned.png" class="configbutton"></p>
		<p><img src="Images/delete.png" class="configbutton"></p>
		<p><img src="Images/share.png" class="configbutton"></p>
	</div>
	
    <div style="visibility:collapse" id="fb-root"></div>

    <script type="text/javascript">
        checkcookie();
		var edtbutton = document.getElementById("sherpaeditbutton");
		if (edtbutton != null)
			edtbutton.onclick = function() {  window.location='sherpa_edit.php?ProfID=' + <?php echo $lastprof;?>; }
		getvideohighlights(document.body.clientHeight, <?php echo $lastprof;?>);
		getallvideos(<?php echo $lastprof;?>);
    </script>
	<?php $index = 0; include "/var/www/sherpa_footer.php" ?>
	</div>
	<!--<img id="imgdrawer" src="Images/drawerclose.png" class="drawer" onclick="handledrawer(false)">-->
</body>
</html>