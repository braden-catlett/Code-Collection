<?php
session_start();

$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
if ($mysqli->connect_errno) {
	$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
}
$mysqli->select_db("mediabup");

$profid = (int)$_REQUEST["ProfID"];
$kws = explode(",", $_REQUEST["Keyword"]);

//Make sure the user is logged in
if (isset($_SESSION['USER_ID'])) {
	//Now make sure the user owns this profile
	$res = $mysqli->query("call VerifyUserProfile(" . $_SESSION['USER_ID'] . ", " . $profid . ");");
	while ($mysqli->next_result());
	if ($res->fetch_assoc()) {	
		foreach ($kws as $k) {
			$kw = str_replace("'", "''", str_replace(" ", "+", str_replace("%20", "+", trim($k))));
			if (strlen($kw) > 0) {
				$kwres = $mysqli->query("call GetKeywordID('".$kw."');");
				while ($mysqli->next_result());
				$kwrow = $kwres->fetch_assoc();
				if (!$kwrow) {
				   $mysqli->query("call AddKeyword('".$kw."');");
				   $kwres = $mysqli->query("call GetKeywordID('".$kw."');");
				   while ($mysqli->next_result());
				   $kwrow = $kwres->fetch_assoc();
				}
				$mysqli->query("call RemoveProfileKeyword(".$profid.", ".$kwrow['ID'].");");
				while ($mysqli->next_result());
				$mysqli->query("call AddProfileKeyword(".$profid.", ".$kwrow['ID'].", 1, 0);");
				while ($mysqli->next_result());
			}
		}
	}
}

header("Content-type: text/xml");

$stRet = "<?xml version=\"1.0\" ?" . "> ";
$stRet .= "<result>success</result>";
echo $stRet;
?>