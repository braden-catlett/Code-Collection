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
	   
	/* Now parse the string for user id and channels */
	$conn = mysql_connect("fb-db2.sherpin.com", "mediabup", "Buhner19") or die("Failed to connect: " . mysql_error());
	mysql_select_db("mediabup") or die("Failed to select db: " . mysql_error($conn));

	$x = simplexml_load_string($xml);

	$userid = "";
	$profid = "";
	foreach ($x->children() as $child)
	{
	   if ($child->getName() == "user")
	   {
		  $profid = $child["profid"];
	   }
	   else if ($child->getName() == "channel")
	   {
		  $chid = $child["id"];
		  if ($profid != "")
		  {
			 if ($child["act"] == "0")
			 {
				$sql = "DELETE FROM ProfileChannels WHERE ProfileID=".$profid." AND ChannelID=".$chid.";";
			 }
			 else
			 {
				$sql = "INSERT INTO ProfileChannels VALUES (".$profid.", ".$chid.");";
			 }
			 mysql_query("START TRANSACTION;");
			 mysql_query($sql);
			 mysql_query("COMMIT;") or mysql_query("INSERT INTO tempdata VALUES ('error');");
		  }
	   }
	}

	/* Close the stream */
	fclose($putdata);
	mysql_close($conn);
}
header("Content-type: text/xml");

$stRet = "<?xml version=\"1.0\" ?" . "> ";
$stRet .= "<result>success</result>";
echo $stRet;
?>