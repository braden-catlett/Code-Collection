<?php
	session_start();
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header("Content-type: text/xml");

	//Download the user's video list in XML format
	$conn = mysql_connect("fb-db2.sherpin.com", "mediabup", "Buhner19") or die("Failed to connect: " . mysql_error());
	mysql_select_db("mediabup") or die("Failed to select db: " . mysql_error($conn));

	$stRet = "<?xml version=\"1.0\" ?" . "> ";
	$stRet .= "<VideoList> ";
	if (isset($_SESSION['USER_ID'])) {
		$uid = $_SESSION['USER_ID'];
		$sql = "call UserVideoList(".$uid.");";
		$res = mysql_query($sql) or die("Failed to execute stored procedure: " . mysql_error($conn));
		//We only want the TV Guide data
		$videores = mysql_query("SELECT favicon, Title, ID FROM uvl WHERE favicon='http://www.tvdata.com/favicon.ico';") or die("Failed to execute query: " . mysql_error($conn));
		
		$rowcount = mysql_num_rows($videores);
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
	}
	$stRet .= "</VideoList> ";
	
	echo $stRet;
?>