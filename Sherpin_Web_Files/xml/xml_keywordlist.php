<?php
	session_start();
	
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header("Content-type: text/xml");

	//Download the user's keyword list in XML format
	$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
	if ($mysqli->connect_errno) {
		$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
	}
	$mysqli->select_db("mediabup");

	$profid = -1;
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
	}
	if (isset($_REQUEST['ProfID'])) {
		$profid = (int)$_REQUEST['ProfID'];
		if ($profid == -2) {
			$kwres = $mysqli->query("call GetTrendingKeywords();") or die("error: ".$mysqli->error);
		}
		elseif ($profid == -6) {
			$kwres = $mysqli->query("call GetHotNewsKeywords();") or die("error: ".$mysqli->error);
		}
		elseif ($profid == -5) {
			$kwres = $mysqli->query("call GetMovieKeywords();") or die("error: ".$mysqli->error);
		}
		elseif ($profid == -3) {
			$kwres = $mysqli->query("call GetUserInterestKeywords(".$uid.");") or die("error: ".$mysqli->error);
		}
		else {
			$kwres = $mysqli->query("call GetProfileKeywords(".$uid.", ".$profid.");") or die("error: ".$mysqli->error);
		}
		while ($mysqli->next_result());
	}
	else  {
		$kwres = $mysqli->query("call GetUserKeywords(".$uid.");") or die("error: ".$mysqli->error);
		while ($mysqli->next_result());
	}
	
	$stRet = "<?xml version=\"1.0\" ?" . "> ";
	$stRet .= "<KWList count='0'> ";
	while ($kid = $kwres->fetch_assoc()) {
		$stRet .= "<KW> ";
		$stRet .= "<kid> " . $kid['id'] . "</kid> ";
		$stRet .= "<keyword> " . htmlspecialchars($kid['Keyword']) . " </keyword> ";
		if (isset($_REQUEST['ProfID'])) {
			$stRet .= "<active>".$kid['Active']."</active>";
			$stRet .= "<exclude>".$kid['Exclude']."</exclude>";
			// $active = 0;
			// if ($kid['Active'] == 1) { $active = "1"; }
			// $stRet .= "<active> " . $active . " </active> ";
			// $exclude = 0;
			// if ($kid['Exclude'] == 1) { $exclude = "1"; }
			// $stRet .= "<exclude> " . $exclude . " </exclude> ";
		}
		$stRet .= "</KW> ";
	}
	$stRet .= "</KWList> ";
	
	echo $stRet;
?>