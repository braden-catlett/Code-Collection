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
	if (isset($_REQUEST['StartRow']))
		$startrow = (int)$_REQUEST['StartRow'];
	else
		$startrow = 0;
	if (isset($_REQUEST['RowLimit']))
		$rowlimit = (int)$_REQUEST['RowLimit'];
	else
		$rowlimit = 200;
    
	$stRet = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?> ";
	if ($profid == "-1") {
		$stRet .= "<VideoList ProfName='My Backpack'> ";
		//read from backpack
		$sql = "call GetBackpackList(".$uid.", ".$startrow.", ".($startrow + $rowlimit).", ".$mobile.");";
	}
	else {
		//read from specific user sherpa
		if ($mobile == 0) $mobile = 2;
		$pnres = $mysqli->query("call GetProfileDetails(".$profid.");");
		while ($mysqli->next_result());
		$pnrow = $pnres->fetch_assoc();
		$profname = $pnrow['Name'];
		$stRet .= "<VideoList ProfName='".$profname."'> ";
	
		$sql = "call GetVideoList(".$uid.", ".$profid.", ".$startrow.", ".($startrow+$rowlimit).", ".$mobile.");";
	}

	$videores = $mysqli->query($sql);
	while ($mysqli->next_result());
	while (($vid = $videores->fetch_assoc()) != null) {
		$stRet .= "<Video new='".$vid['NewVid']."' pinned='".$vid['Pinned']."'> ";
		$stRet .= "<favicon> " . $vid['favicon'] . " </favicon> ";
		$stTitle = utf8_encode(htmlspecialchars($vid['Title'], 16+8));//ENT_XML1+ENT_SUBSTITUTE
		$stRet .= "<Title> " . $stTitle . " </Title> ";
		$stRet .= "<ID> " . $vid['ID'] . " </ID> ";
		$kwres = $mysqli->query("call GetVideoProfileKeywords(".$vid['ID'].", ".$profid.");");
		while ($mysqli->next_result());
		$kwrow = $kwres->fetch_assoc();
		if ($kwrow != null) {
			$stRet .= "<Keywords>";
			while ($kwrow != null) {
				$stRet .= "<Keyword>".htmlspecialchars($kwrow['Keyword'])."</Keyword>";
				$kwrow = $kwres->fetch_assoc();
			}
			$stRet .= "</Keywords>";
		}
		$stRet .= "</Video> ";
	}
	$stRet .= "</VideoList> ";
	
	echo $stRet;
?>