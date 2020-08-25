<?php
session_start();
if (isset($_SESSION["USER_ID"])) {
	/* data comes in on the stdin stream */
	$putdata = fopen("php://input", "r");

	/* Read the data 1 KB at a time
	   and store it in a string*/
	$xml = "";
	while ($data = fread($putdata, 1024))
	   $xml = $xml . $data;
	   
	/* Now parse the string for user id and profile id*/
	$conn = mysql_connect("fb-db2.sherpin.com", "mediabup", "Buhner19") or die("Failed to connect: " . mysql_error());
	mysql_select_db("mediabup") or die("Failed to select db: " . mysql_error($conn));
	mysql_query("INSERT INTO tempdata VALUES ('updating last profile');");

	$x = simplexml_load_string($xml);

	$userid = $x["userid"];
	$fbid = $x["fbid"];
	$profid = $x["profid"];

	if (strlen($fbid) != 0) {
	  $sql = "UPDATE Users SET LastProfile=".$profid." WHERE Name='".$fbid."';";
	}
	else {
	  $sql = "UPDATE Users SET LastProfile=".$profid." WHERE ID=".$userid.";";
	}
	mysql_query("START TRANSACTION;");
	mysql_query($sql)
		 or mysql_query("INSERT INTO tempdata VALUES ('".str_replace("'", "\\'", mysql_error($conn))."');");
	mysql_query("COMMIT;") 
		 or mysql_query("INSERT INTO tempdata VALUES ('".str_replace("'", "\\'", mysql_error($conn))."');");

	/* Close the stream */
	fclose($putdata);

	mysql_close($conn);
}
header("Content-type: text/xml");

$stRet = "<?xml version=\"1.0\" ?" . "> ";
$stRet .= "<result>success</result>";
echo $stRet;
?>