<?php
/* Now parse the string for user id and profile id*/
$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
if ($mysqli->connect_errno) {
	$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
}
$mysqli->select_db("mediabup");

$userid = "";
if (isset($_SESSION["USER_ID"])) {
  $userid = (int)$_SESSION["USER_ID"];
}
else {
  $fbid = (int)$_REQUEST["FBID"];

  if (strlen($fbid) != 0) {
    $res = $mysqli->query("call GetUserID(".$fbid.");");
	while ($mysqli->next_result());
    $usr = $res->fetch_assoc();
    $userid = $usr['ID'];
	$_SESSION["USER_ID"] = $userid;
  }
}

if ($userid != "") {
	$profname = str_replace("'", "''", $_REQUEST["ProfName"]);

	$mysqli->query("call AddUserProfile(".$userid.", '".$profname."');");
	while ($mysqli->next_result());
	$profid = $mysqli->insert_id;
}
/* Close the stream */
mysql_close($conn);

header("Content-type: text/xml");

$stRet = "<?xml version=\"1.0\" ?" . "> ";
$stRet .= "<result id='".$profid."'>success</result>";
echo $stRet;
?>