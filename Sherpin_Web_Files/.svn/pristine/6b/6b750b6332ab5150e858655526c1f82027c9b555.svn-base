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
	   
	/* Now parse the string for user id and keywords */
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
	   else if ($child->getName() == "kw")
	   {
		  $kwid = $child["id"];
		  $use = $child["use"];
		  if ($profid != "")
		  {
			 $sql = "UPDATE ProfileKeywords SET ";
			 if ($use == "0")
			 {
				$sql .= "Active=0, Exclude=0";
			 }
			 elseif ($use == "1")
			 {
				$sql .= "Active=1, Exclude=0";
			 }
			 else
			 {
				$sql .= "Active=0, Exclude=1";
			 }
			 $sql .= " WHERE ProfileID=".$profid." AND KeywordID=".$kwid.";";
			 mysql_query("START TRANSACTION;");
			 mysql_query($sql);
			 mysql_query("COMMIT;") 
			   or mysql_query("INSERT INTO tempdata VALUES ('".str_replace("'", "\\'", mysql_error($conn))."');");
		  }
	   }
	   else if ($child->getName() == "newkw")
	   {
		  $sql = "INSERT INTO Keywords (Keyword) VALUES ('" . str_replace("'", "''", $child["kw"]) . "');";
		  mysql_query("START TRANSACTION;");
		  mysql_query($sql);
		  mysql_query("COMMIT;") 
			or mysql_query("INSERT INTO tempdata VALUES ('".str_replace("'", "\\'", mysql_error($conn))."');");

		  if ($profid != "")
		  {
			 $kwres = mysql_query("SELECT ID FROM Keywords WHERE Keyword = '" . str_replace("'", "''", $child["kw"]) . "';");
			 $kwrow = mysql_fetch_row($kwres);
			 mysql_query("START TRANSACTION;");
			 $sql = "INSERT INTO ProfileKeywords VALUES (".$profid.", ".$kwrow[0];
			 if ($use == "0")
			 {
				$sql .= ",0,0);";
			 }
			 elseif ($use == "1")
			 {
				$sql .= ",1,0);";
			 }
			 else
			 {
				$sql .= ",0,1);";
			 }
			 mysql_query($sql);
			 mysql_query("COMMIT;") 
			   or mysql_query("INSERT INTO tempdata VALUES ('".str_replace("'", "\\'", mysql_error($conn))."');");
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