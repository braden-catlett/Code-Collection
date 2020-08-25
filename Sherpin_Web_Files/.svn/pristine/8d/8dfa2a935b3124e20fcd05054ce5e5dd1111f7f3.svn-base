<?php
	session_start();
	
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header("Content-type: text/xml");

	$stRet = "<?xml version=\"1.0\" ?" . "> ";

	$passwordkey = 'JTADPmqRju';
	$length = 10;
  
	if (isset($_SESSION['USER_ID']) && isset($_REQUEST['np']) && isset($_REQUEST['cp']) && $_REQUEST['np'] == $_REQUEST['cp']) {
		$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
		if ($mysqli->connect_errno) {
			$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
		}
		$mysqli->select_db("mediabup");

		$res = $mysqli->query("call VerifyPassword(".$_SESSION['USER_ID'].", '" . $_REQUEST['op'] . "', '" . $passwordkey . "', " . ($length+1) . ", " . (2*$length) . ");");
		while ($mysqli->next_result());
		$row = $res->fetch_assoc();
		if (!$row) {
			$stRet .= "<error reason='incorrect password' />";
		}
		else {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$passwordpre = '';
			$passwordpost = '';
			for ($p = 0; $p < $length; $p++) {
				$passwordpre .= $characters[mt_rand(0, strlen($characters))];
				$passwordpost .= $characters[mt_rand(0, strlen($characters))];
			}
			$newpwd = $passwordpre . $_REQUEST['np'] . $passwordpost;
			$res = $mysqli->query("call UpdatePassword(".$_SESSION['USER_ID'] . ", '" . $newpwd . "', '" . $passwordkey . "');");
			while ($mysqli->next_result());
			$stRet .= "<success/>";
		}
	}
	else {
		$stRet .= "<error reason='invalid password' />";
	}
	
	echo $stRet;
?>