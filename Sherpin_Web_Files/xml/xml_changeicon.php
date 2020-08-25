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

	//Make sure the user is logged in
	if (isset($_SESSION['USER_ID']) && isset($_REQUEST['IconID']) && isset($_REQUEST['ProfID'])) {
		//Now make sure the user owns this profile
		$res = $mysqli->query("call VerifyUserProfile(" . $_SESSION['USER_ID'] . ", " . $_REQUEST['ProfID'] . ");");
		while ($mysqli->next_result());
		if ($res->fetch_assoc()) {
			$mysqli->query("call UpdateProfileIcon(". $_REQUEST['ProfID'] . ", " . $_REQUEST['IconID'] . ");");
			while ($mysqli->next_result());
		}
	}

	echo "<result>success</result>";
?>