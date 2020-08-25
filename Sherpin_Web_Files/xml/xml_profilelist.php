<?php
	session_start();
	
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header("Content-type: text/xml");

	$stRet = "<?xml version=\"1.0\" ?" . "> ";
	$stRet .= "<ProfList> ";
	//Download the user's profile list in XML format
	$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
	if ($mysqli->connect_errno) {
		$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
	}
	$mysqli->select_db("mediabup");

	//$conn = mysql_connect("fb-db2.sherpin.com", "mediabup", "Buhner19") or die("Failed to connect: " . mysql_error());
	//mysql_select_db("mediabup") or die("Failed to select db: " . mysql_error($conn));
	
	$uid = -1;
	$profid = -1;
	if (isset($_SESSION['USER_ID']) && $_SESSION['USER_ID'] != "-1") {
		 $uid = (int)$_SESSION['USER_ID'];
		 $ures = $mysqli->query("call GetLastProfileByID(".$uid.");") or die("error5: ".$mysqli->error);
		 $urow = $ures->fetch_assoc();
		 $profid = $urow['LastProfile'];
		 while ($mysqli->next_result());
	}
	elseif (isset($_REQUEST['FBID']))
	{
		 $fbid = (int)$_REQUEST['FBID'];
		 $ures = $mysqli->query("call GetLastProfileByName('".$fbid."');") or die("error6: ".$mysqli->error);
		 $urow = $ures->fetch_assoc();
		 $uid = $urow['ID'];
		 $profid = $urow['LastProfile'];
		 while ($mysqli->next_result());
	}
	if ($profid == null)
		$profid = -1;
		
	if ($uid != "-1") {
		$ppres = $mysqli->query("select ProfilePicUrl from Users where ID=".$uid.";");
		$ppitems = $ppres->fetch_assoc();
		$profpic = $ppitems['ProfilePicUrl'];
		while ($mysqli->next_result());
		
		if ($profpic == null || strlen($profpic) == 0) {
			$profpic = "https://www.sherpin.com/Images/Sherpin_Button.jpg";
		}
	}
	
	//Check how many items in the user's backpack
	$bpres = $mysqli->query("call GetUserBackpackCount(".$uid.");") or die("error1: ".$mysqli->error);
	$bpitems = $bpres->fetch_assoc();
	$bpcount = $bpitems['BPCount'];
	while ($mysqli->next_result());

	//Get the system profiles
	$sql = "select ID, Name, Description, ProfileList, FacebookPic, LoggedIn from SystemProfiles where ProfileList=1 order by PresentationOrder;";
	$pres = $mysqli->query($sql) or die("error (".$sql."): ".$mysqli->error);
	while ($pid = $pres->fetch_assoc()) {
		if ($pid['ProfileList'] == 1 && (($pid['LoggedIn'] == 1 && $uid != "-1") || $pid['LoggedIn'] == 0)) {
			$stRet .= "<Prof>";
			$stRet .= "<pid>".$pid['ID']."</pid>";
			if ($pid['ID'] == -1) {
				$stRet .= "<count>".$bpcount."</count>";
			}
			$stRet .= "<name>".$pid['Name']."</name>";
			$stRet .= "<checked>0</checked>";
			$stRet .= "<desc>".$pid['Description']."</desc>";
			if ($pid['FacebookPic'] == 1) {
				$stRet .= "<icon>".$profpic."</icon>";
			}
			else {
				$stRet .= "<icon>https://www.sherpin.com/Images/Sherpin_Button.jpg</icon>";
			}
			$stRet .= "</Prof>";
		}
	}
	while ($mysqli->next_result());
	
	$sql = "call GetUserProfiles(".$uid.", ".$profid.");";
	$pres = $mysqli->query($sql) or die("error (".$sql."): ".$mysqli->error);
	while ($mysqli->next_result());
	//Now add the user's sherpas
	while ($pid = $pres->fetch_assoc()) {
		$stRet .= "<Prof> ";
		$stRet .= "<pid> " . $pid['ProfileID'] . "</pid> ";
		$stRet .= "<name> " . htmlspecialchars($pid['Name']) . " </name> ";
		$stRet .= "<checked> " . $pid['LastProfile'] . " </checked> ";
		$stRet .= "<desc> " . $pid['Description'] . " </desc> ";
		if ($pid['Path'] == null) {
			$resicon = $mysqli->query("call GuessProfileIcon(".$pid['ProfileID'].");") or die("error 3: ".$mysqli->error);
			while ($mysqli->next_result());
			if ($iconrow = $resicon->fetch_assoc()) {
				if ($iconrow['Path'] != null)
					$stRet .= "<icon>" . $iconrow['Path'] . "</icon>";
				else
					$stRet .= "<icon>https://www.sherpin.com/Images/Sherpin_Button.jpg</icon>";
			}
			else
				$stRet .= "<icon>https://www.sherpin.com/Images/Sherpin_Button.jpg</icon>";
		}
		else
			$stRet .= "<icon>".$pid['Path']."</icon>";
		$stRet .= "</Prof> ";
	}
	$stRet .= "</ProfList> ";
	
	echo $stRet;
?>