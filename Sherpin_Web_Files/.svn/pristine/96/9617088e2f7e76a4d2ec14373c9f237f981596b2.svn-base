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

	$admin="false";
	if (isset($_SESSION['USER_ID'])) {
		$uid = (int)$_SESSION['USER_ID'];
		$res = $mysqli->query("call GetIsAdmin(".$uid.");");
		while ($mysqli->next_result());
		$row = $res->fetch_assoc();
		if ($row)
			$admin = $row['Admin'] == 0 ? "false" : "true";
	}
	$stRet .= "<admin val='".$admin."' />";
	
	echo $stRet;
?>