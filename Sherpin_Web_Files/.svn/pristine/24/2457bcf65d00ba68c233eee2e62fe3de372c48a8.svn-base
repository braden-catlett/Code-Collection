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
	if (isset($_REQUEST['Search']))
		$search = $_REQUEST['Search'];
	else
	{
		$search = "sherpin";
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
	$stRet .= "<VideoList ProfName='Quick Search: ".$search."'> ";
	$needle = array(" ", "%20", "\t");
	$search = "%".str_replace($needle, "%", $search)."%";
	$sql = "call QuickSearch('".$search."',".$startrow.", ".$rowlimit.", 2);";
	
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