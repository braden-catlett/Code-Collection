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

	<?php
		if (isset($_SESSION["USER_ID"]) && $_SESSION["USER_ID"] != -1) {
			$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
			$mysqli->select_db("mediabup");
			$res = $mysqli->query("call GetIsAdmin(".$_SESSION["USER_ID"].");");
			while ($mysqli->next_result());
			$usr = $res->fetch_assoc();
			if ($usr['Admin'] == 1) {
	?>
    <form id="form1" style="height:75%" runat="server">
		<table border="0" style="margin-left:auto; margin-right:auto; color:#CCCCCC">
			<?php
			$conn = mysql_connect("fb-db2.sherpin.com", "mediabup", "Buhner19") or die("Failed to connect: " . mysql_error());
			mysql_select_db("mediabup") or die("Failed to select db: " . mysql_error($conn));
			$sql = "SELECT CAST(DateAdded as DATE), Name, Email, Comments FROM Feedback ORDER BY DateAdded DESC, Email;";
			mysql_query($sql);
			$res = mysql_query($sql);
			$rc = mysql_num_rows($res);
			if ($rc > 0) {
				echo "<tr><td colspan=\"7\"><hr style=\"color:#CCC;background-color:#CCC;height:1px;border:none;\" /></td></tr>\n";
				echo "<tr><th>Date</th><th>Name</th><th>Email</th><th colspan=\"4\">Comment</th></tr>\n";
				echo "<tr><td colspan=\"7\"><hr style=\"color:#CCC;background-color:#CCC;height:1px;border:none;\" /></td></tr>\n";
				for ($i=0; $i<$rc; $i++) {
					$row = mysql_fetch_row($res);
					echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td colspan=\"4\">".$row[3]."</td></tr>\n";
					echo "<tr><td colspan=\"7\"><hr style=\"color:#CCC;background-color:#CCC;height:1px;border:none;\" /></td></tr>\n";
				}
			}
			?>
		</table>
    </form><br />
	<?php } } ?>
	<?php include "/var/www/sherpa_footer.php" ?>
	<script>checkcookie();</script>
</body>
</html>
