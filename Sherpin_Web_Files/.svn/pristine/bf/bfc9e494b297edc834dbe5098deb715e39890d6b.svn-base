<?php
	session_start();

	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header("Content-type: text/xml");
  
	include '../lib/MobileDetect.php';
	$detect = new Mobile_Detect();

	//Download the user's video list in XML format
	$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
	if ($mysqli->connect_errno) {
		$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
	}
	$mysqli->select_db("mediabup");

	$mobile=2;  //2 is for desktop, 1 is for mobile device
	if (isset($_REQUEST['Mobile']))
		$mobile = (int)$_REQUEST['Mobile'];
  
	if ($mobile == 2)
	{
		//confirm that we're running on a desktop computer
		if ($detect->isMobile())
			$mobile = 1;
	}
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
	if (isset($_REQUEST['ProfID']))
		$profid = (int)$_REQUEST['ProfID'];
	else
	{
		$profidres = $mysqli->query("call GetLastProfileByID(".$uid.");");
		while ($mysqli->next_result());
		$profrow = $profidres->fetch_assoc();
		$profid = $profrow['LastProfile'];
	}
	$startrow = 0;
	$rowlimit = 200;
    
	$stRet = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?> ";

	if ($mobile == 0) $mobile = 2;
	$cres = $mysqli->query("call GetNewVideoCount(".$uid.",".$profid.",".$mobile.");");
	while ($mysqli->next_result());
	$cnt = $cres->fetch_assoc();
	$stRet .= "<newcount>".$cnt['cnt']."</newcount>";
	
	echo $stRet;
?>