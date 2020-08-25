<?php
session_start();
$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
if ($mysqli->connect_errno) {
	$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
}
$mysqli->select_db("mediabup");

$profid = (int)$_REQUEST["ProfID"];
if (isset($_REQUEST["PrefID"]))
	$prefid = $_REQUEST["PrefID"];
else {
	$pref = str_replace("'", "''", $_REQUEST["PrefName"]);
	
	$prefres = $mysqli->query("call GetPreferenceID('".$pref."');");
	while ($mysqli->next_result());
	$prefrow = $prefres->fetch_assoc();
	$prefid = $prefrow['ID'];
}

//Make sure the user is logged in
if (isset($_SESSION['USER_ID'])) {
	//Now make sure the user owns this profile
	$res = $mysqli->query("call VerifyUserProfile(" . $_SESSION['USER_ID'] . ", " . $profid . ");");
	while ($mysqli->next_result());
	if ($res->fetch_assoc()) {	
		$mysqli->query("call AddProfilePreference(".$profid.", ".$prefid.");");
		while ($mysqli->next_result());
	}
}

header("Content-type: text/xml");

$stRet = "<?xml version=\"1.0\" ?" . "> ";
$stRet .= "<result>success</result>";
echo $stRet;
?>