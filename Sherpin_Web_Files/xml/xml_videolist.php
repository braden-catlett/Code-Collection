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
	if (intval($profid) < 0) {
		$profidres = $mysqli->query("select Name, StoredProc, LoggedIn from SystemProfiles where ID=".$profid.";");
		while ($mysqli->next_result());
		$profrow = $profidres->fetch_assoc();
		$sql  = "call ".$profrow['StoredProc']."(";
		if ($profrow['LoggedIn'] == 1) { $sql .= $uid.", "; }
		$sql .= $startrow.", ".($startrow + $rowlimit).", ".$mobile.");";	
		$stRet .= "<VideoList ProfName='".$profrow['Name']."'> ";
	}
	else {
		//read from specific user sherpa
		if ($mobile == 0) $mobile = 2;
		$pnres = $mysqli->query("call GetProfileDetails(".$profid.");");
		while ($mysqli->next_result());
		$pnrow = $pnres->fetch_assoc();
		$profname = str_replace("'", "&apos;", $pnrow['Name']);
	
		$sql = "call GetVideoList(".$uid.", ".$profid.", ".$startrow.", ".($startrow+$rowlimit).", ".$mobile.");";
		$stRet .= "<VideoList ProfName='".$profname."'> ";
		
		//Now, update the LastViewed attributes
		$videores = $mysqli->query("update Users set LastProfile=".$profid." where ID=".$uid.";");
		while ($mysqli->next_result());
		$videores = $mysqli->query("update UserProfiles set LastViewed=CURRENT_TIMESTAMP where ProfileID=".$profid.";");
		while ($mysqli->next_result());
	}

	$videores = $mysqli->query($sql);
	while ($mysqli->next_result());
	while (($vid = $videores->fetch_assoc()) != null) {
		$description = utf8_encode(htmlspecialchars($vid['Description'], 16+8));//ENT_XML1+ENT_SUBSTITUTE
		$arr = array_chunk(split(" ", $description), 15);
		$ending = (count($arr) > 1) ? " ..." : "";
		$desc = implode(" ", $arr[0]).$ending;
		$stRet .= "<Video new='".$vid['NewVid']."' pinned='".$vid['Pinned']."'> ";
		$stRet .= "<favicon> " . $vid['favicon'] . " </favicon> ";
		$stTitle = utf8_encode(htmlspecialchars($vid['Title'], 16+8));//ENT_XML1+ENT_SUBSTITUTE
		$stRet .= "<Title> " . $stTitle . " </Title> ";
		$stRet .= "<ID> " . $vid['ID'] . " </ID> ";
		$stRet .= "<ProfID>".$vid['ProfileID']."</ProfID>";
		$stRet .= "<Desc><![CDATA[".$desc."]]></Desc>";
		$stRet .= "<Description><![CDATA[".$description."]]></Description>";
		$urlres = $mysqli->query("call GetVideoDetails(" . $vid['ID'] . ");");
		while ($mysqli->next_result());
		if (($vuri = $urlres->fetch_assoc()) != null) {
			$stRet .= "<URI> " . utf8_encode(htmlspecialchars($vuri['URIEmbedded'], 16+8)) . " </URI> ";
		}
		$stRet .= "<Thumbnail>".$vid['tnail']."</Thumbnail>";
		$stRet .= "</Video> ";
	}
	$stRet .= "</VideoList> ";
	
	echo $stRet;
?>