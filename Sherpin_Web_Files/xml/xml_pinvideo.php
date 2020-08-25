<?php
session_start();

$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
if ($mysqli->connect_errno) {
	$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
}
$mysqli->select_db("mediabup");

$vidid = (int)$_REQUEST["VideoID"];
$profid = -1;
if (isset($_REQUEST["ProfID"]))
	$profid = (int)$_REQUEST["ProfID"];
$userid = -1;
if (isset($_SESSION["USER_ID"]))
	$userid = $_SESSION["USER_ID"];
if ($userid == null || strlen($userid) == 0)
	$userid = -1;
$pin = (int)$_REQUEST["Pin"];

$res = "success";
$stRet = "<?xml version=\"1.0\" ?" . "><results> ";
if ($pin == 1) {
	if ($userid == -1) {
		$usrres = $mysqli->query("call GetUserIdForProfile(" . $profid . ");");
		while ($mysqli->next_result());
		$usr = $usrres->fetch_assoc();
		$userid = $usr['UserID'];
	}
	if ($profid == null || strlen($profid) == 0)
		$profid = -1;
	$addsql = "call AddProfilePin(".$userid.", ".$profid.", ".$vidid.");";
	$mysqli->query($addsql) or die("error: ".$mysqli->error." (".$addsql.")");
	$stRet .= "<sql>".$addsql."</sql>";
	while ($mysqli->next_result());
} else {
	$mysqli->query("call RemoveProfilePin(".$profid.", ".$vidid.");");
	while ($mysqli->next_result());
}

header("Content-type: text/xml");

$stRet .= "<result>".$res."</result></results>";
echo $stRet;
?>