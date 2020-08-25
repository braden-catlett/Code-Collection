<?php
	session_start();
	
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header("Content-type: text/xml");

	$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
	if ($mysqli->connect_errno) {
		$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
	}
	$mysqli->select_db("mediabup");
	
	$res = $mysqli->query("call GetIconList(".$_REQUEST["ProfID"].");");
	while ($mysqli->next_result());
	
	$stRet = "<?xml version=\"1.0\" ?" . "> ";
	$stRet .= "<IconList> ";

	while (($row = $res->fetch_assoc()) != false) {
		$stRet .= "<Icon> ";
		$checked = "0";
		if ($row['ProfileIconID'] != null)
			$checked = "1";
		$stRet .= "<Path id='".$row['ID']."' checked='" . $checked . "' alttext='" . $row['AltText'] . "'>".$row['Path']."</Path> ";
		$stRet .= "</Icon> ";
	}
	
	$stRet .= "</IconList>";
	echo $stRet;
?>