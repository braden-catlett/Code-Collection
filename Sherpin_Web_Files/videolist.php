<?php
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

	include 'lib/MobileDetect.php';
	$detect = new Mobile_Detect();

	//Download the user's video list in HTML format
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
	elseif (isset($_REQUEST['USER_ID']))
		$uid = (int)$_REQUEST['USER_ID'];
	elseif (isset($_REQUEST['FBID']))
	{
		$fbid = (int)$_REQUEST['FBID'];
		$ures = $mysqli->query("call GetUserID('".$fbid."');");
		while ($mysqli->next_results());
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
  
	$pnres = $mysqli->query("call GetProfileDetails(".$profid.");");
	while ($mysqli->next_result());
	$pnrow = $pnres->fetch_assoc();
	$profname = $pnrow['Name'];
  
	if (isset($_REQUEST['RecordCount']))
		$crec = (int)$_REQUEST['RecordCount'];
	if ($profid == "-2") {
		$profname = "Trending";
		$videores = $mysqli->query("call GetTrendingList(0, 50, ".$mobile.");");
	}
	elseif ($profid == "-3") {
		$profname = "Interests";
		$sql = "call GetUserInterestList(".$uid.", 0, 50, ".$mobile.");";
		$videores = $mysqli->query($sql) or $stRet.="<!-- error ".$mysqli->error."-->\n";
	}
	elseif ($profid == "-6") {
		$profname = "News";
		$videores = $mysqli->query("call GetHotNewsList(0, 50, ".$mobile.");");
	}
	elseif ($profid == "-5") {
		$profname = "Movies";
		$videores = $mysqli->query("call GetMovieList(0, 50, ".$mobile.");");
	}
	else {
		$sql = "call GetVideoList(".$uid.", ".$profid.", 0, 50, ".$mobile.");";
		$videores = $mysqli->query($sql);
	}
	while ($mysqli->next_result());
	
	$stRet = "<html>";
	$stRet .= "<head><link href=\"/css/metro.css\" rel=\"stylesheet\" type=\"text/css\"></head>";
	$stRet .= "<body style=\"background:#00263a\"><h1>" . $profname . " Sherpa Results</h1> ";
	$stRet .= "<ul>";
	while ($vid = $videores->fetch_assoc()) {
		$stRet .= "<li style=\"font-size:18px;vertical-align:text-bottom\">";
		$stRet .= "<img src=\"" . $vid['favicon'] . "\" style=\"margin:5px;vertical-align:text-bottom\"/>";
		$stRet.= htmlspecialchars($vid['Title']) . " </li> ";
		$kwres = $mysqli->query("call GetVideoProfileKeywords(".$vid['ID'].", ".$profid.");");
		while ($mysqli->next_result());
		$comma = 0;
		$kwrow = $kwres->fetch_assoc();
		if ($kwrow != null) {
			$stRet .= "<ul><li>";
			while ($kwrow != null) {
				if ($comma == 1) {
					$stRet .= ", ";
				}
				$stRet .= htmlspecialchars($kwrow['Keyword']);
				$comma = 1;
				$kwrow = $kwres->fetch_assoc();
			}
			$stRet .= "</li></ul>";
		}
	}
	$stRet .= "</ul>";
	$stRet .= "</body></html> ";
	
	echo $stRet;
?>