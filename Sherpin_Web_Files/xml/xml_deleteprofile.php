<?php
session_start();

$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
if ($mysqli->connect_errno) {
	$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
}
$mysqli->select_db("mediabup");

//Make sure the user is logged in
if (isset($_SESSION['USER_ID'])) {
	$profid = (int)$_REQUEST["ProfID"];

	//Now make sure the user owns this profile
	$res = $mysqli->query("call VerifyUserProfile(" . $_SESSION['USER_ID'] . ", " . $profid . ");");
	while ($mysqli->next_result());
	if ($res->fetch_assoc()) {	
		$mysqli->query("call DeleteProfile(".$profid.");");
		while ($mysqli->next_result());
	}
}

header("Content-type: text/xml");

$stRet = "<?xml version=\"1.0\" ?" . "> ";
$stRet .= "<result>success</result>";
echo $stRet;
?>