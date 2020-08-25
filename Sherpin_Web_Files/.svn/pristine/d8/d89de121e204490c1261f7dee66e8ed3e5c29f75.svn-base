<?php
session_start();

$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
if ($mysqli->connect_errno) {
	$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
}
$mysqli->select_db("mediabup");

$profid = (int)$_REQUEST["ProfID"];
if (isset($_REQUEST["ChannelID"]))
	$chid = $_REQUEST["ChannelID"];
else {
	$ch = str_replace("'", "''", $_REQUEST["Channel"]);
	$chres = $mysqli->query("call GetChannelID('".$ch."');");
	while ($mysqli->next_result());
	$chrow = $chres->fetch_assoc();
	$chid = $chrow['ID'];
}

//Make sure the user is logged in
if (isset($_SESSION['USER_ID'])) {
	//Now make sure the user owns this profile
	$res = $mysqli->query("call GetUserIdForProfile(" . $profid . ");");
	while ($mysqli->next_result());
	$row = $res->fetch_assoc();
	if ($row != null && $row['UserID'] == $_SESSION['USER_ID']) {	
		$mysqli->query("call RemoveProfileChannel(".$profid.", ".$chid.");");
		while ($mysqli->next_result());
	}
}

header("Content-type: text/xml");

$stRet = "<?xml version=\"1.0\" ?" . "> ";
$stRet .= "<result>success</result>";
echo $stRet;
?>