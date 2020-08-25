<?php
	session_start();
	
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header("Content-type: text/xml");
	
	$stRet = "<?xml version=\"1.0\" ?" . "> ";
	unset($_SESSION['USER_ID']);
	unset($_SESSION['USER_NAME']);
	$stRet .= "<result msg='success' />";

	echo $stRet;
?>