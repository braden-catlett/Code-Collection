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

	$videoid = $_REQUEST['VideoID'];
	if (isset($_REQUEST['StartRow']))
		$startrow = (int)$_REQUEST['StartRow'];
	else
		$startrow = 0;
	if (isset($_REQUEST['RowLimit']))
		$rowlimit = (int)$_REQUEST['RowLimit'];
	else
		$rowlimit = 200;
	if (isset($_SESSION['USER_ID']))
		$userid = (int)$_SESSION['USER_ID'];
	else
		$userid = -1;
    
	$stRet = "<?xml version=\"1.0\" ?" . "> ";
	if ($mobile == 0) $mobile = 2;
		
	$channelid = 1;
  
	//First get the details on the shared video
	$videores = $mysqli->query("call GetVideoDetailsExtended(".$videoid.");");
	while ($mysqli->next_result());
	$invalids = array(chr(0x19));
	if ($vid = $videores->fetch_assoc()) {
		$title = str_replace($invalids, "", $vid['Title']);
		$title = str_replace("'", "&apos;", $title);
		$title = utf8_encode(htmlspecialchars($title, 16+8));	//ENT_SUBSTITUTE + ENT_XML1
		$stRet .= "<VideoList SharedTitle='".$title."'> ";

		$channelid = $vid['ChID'];
		$description = str_replace($invalids, "", $vid['Description']);
		$arr = array_chunk(split(" ", $description), 15);
		$ending = (count($arr) > 1) ? " ..." : "";
		$desc = implode(" ", $arr[0]).$ending;
		$stRet .= "<Video new='0' pinned='" . $vid['Pinned'] . "' shared='1'> ";
		$stRet .= "<favicon> " . $vid['favicon'] . " </favicon> ";
		$stRet .= "<Title> " . $title . " </Title> ";
		$stRet .= "<ID> " . $vid['VidID'] . " </ID> ";
		$stRet .= "<ProfID>0</ProfID>";
		$stRet .= "<Desc><![CDATA[".$desc."]]></Desc>";
		$stRet .= "<Description><![CDATA[".$description."]]></Description>";
		$urlres = $mysqli->query("call GetVideoDetails(" . $vid['VidID'] . ");");
		while ($mysqli->next_result());
		if (($vuri = $urlres->fetch_assoc()) != null) {
			$stRet .= "<URI> " . htmlentities($vuri['URIEmbedded']) . " </URI> ";
		}
		$stRet .= "<Thumbnail>".$vid['ThumbnailURL']."</Thumbnail>";
		$stRet .= "</Video> ";
	}
	
	//Now get the details on the related videos
	$videores = $mysqli->query("call GetRelatedVideoList(".$userid.", ".$videoid.", ".$channelid.", ".$mobile.");");
	while ($mysqli->next_result());
	$invalids = array(chr(0x19));
	while ($vid = $videores->fetch_assoc()) {
		$description = str_replace($invalids, "", $vid['D']);
		$arr = array_chunk(split(" ", $description), 15);
		$ending = (count($arr) > 1) ? " ..." : "";
		$desc = implode(" ", $arr[0]).$ending;
		$stRet .= "<Video new='0' pinned='" . $vid['Pinned'] . "' shared='0'> ";
		$stRet .= "<favicon> " . $vid['favicon'] . " </favicon> ";
		$title = str_replace($invalids, "", $vid['Title']);
		$title = str_replace("'", "&apos;", $title);
		$stRet .= "<Title> " . utf8_encode(htmlspecialchars($title, 16+8)) . " </Title> "; //ENT_SUBSTITUTE + ENT_XML1
		$stRet .= "<ID> " . $vid['ID'] . " </ID> ";
		$stRet .= "<ProfID>0</ProfID>";
		$stRet .= "<Desc><![CDATA[".$desc."]]></Desc>";
		$stRet .= "<Description><![CDATA[".$description."]]></Description>";
		$urlres = $mysqli->query("call GetVideoDetails(" . $vid['ID'] . ");");
		while ($mysqli->next_result());
		if (($vuri = $urlres->fetch_assoc()) != null) {
			$stRet .= "<URI> " . htmlentities($vuri['URIEmbedded']) . " </URI> ";
		}
		$stRet .= "<Thumbnail>".$vid['tnail']."</Thumbnail>";
		$stRet .= "</Video> ";
	}
	$stRet .= "</VideoList> ";
	
	echo $stRet;
?>