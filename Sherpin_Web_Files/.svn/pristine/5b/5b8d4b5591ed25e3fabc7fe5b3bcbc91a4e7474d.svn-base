<?php
session_start();

$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
if ($mysqli->connect_errno) {
	$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
}
$mysqli->select_db("mediabup");

if (isset($_REQUEST['c'])) {
	$comment = strip_tags(str_replace("'", "''", $_REQUEST['c']));
	$name = strip_tags(str_replace("'", "''", $_REQUEST['n']));
	$email = strip_tags(str_replace("'", "''", $_REQUEST['e']));

	$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
	$mysqli->select_db("mediabup");
	$sql = "INSERT INTO Feedback (Name, Email, Comments, DateAdded) VALUES (";
	$sql .= "'".$name."', ";
	$sql .= "'".$email."', ";
	$sql .= "'".$comment."', now());";
	$mysqli->query($sql);
}

header("Content-type: text/xml");

$stRet = "<?xml version=\"1.0\" ?" . "> ";
$stRet .= "<result>success</result>";
echo $stRet;
?>