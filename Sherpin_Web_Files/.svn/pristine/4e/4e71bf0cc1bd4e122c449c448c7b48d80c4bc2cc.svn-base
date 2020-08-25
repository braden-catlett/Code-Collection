<?php
/* Now parse the string for user id and keywords */
$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
if ($mysqli->connect_errno) {
	$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
}
$mysqli->select_db("mediabup");

$profidSrc = (int)$_REQUEST["profidSrc"];
$profidDest = (int)$_REQUEST["profidDest"];

$mysqli->query("call CopyProfile(".$profidSrc.", ".$profidDest.");");
while ($mysqli->next_result());

header("Content-type: text/xml");

$stRet = "<?xml version=\"1.0\" ?" . "> ";
$stRet .= "<result>success</result>";
echo $stRet;
?>