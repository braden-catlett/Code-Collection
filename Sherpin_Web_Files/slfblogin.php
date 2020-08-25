<?php
require_once './facebook/facebook.php';
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
	<?php
		$accesstoken = "";
		$errordescription = "";

   $app_id = "326133152009";
   $app_secret = "046b6f98c4efa02b6da0ee3e00ea1f96";
   $my_url = "/slfblogin.php";

   $code = $_REQUEST["code"];

   if(empty($code)) {
     $dialog_url = "https://www.facebook.com/dialog/oauth?client_id=" 
       . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
       . $_SESSION['state'];

     echo("<script> top.location.href='" . $dialog_url . "'</script>");
   }

   else {
     $token_url = "https://graph.facebook.com/oauth/access_token?"
       . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
       . "&client_secret=" . $app_secret . "&code=" . $code;

     $response = file_get_contents($token_url);
     $params = null;
     parse_str($response, $params);
   }

	?>
</head>
<body>
    <script type="text/javascript">
        window.opener.LoginComplete('<?php echo $params['access_token']; ?>', '');
    </script>
</body>
</html>
