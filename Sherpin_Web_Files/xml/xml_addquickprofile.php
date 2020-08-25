<?php
session_start();

/* Now parse the string for user id and profile id*/
$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
if ($mysqli->connect_errno) {
	$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
}
$mysqli->select_db("mediabup");

$userid=-1;
$profid = 0;
if (isset($_SESSION["USER_ID"])) {
  $userid = (int)$_SESSION["USER_ID"];
}
else {
  $fbid = (int)$_REQUEST["FBID"];

  if (strlen($fbid) != 0) {
    $res = $mysqli->query("call GetUserID('".$fbid."');");
	while ($mysqli->next_result());
    $usr = $res->fetch_assoc();
    $userid = $usr['ID'];
	$_SESSION["USER_ID"] = $userid;
  }
}

if ($userid != -1) {
	$profname = $_REQUEST["ProfName"];
	$keywords = "";
	if (isset($_REQUEST["Keywords"]))
	  $keywords = str_replace(" ", "+", $_REQUEST["Keywords"]);

	$mysqli->query("call AddUserProfile(".$userid.", '".$profname."');");
	while ($mysqli->next_result());
	$profres = $mysqli->query("select LAST_INSERT_ID()");
	$profrg = $profres->fetch_row();
	$profid = $profrg[0];
	while ($mysqli->next_result());

	$kws = explode(",", $keywords);
	for ($k=0, $c = sizeof($kws); $k < $c; $k++) {
	  if (strlen(trim($kws[$k])) != 0) {
		  $kwres = $mysqli->query("call GetKeywordID('".trim($kws[$k])."');");
		  while ($mysqli->next_result());
		  $kwrow = $kwres->fetch_assoc();
		  if (!$kwrow) {
			 $mysqli->query("call AddKeyword('".trim($kws[$k])."');");
			 while ($mysqli->next_result());
			 $kwres = $mysqli->query("select LAST_INSERT_ID()");
			 $kwrg = $profres->fetch_row();
			 $kwid = $profrg[0];
			 while ($mysqli->next_result());
		  }
		  else
			$kwid = $krow['ID'];
		  
		  $mysqli->query("call RemoveProfileKeyword(".$profid.", ".$kwid.");");
		  while ($mysqli->next_result());
		  $mysqli->query("call AddProfileKeyword(".$profid.", ".$kwid.", 1, 0);");
		  while ($mysqli->next_result());
	  }
	}

	//Default channels for youtube, dailymotion
	$mysqli->query("call AddProfileChannel(".$profid.", 1);");
	while ($mysqli->next_result());
	$mysqli->query("call AddProfileChannel(".$profid.", 9);");
	while ($mysqli->next_result());
}

header("Content-type: text/xml");

$stRet = "<?xml version=\"1.0\" ?" . "> ";
$stRet .= "<result id='".$profid."'>success</result>";
echo $stRet;
?>