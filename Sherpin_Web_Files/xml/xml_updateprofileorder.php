<?php
session_start();

$conn = mysql_connect("fb-db2.sherpin.com", "mediabup", "Buhner19") or die("Failed to connect: " . mysql_error());
mysql_select_db("mediabup") or die("Failed to select db: " . mysql_error($conn));

$stRet = "<?xml version=\"1.0\" ?" . "> ";
$profid = (int)$_REQUEST["ProfID"];
$presorder = (int)$_REQUEST["PresOrder"];

//Make sure the user is logged in
if (isset($_SESSION['USER_ID'])) {
	//Now make sure the user owns this profile
	$res = mysql_query("SELECT UserID FROM UserProfiles WHERE UserID=" . $_SESSION['USER_ID'] . " AND ProfileID=" . $profid . ";");
	if (mysql_num_rows($res) > 0) {	
		$sql = "UPDATE UserProfiles SET PresentationOrder=".$presorder." WHERE ProfileID=".$profid.";";
		mysql_query("INSERT INTO tempdata VALUES ('".str_replace("'", "\\'", $sql)."';");
		mysql_query("START TRANSACTION;");
		mysql_query($sql);
		mysql_query("COMMIT;") 
		  or mysql_query("INSERT INTO tempdata VALUES ('".str_replace("'", "\\'", mysql_error($conn))."');");
	}
}
mysql_close($conn);

header("Content-type: text/xml");

$stRet .= "<result>success</result>";
echo $stRet;
?>