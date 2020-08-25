<?php
function spamcheck($field)
{
	$field = filter_var($field, FILTER_SANITIZE_EMAIL);
	if(filter_var($field, FILTER_VALIDATE_EMAIL))
		return TRUE;
	else
		return FALSE;
}
	if (isset($_REQUEST["address"]) && spamcheck($_REQUEST["email"])
	{
		$to = "kittiesgowild10@gmail.com";
		$subject = $_REQUEST["fullname"] . "Send Address";
		$message = "Name: " . $_REQUEST["fullname"] . "\n" . "Address: " . $_REQUEST["address"];
		$from = "someonelse@example.com";
		$headers = "From: " . $_REQUEST["fullname"];
		mail($to,$subject,$message,$headers);
		echo "<h1>Mail Sent.</h1>";
	}
?>