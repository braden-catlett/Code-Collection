<?php
	session_start();
	
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header("Content-type: text/xml");

	//Download the user's channel list in XML format
	$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
	if ($mysqli->connect_errno) {
		$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
	}
	$mysqli->select_db("mediabup");

	$uid = -1;
	if (isset($_SESSION['USER_ID']))
	{
		$uid = (int)$_SESSION['USER_ID'];
		$ures = $mysqli->query("call GetUserLastProfile(".$_SESSION['USER_ID'].");");
		while ($mysqli->next_result());
		$urow = $ures->fetch_assoc();
		$profid = $urow['LastProfile'];
	}
	elseif (isset($_REQUEST['FBID']))
	{
		$fbid = (int)$_REQUEST['FBID'];
		$ures = $mysqli->query("call GetUserID('".$fbid."');");
		while ($mysqli->next_result());
		$urow = $ures->fetch_assoc();
		$uid = $urow['ID'];
		$profid = $urow['LastProfile'];
		$_SESSION["USER_ID"] = $uid;
	}
	if (isset($_REQUEST['ProfID']))
		$profid = (int)$_REQUEST['ProfID'];

	if ($profid == "") {
		$profid = -1;
	}

	$chres = $mysqli->query("call GetChannelList(".$profid.");");
	while ($mysqli->next_result());
	
	$stRet = "<?xml version=\"1.0\" ?" . "> ";
	$stRet .= "<ChannelList> ";
	while ($cid = $chres->fetch_assoc()) {
		$description = utf8_encode(htmlspecialchars($cid['Description'], 16+8));//ENT_XML1+ENT_SUBSTITUTE
		$stRet .= "<Channel> ";
		$stRet .= "<cid> " . $cid['id'] . "</cid> ";
		$stRet .= "<favicon> " . $cid['favicon'] . " </favicon> ";
		$stRet .= "<name> " . $cid['Name'] . " </name> ";
		$stRet .= "<desc> " . $description ." </desc> ";
		$stRet .= "<active> ";
		if ($profid == -2 || $profid == -3 || $profid == -6 || $profid == -5 || is_null($cid['ProfileID']) == false)
			$stRet .= "1";
		else
			$stRet .= "0";
		$stRet .= " </active> ";
		$stRet .= "</Channel> ";
	}
	$stRet .= "</ChannelList> ";
	
	echo $stRet;
?>