<?php
	session_start();
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header("Content-type: text/xml");

	//Download the user's category list in XML format
	$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
	if ($mysqli->connect_errno) {
		$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
	}
	$mysqli->select_db("mediabup");

	$uid = -1;
	if (isset($_SESSION['USER_ID']))
		$uid = (int)$_SESSION['USER_ID'];
	elseif (isset($_REQUEST['FBID']))
	{
		$fbid = (int)$_REQUEST['FBID'];
		$ures = $mysqli->query("call GetUserID('".$fbid."');");
		while ($mysqli->next_result());
		$urow = $ures->fetch_assoc();
		$uid = $urow['ID'];
		$_SESSION["USER_ID"] = $uid;
		$profid = $urow['LastProfile'];
	}
	if (isset($_REQUEST['ProfID']))
		$profid = (int)$_REQUEST['ProfID'];
	$pres = $mysqli->query("call GetPreferenceList(".$profid.");");
	while ($mysqli->next_result());
	
	$stRet = "<?xml version=\"1.0\" ?" . "> ";
	$stRet .= "<PrefList> ";
	while ($prow = $pres->fetch_assoc()) {
		$stRet .= "<Pref> ";
		$stRet .= "<pid> " . $prow['ID'] . "</pid> ";
		$stRet .= "<prefname> " . $prow['Name'] . " </prefname> ";
		$stRet .= "<active> ";
		if ($profid == -2 || $profid == -3 || $profid == -6 || $profid == -5 || is_null($prow['ProfileID']) == false)
			$stRet .= "1";
		else
			$stRet .= "0";
		$stRet .= " </active> ";
		$stRet .= "</Pref> ";
	}
	$stRet .= "</PrefList> ";
	
	echo $stRet;
?>