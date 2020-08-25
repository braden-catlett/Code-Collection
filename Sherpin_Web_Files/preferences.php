<?php
	$skins["aquamist"] = "aqua mist";
	$skins["bubblegum"] = "bubble gum";
	$skins["burntorange"] = "burnt orange";
	$skins["buttercup"] = "butter cup";
	$skins["cascadia"] = "cascadia";
	$skins["creamsicle"] = "creamsicle";
	$skins["crimson"] = "crimson";
	$skins["emerald"] = "emerald";
	$skins["flowerstem"] = "flower stem";
	$skins["lemonhead"] = "lemonhead";
	$skins["magenta"] = "magenta";
	$skins["marshmallow"] = "marshmallow";
	$skins["royalpurple"] = "royal purple";
	$skins["sapphire"] = "sapphire";
	$skins["sherpin"] = "sherpin";
	$skins["valentine"] = "valentine";

	$userskin = 'b';

	$conn = mysql_connect("fb-db2.sherpin.com", "mediabup", "Buhner19") or die("Failed to connect: " . mysql_error());
	mysql_select_db("mediabup") or die("Failed to select db: " . mysql_error($conn));
	if (isset($_REQUEST['sherp'])) {
		$sherp = (int)$_REQUEST['sherp'];
		if (isset($_REQUEST['selSkin']) && isset($skins[$_REQUEST['selSkin']])) {
			$sql = "UPDATE Users SET Skin='mmg-".$_REQUEST['selSkin']."' WHERE ID=".$sherp.";";
			mysql_query($sql);
		}
		if (isset($_REQUEST['txtEmail'])) {
		
			$sql = "UPDATE Users SET Email='".$_REQUEST['txtEmail']."' WHERE ID=".$sherp.";";
			mysql_query($sql);
		}

		$passwordkey = 'JTADPmqRju';
		$sql = "SELECT Skin, Email, LENGTH(AES_DECRYPT(Password, '" . $passwordkey . "')) FROM Users WHERE ID=".$sherp.";";
		$res = mysql_query($sql);
		$userinfo = mysql_fetch_row($res);
		$userskin = substr($userinfo[0], 4);
		if (is_null($userinfo[1]) || strlen($userinfo[1]) == 0)
			$email = "your email";
		else
			$email = $userinfo[1];
		$fbook = $userinfo[2] == 0 ? "1" : "0";
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<!-- saved from url=(0014)about:internet -->
<head>
	<?php include("head.html") ?>
	<?php include 'setstyle.php'; ?>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<script type="text/javascript">
	function selectall(id)
	{
		document.getElementById(id).focus();
		document.getElementById(id).select();
	}

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
            var loggedin = document.getElementById("loggedinuser");
            if (loggedin != null) loggedin.style.visibility = "visible";

			var username = document.getElementById("txtName")
			if (txtName != null) txtName.value = getusername();
        }

		setwelcomebar();
    }
    
    function updatestyle(s) {
    	document.location = "preferences.php?sherp="+SHERP_ID+"&selSkin="+s;
    }
	</script>
</head>
<body style="text-align:center; min-width:500px; min-height:300px"  >
    <?php include("header.html") ?>
    <?php $page = "preferences"; include("topmenubar.php") ?>

    <form id="form1" style="height:75%" runat="server">
        <table border="0" style="height:100%; width:100%">
            <tr style="height:100%">
            <td style="height:100%">
            <div id="silverlightControlHost" class="border" style="height:95%; vertical-align:middle; text-align:center;" >
			<table border="0" style="margin-left:auto; margin-right:auto">
				<tr><td colspan="7"><h1>User preferences</h1><input id="sherp" name="sherp" type="text" style="visibility:collapse"/></td></tr>
				<tr>
					<td colspan="3" style="text-align:right">Name:</td>
					<td colspan="3" style="text-align:left"><input type="text" size="50" id="txtName" name="txtName" disabled/></td>
				</tr>
				<tr>
				<td colspan="3" style="text-align:right">Email:</td><td colspan="3" style="text-align:left"><input type="text" size="50" id="txtEmail" name="txtEmail" value="<?php echo $email;?>" onclick="selectall('txtEmail');"/></td>
				</tr>
				<tr>
				<td colspan="3" style="text-align:right">Desktop skin:</td>
				<td colspan="3" style="text-align:left">
					<select id="selSkin" name="selSkin" onchange="updatestyle(this.options[this.selectedIndex].value)">
						<?php
							foreach ($skins as $k => $v) {
								if ($k == $userskin)
									echo "<option value=\"".$k."\" selected=\"selected\">".$v."</option>";
								else
									echo "<option value=\"".$k."\"\">".$v."</option>";
							}
							echo "\n";
						?>
					</select>
				</td>
				</tr>
				<tr>
					<?php if ($fbook == "0") { ?>
					<td colspan="6" style="text-align:center"><a href='changepwd.php' class="changepwd" >change password</a></td><td colspan="2">&nbsp;</td>
					<?php } ?>
				</tr>
				<tr>
				<td width="20%">&nbsp;</td>
				<td width="15%"><img src="Images/Login.jpg" width="100px" alt="Login"/></td>
				<td width="7%"><p style="font-size:1.8em; color:#484848">&rarr;</p></td>
				<td width="15%"><img src="Images/Edit.jpg" width="100px" alt="Edit/Create Sherpa"/></td>
				<td width="8%"><p style="font-size:1.8em; color:#484848">&rarr;</p></td>
				<td width="15%"><img src="Images/Sherpin.jpg" width="100px" alt="You are now sherpin"/></td>
				<td width="20%">&nbsp;</td>
				</tr>
				<tr>
				<td width="20%">&nbsp;</td>
				<td width="15%">login</td>
				<td width="7%">&nbsp;</td>
				<td width="15%">what do<br/>you like?</td>
				<td width="8%">&nbsp;</td>
				<td width="15%">start watching</td>
				<td width="20%">&nbsp;</td>
				</tr>
			</table>
            </div>
            <?php include("bottommenubar.php") ?>
            </td>
            <td style="height:100%; width:200px; text-align:right; vertical-align:top">
            <?php include 'rightframe.php' ?>
            </td>
            </tr>
        </table>
    </form><br />
	<script type="text/javascript">getlogininfo();</script>
</body>
</html>
