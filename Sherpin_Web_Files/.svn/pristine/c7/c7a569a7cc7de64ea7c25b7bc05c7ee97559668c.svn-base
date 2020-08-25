<?php
session_start();

$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
if ($mysqli->connect_errno) {
	$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
}
$mysqli->select_db("mediabup");

$profid = (int)$_REQUEST["ProfID"];
$kw = str_replace("'", "''", str_replace(" ", "+", $_REQUEST["Keyword"]));

//Make sure the user is logged in
if (isset($_SESSION['USER_ID'])) {
	//Now make sure the user owns this profile
	$res = $mysqli->query("call GetUserIdForProfile(" . $profid . ");");
	while ($mysqli->next_result());
	$row = $res->fetch_assoc();
	if ($row != null && $row['UserID'] == $_SESSION['USER_ID']) {	
		$kwres = $mysqli->query("call GetKeywordID('".$kw."');");
		while ($mysqli->next_result());
		$kwrow = $kwres->fetch_assoc();
		$mysqli->query("call RemoveProfileKeyword(".$profid.", ".$kwrow['ID'].");");
		while ($mysqli->next_result());
	}
}

header("Content-type: text/xml");

$stRet = "<?xml version=\"1.0\" ?" . "> ";
$stRet .= "<result>success</result>";
echo $stRet;
?>