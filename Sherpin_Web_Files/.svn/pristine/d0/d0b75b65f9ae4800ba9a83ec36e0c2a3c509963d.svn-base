<?php
	session_start();
	
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header("Content-type: text/xml");

	$stRet = "<?xml version=\"1.0\" ?" . "> ";
	$passwordkey = 'JTADPmqRju';
	$length = 10;
	//Download the user's video list in XML format
	$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
	if ($mysqli->connect_errno) {
		$stRet.= "<error number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
	}
	$mysqli->select_db("mediabup");
	
	$pwd = "";
	$uname = str_replace("'", "''", $_POST['uname']);
	if (isset($_POST['pwd'])) {
		$pwd = str_replace("'", "''", $_POST['pwd']);
	}
	$kws = "";
	if (isset($_POST['kws'])) {
		$kws = $_POST['kws'];
	}
	$email = "";
	if (isset($_POST['email'])) {
		$email = $_POST['email'];
	}

	//First see if this username and password are stored in our database
	if (strlen($pwd) != 0)
		$sql = "call UserLoginPwd('".$uname."', '".$pwd."', '".$passwordkey."', ".($length+1).", ".(2*$length).");";
	else
		$sql = "call UserLoginNoPwd('".$uname."', '".$passwordkey."');";
	$res = $mysqli->query($sql) or die("error: ".$mysqli->error);
	while ($mysqli->next_result());
	if ($res->num_rows > 0) {
		$id = $res->fetch_assoc();
		$uid = $id['ID'];
		$fbook = $id['Keylen'] == 0 ? "1" : "0";
		$_SESSION['USER_ID'] = $uid;
		$stRet .= "<user name='".$uname."' id='";
		$stRet .= $uid . "' ";
		$stRet .= "facebook='" . $fbook . "'/>";

		$mysqli->query("call UpdateLastLoggedIn(".$uid.");");
		while ($mysqli->next_result());
	}
	else {
		$res = $mysqli->query("call GetUserID('".$uname."');");
		while ($mysqli->next_result());
		$urow = $res->fetch_assoc();
		if ($urow == null) {
			//new user
			if (strlen($pwd) == 0) {
				$sql = "call AddFacebookUser('" . $uname . "');";
				$fbook = 1;
			}
			else {
				$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$lastchar = strlen($characters)-1;
				$verification = '';
				$passwordpre = '';
				$passwordpost = '';
				for ($p = 0; $p < 45; $p++) {
					$verification .= $characters[mt_rand(0, $lastchar)];
				}
				for ($p = 0; $p < $length; $p++) {
					$passwordpre .= $characters[mt_rand(0, $lastchar)];
					$passwordpost .= $characters[mt_rand(0, $lastchar)];
				}
				$sql = "call AddSherpinUser('" . $uname . "', '" . $passwordpre . $pwd . $passwordpost . "', '" . $passwordkey . "', '" . $verification . "')";
				$fbook = 0;

				//email verification
				$msg = "Welcome to Sherpin.com! Please click on <a href='http://www.sherpin.com/verification.php?v=".$verification."'>this link</a> to verify your email address and get started";
				error_log("sending email to ".$uname);
				error_log($msg);
				$m = mail($uname, "Welcome to Sherpin.com", $msg, "From: noreply@sherpin.com");
				error_log("sent email? " . $m);
			}
			$res = $mysqli->query($sql);
			while ($mysqli->next_result());
			$res = $mysqli->query("call GetUserID('".$uname."');");
			while ($mysqli->next_result());
			$urow = $res->fetch_assoc();
			$uid = $urow['ID'];
			$_SESSION['USER_ID'] = $uid;
			$stRet .= "<user name='".$uname."' id='" . $uid . "' facebook='".$fbook."' />";
		}
		else {
			$stRet .= "<error>wrong password</error>";
		}
	}
	
	//Now update the user keywords, if given
	if (strlen($kws) > 0) {
		$sql = "DELETE FROM UserInterests WHERE UserID=".$uid.";";
		$res = $mysqli->query($sql);
		$rgkw = explode(",", $kws);
		for ($i=0; $i<count($rgkw); $i++) {
			$kw = str_replace(" ", "+", trim($rgkw[$i]));
			$kw = $mysqli->real_escape_string($kw);
			$sql = "INSERT IGNORE INTO Keywords (Keyword) VALUE ('".$kw."');";
			$res = $mysqli->query($sql);

			$sql = "SELECT id FROM Keywords WHERE Keyword = '".$kw."';";
			$res = $mysqli->query($sql);
			$row = $res->fetch_assoc();
			$kwid = $row["id"];
			
			$sql = "INSERT IGNORE INTO UserInterests (UserID, KeywordID) VALUES (".$uid.", ".$kwid.");";
			$res = $mysqli->query($sql);
		}
		$mysqli->query("call UpdateUserInterests(".$uid.", '".$kws."')");
		while ($mysqli->next_result());
	}
	
	//finally, update the email, if given
	if (strlen($email) > 0) {
		$mysqli->query("call UpdateUserEmail(".$uid.", '".$email."');");
		while ($mysqli->next_result());
	}
	
	echo $stRet;
?>