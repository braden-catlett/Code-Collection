<?php
	session_start();
	
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header("Content-type: text/xml");

	$passwordkey = 'JTADPmqRju';

	//Download the user's information in XML format
	$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
	if ($mysqli->connect_errno) {
		$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
	}
	$mysqli->select_db("mediabup");

	$uid = -1;
	$profid = -1;
	if (isset($_SESSION['USER_ID']))
		$uid = $_SESSION['USER_ID'];
	else if (isset($_REQUEST['UserId']))
	{
		$_SESSION['USER_ID'] = $_REQUEST['UserId'];
		$uid = $_REQUEST['UserId'];
	}
	elseif (isset($_REQUEST['FBID']))
	{
		$ures = $mysqli->query("call GetUserID('".$_REQUEST['FBID']."');");
		while ($mysqli->next_result());
		$urow = $ures->fetch_assoc();
		$uid = $urow['ID'];
		$_SESSION['USER_ID'] = $uid;
	}
	
	$updatelogin = 0;
	if (isset($_REQUEST['Update']))
		$updatelogin = (int)$_REQUEST['Update'];
	
	if (isset($_REQUEST['UserName']))
		$_SESSION['USER_NAME'] = $_REQUEST['UserName'];
		
	$stRet = "<?xml version=\"1.0\" ?" . "> ";
	if ($uid != -1) {
		if ($updatelogin == 1) {
			$mysqli->query("call UpdateLastLoggedIn(".$uid.");");
			while ($mysqli->next_result());
		}

		if (isset($_REQUEST['email'])) {
			$mysqli->query("call UpdateUserEmail(".$uid.", '".$_REQUEST['email']."');");
			while ($mysqli->next_result());
		}

		if (isset($_REQUEST['UserPic'])) {
			$mysqli->query("call UpdateUserProfilePic(".$uid.", '".$_REQUEST['UserPic']."');");
			while ($mysqli->next_result());
		}

		$res = $mysqli->query("call GetUserDetails(".$uid.", '".$passwordkey."');");	
		while ($mysqli->next_result());
		$user = $res->fetch_assoc();
		if (is_null($user['Email']) || strlen($user['Email']) == 0)
			$needemail = "1";
		else
			$needemail = "0";
		$fbook = $user['lenkey'] == 0 ? "1" : "0";
		$stRet .= "<user id=\"".$uid."\" name=\"".$user['Name']."\" last=\"".$user['LastLoggedIn']."\" needemail=\"".$needemail."\" facebook=\"".$fbook."\" /> ";
	}
	else
		$stRet .= "<user /> ";

	
	echo $stRet;
?>