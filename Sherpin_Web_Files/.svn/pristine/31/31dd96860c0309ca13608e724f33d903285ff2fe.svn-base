<?php
	session_start();
	
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header("Content-type: text/xml");

	//Download the requested profile name in XML format
	$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
	if ($mysqli->connect_errno) {
		$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
	}
	$mysqli->select_db("mediabup");

	$stRet = "<Profile>error: invalid user</Profile>";
	if (isset($_REQUEST['ProfID'])) {
		$profid = (int)$_REQUEST['ProfID'];

		if ($profid == -2) {
			$stRet = "<?xml version=\"1.0\" ?" . "> ";
			$stRet .= "<Profile> ";
			$stRet .= "<Name>Trending</Name> ";
			$stRet .= "<Desc>Videos for what's trending now</Desc> ";
			$stRet .= "</Profile> ";
		}
		elseif ($profid == -3) {
			$stRet = "<?xml version=\"1.0\" ?" . "> ";
			$stRet .= "<Profile> ";
			$stRet .= "<Name>User Interests</Name> ";
			$stRet .= "<Desc>Videos based on your personal interests</Desc> ";
			$stRet .= "</Profile> ";
		}
		else {
			//Make sure the user is logged in
			if (isset($_SESSION['USER_ID'])) {
				//Now make sure the user owns this profile
				$res = $mysqli->query("call GetUserIdForProfile(".$profid.");");
				while ($mysqli->next_result());
				$row = $res->fetch_assoc();
				if ($row != null && $row['UserID'] == $_SESSION['USER_ID']) {	
					$pres = $mysqli->query("call GetProfileDetails(".$profid.");");
					while ($mysqli->next_result());
					$pid = $pres->fetch_assoc();
					$stRet = "<?xml version=\"1.0\" ?" . "> ";
					$stRet .= "<Profile> ";
					$stRet .= "<Name> ";
					$stRet .= htmlspecialchars($pid['Name']);
					$stRet .= "</Name> ";
					$stRet .= "<Desc> ";
					$stRet .= htmlspecialchars($pid['Description']);
					$stRet .= "</Desc> ";
					$stRet .= "</Profile> ";
				}
			}
		}
	}
	else
		$stRet = "<Profile>error: no id given</Profile>";
  
	echo $stRet;
?>