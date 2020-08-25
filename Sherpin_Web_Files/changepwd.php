<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
</head>

<div style="padding:10px; background:#fff">

<div style="position:absolute;top:2px;left:2px">
<img src="Images/Login.jpg" width="35px" alt="Login"/>
</div>
<div style="position:absolute;top:100;left:0;text-align:center;">
<p style="text-align:center">Change your password</p>
<table border="0">
<tr><td>old password:</td><td><input type="password" name="oldpwd" id="oldpwd"/></td></tr>
<tr><td>new password:</td><td><input type="password" name="newpwd" id="newpwd"/></td></tr>
<tr><td>confirm password:</td><td><input type="password" name="confirmpwd" id="confirmpwd"/></td></tr>
<tr><td colspan="2" style="text-align:center">
<a style="font-family:Calibri; color:White" href="#" onclick="changepwd('oldpwd', 'newpwd', 'confirmpwd', 'banner');"><img src="/Images/shlogin.png" alt="login" style="vertical-align:text-top"></a>
</td></tr>
<tr><td colspan="2"><span id="banner" style="text-align:center; font-style=italic; font-family:Calibri; color:Red; font-size:large"></span></td>
</tr>
</table>
</div>
