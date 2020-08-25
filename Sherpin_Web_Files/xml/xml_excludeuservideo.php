<?php
session_start();

$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
if ($mysqli->connect_errno) {
	$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
}
$mysqli->select_db("mediabup");

$vidid = (int)$_REQUEST["VideoID"];
$res = "not logged in";
if (isset($_SESSION["USER_ID"])) {
	$userid = (int)$_SESSION["USER_ID"];

	$res = "success";
	$mysqli->query("call ExcludeUserVideo(".$userid.", ".$vidid.");");
	while ($mysqli->next_result());
	$mysqli->query("call ModifyClickThrough(".$vidid.", -1);");
	while ($mysqli->next_result());
}

header("Content-type: text/xml");

$stRet = "<?xml version=\"1.0\" ?" . "> ";
$stRet .= "<result>".$res."</result>";
echo $stRet;
?>