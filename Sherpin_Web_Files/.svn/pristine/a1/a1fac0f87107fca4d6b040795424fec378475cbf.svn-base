<?php
	session_start();
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header("Content-type: text/xml");

	//Download the user's video list in XML format
	$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
	if ($mysqli->connect_errno) {
		$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
	}
	$mysqli->select_db("mediabup");

	$uid = -1;
	if (isset($_SESSION['USER_ID']))
		$uid = (int)$_SESSION['USER_ID'];
	elseif (isset($_REQUEST['FBID']))
	{
		$fbid = (int)$_REQUEST['FBID'];
		$ures = $mysqli->query("SELECT ID FROM Users WHERE Name='".$fbid."';");
		while ($mysqli->next_result());
		$urow = $ures->fetch_assoc();
		$uid = $urow['ID'];
	}
  
	$mobile='0';
	if (isset($_REQUEST['Mobile']))
		$mobile = (int)$_REQUEST['Mobile'];
  
	$resprof = mysql_query("SELECT ProfileID, Name, Description FROM UserProfiles WHERE UserID=".$uid.";");
	$profcount = mysql_num_rows($resprof);
	$stRet = "<?xml version=\"1.0\" ?" . "> ";
	$stRet .= "<GuideTopList> ";
	while ($profcount > 0) {
		$prof = mysql_fetch_row($resprof);
		$profid = $prof[0];

		$sql = "call ProfileVideoSamp(".$uid.", ".$profid.", ".$mobile.");";
		$res = mysql_query($sql) or die("Failed to execute stored procedure: " . mysql_error($conn));
		$videores = mysql_query("SELECT favicon, Title, ID FROM uvs;") or die("Failed to execute query: " . mysql_error($conn));

		$rowcount = mysql_num_rows($videores);
		$stRet .= "<VideoList Profile='".$prof[1]."' ID='".$prof[0]."'> ";
		$stRet .= "<ProfDesc>" . $prof[2] . "</ProfDesc>";
		while ($rowcount > 0) {
			$stRet .= "<Video> ";
			$vid = mysql_fetch_row($videores);
			$stRet .= "<favicon> " . $vid[0] . " </favicon> ";
			$stRet .= "<Title> " . htmlspecialchars($vid[1]) . " </Title> ";
			$stRet .= "<ID> " . $vid[2] . " </ID> ";
			$urlres = mysql_query("SELECT URIEmbedded FROM Videos WHERE ID = " . $vid[2] . ";") or die("Failed to find URI: " . mysql_error($conn));
			if (mysql_num_rows($urlres) > 0) {
				$vuri = mysql_fetch_row($urlres);
				$stRet .= "<URI> " . htmlentities($vuri[0]) . " </URI> ";
			}
			$stRet .= "</Video> ";
			$rowcount = $rowcount-1;
		}
		$stRet .= "</VideoList> ";

		$profcount = $profcount-1;
	}
	$stRet .= "</GuideTopList> ";
  
	mysql_query("COMMIT;");
	
	echo $stRet;
?>