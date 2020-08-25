<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<!-- saved from url=(0014)about:internet -->
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<?php include("head.html") ?>
	<?php include 'setstyle.php'; ?>
	<script>
    function showuser() {
		var isloggedin = getloggedin();
        if (isloggedin != 0) {
            var viewer = document.getElementById("aviewer");
            if (viewer != null) viewer.style.visibility = "visible";

            var btns = document.getElementById("loginbuttons");
            if (btns != null) {
				btns.style.visibility = "collapse";
				btns.style.height = "0px";
			}
        }

		setwelcomebar();
    }

	function calcimageheight() {
		var img = document.getElementById("imgMonitors");
		var imgRatio = 640.0/259.0;
		var h = GetHeight();
		var w = GetWidth();
		var iheight = h - 350;
		var iwidth = iheight * imgRatio;
		if (iwidth > w - 210) {
			iwidth = w - 210;
			iheight = w / imgRatio;
		}
		img.height = iheight;
		img.width = iwidth;
	}
	
	window.onresize = calcimageheight;
	</script>
</head>
<body style="text-align:center; min-width:500px; min-height:300px; height: 100%"  >
    <?php include("header.html") ?>
    <?php $page = "index"; include("topmenubar.php") ?>
    <table border="0" style="width:100%">
        <tr>
        <td>
        <div class="border" id="silverlightControlHost" style="vertical-align:middle; text-align:center;" >
		<table border="0"> <!-- style="margin-left:auto; margin-right:auto; margin-top:10px; margin-bottom:10px"> -->
			<tr><td colspan="7"><img id="imgMonitors" src="Images/Monitors.jpg" alt="monitors"/></td></tr>
			<tr><td colspan="7"><hr style="color:#333;background-color:#333;height:1px;border:none;" /></td></tr>
			<tr><td colspan="7"><h1>Customized media delivery directly to you!</h1></td></tr>
			<tr>
			<td width="20%">&nbsp;</td>
			<td width="15%">
			<?php $validsherpid = isset($_REQUEST['sherp']) && strlen($_REQUEST['sherp']) > 0 && strcmp($_REQUEST['sherp'], "-1") != 0; ?>
			<?php
				if ($validsherpid) {
			?>
				<span id="divRegisterOff">
					<img src="Images/Login.jpg" width="100px" alt="Login"/><br/>
					<span id="spnLoggedIn">logged in</span>
				</span>
			<?php } else { ?>
				<span id="divRegisterOn">
					<a href='register.php' class="register" ><img src="Images/Login.jpg" width="100px" alt="Login"/></a><br/>
					<a href='register.php' class="register" >login</a>
				</span>
			<?php } ?>
			</td>
			<td width="7%"><p style="font-size:1.8em; color:#484848">&rarr;</p></td>
			<td width="15%">
			<?php
				if ($validsherpid) {
			?>
				<span id="divQuickstartOn">
					<a href="quickstart.php" class="quickstart"><img src="Images/Edit.jpg" width="100px" alt="Edit/Create Sherpa"/></a><br/>
					<a href="quickstart.php" class="quickstart">what do<br/>you like?</a>
				</span>
			<?php } else { ?>
				<span id="divQuickstartOff">
					<img src="Images/Edit.jpg" width="100px" alt="Edit/Create Sherpa"/><br/>
					<span>what do<br/>you like?</span>
				</span>
			<?php } ?>
			</td>
			<td width="8%"><p style="font-size:1.8em; color:#484848">&rarr;</p></td>
			<td width="15%">
			<?php
				if ($validsherpid) {
			?>
				<span id="divViewerOn">
					<a href="viewer.php?sherp=<?php echo $_REQUEST['sherp']; ?>" class="viewer"><img src="Images/Sherpin.jpg" width="100px" alt="You are now sherpin"/></a><br/>
					<a href="viewer.php?sherp=<?php echo $_REQUEST['sherp']; ?>" class="viewer">start watching</a>
				</span>
			<?php } else { ?>
				<span id="divViewerOff">
					<img src="Images/Sherpin.jpg" width="100px" alt="You are now sherpin"/><br/>
					<span>start watching</span>
				</span>
			<?php } ?>
			</td>
			<td width="20%">&nbsp;</td>
			</tr>
		</table>
		</div>
        </td>
        <td style="width:200px; text-align:right; vertical-align:top">
        <?php include 'rightframe.php'; ?>
        </td>
        </tr>
    </table>
    <?php include("bottommenubar.php") ?>
	<script>
		getlogininfo();
		calcimageheight();
	</script>
</body>
</html>
