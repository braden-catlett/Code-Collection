<script type="text/javascript" src="https://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript" src="/script/cookies.js"></script>
<script type="text/javascript" src="/script/userinfo.js"></script>

<div class="primary" id="loginbuttons" style="visibility:visible; width:95%; padding-top:3px; padding-bottom:3px">
<p style="text-align:right; font-family:Calibri; color:White; font-size:small">
    User Name: <input id="txtuname" type="text" size="12" style="font-size:small" /><br/>
    Password: <input id="txtpwd" type="password" size="12" style="font-size:small" /><br />
  <span id="txterror" style="text-align:center; font-style=italic; font-family:Calibri; color:White; font-size:large"/>
</p>
<table style="text-align:center; width:95%">
  <tr>
  <td><img src="/Images/fblogin.png" alt="login" style="vertical-align:text-top;cursor:pointer" onclick="FB.login(getlogininfo)"></td>
  <td><img src="/Images/shlogin.png" alt="login" style="vertical-align:text-top;cursor:pointer" onclick="login('txtuname', 'txtpwd', 'txterror', 1)"></td>
  </tr>
</table>
</div>