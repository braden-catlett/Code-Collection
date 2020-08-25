<?php
	session_start();
	
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header("Content-type: text/xml");

	//Download the user's video list in XML format
	$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
	if ($mysqli->connect_errno) {
		$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
	}
	$mysqli->select_db("mediabup");

	$videoid = $_REQUEST['VideoID'];
    
	$stRet = "<?xml version=\"1.0\" ?" . "> ";
		
	$channelid = 1;

	if (isset($_SESSION['USER_ID'])) {
		$userid = $_SESSION['USER_ID'];
		//First get the details on the shared video
		$videores = $mysqli->query("call GetVideoDetails(".$videoid.");");
		while ($mysqli->next_result());
		$vid = $videores->fetch_assoc();
		$title = str_replace("'", "''", $vid['Title']);
		$channel = str_replace("'", "''", $vid['Channel']);

		$mysqli->query("call AddUserProfile(".$userid.", '".$title."');");
		//$profid = $mysqli->insert_id;
		while ($mysqli->next_result());
		$pres = $mysqli->query("call GetProfileID(".$userid.", '".$title."');");
		while ($mysqli->next_result());
		$prof = $pres->fetch_assoc();
		$profid = $prof["ProfileID"];

		$kwres = $mysqli->query("call GetVideoKeywords(" . $videoid . ");");
		while ($mysqli->next_result());
		while ($kw = $kwres->fetch_assoc()) {
			$mysqli->query("call AddProfileKeyword(" . $profid . ", " . $kw['ID'] . ", 1, 0);"); 
			while ($mysqli->next_result());
		}

		$mysqli->query("call AddProfileChannel(" . $profid . ", " . $channel . ");");
		while ($mysqli->next_result());
		if ($channel != 1) {
			$mysqli->query("call AddProfileChannel(" . $profid . ", 1);");
			while ($mysqli->next_result());
		}
	}
	$stRet .= "<result ProfID='".$profid."'>success</result>";
	echo $stRet;
?>