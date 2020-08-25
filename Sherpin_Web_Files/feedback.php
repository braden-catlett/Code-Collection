	<script>
	function selectall(id)
	{
		document.getElementById(id).focus();
		document.getElementById(id).select();
	}
	
	function postfeedback() 
	{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				$.colorbox.close();
			}
		}
		var name = document.getElementById('txtName');
		var email = document.getElementById('txtEmail');
		var comment = document.getElementById('txtComment');
		var url = "/xml/xml_addfeedback.php?n=" + name.value + "&e=" + email.value + "&c=" + comment.value;
		xmlhttp.open("GET", url, true);
		xmlhttp.send();
	}
	</script>

	<table border="0" style="margin-left:auto; margin-right:auto">
		<tr><td colspan="7"><h1>Help us make Sherpin.com better for you</h1></td></tr>
		<tr>
		<td colspan="3" style="text-align:right">Name:</td><td colspan="4" style="text-align:left">
			<input type="text" size="50" id="txtName" name="txtName" value="your name" onclick="selectall('txtName');"/>
		</td>
		</tr>
		<tr>
		<td colspan="3" style="text-align:right">Email:</td><td colspan="4" style="text-align:left"><input type="text" size="50" id="txtEmail" name="txtEmail" value="your email" onclick="selectall('txtEmail');"/></td>
		</tr>
		<tr>
		<td colspan="3" style="text-align:right">Comments:</td><td colspan="4" style="text-align:left"><textarea id="txtComment" name="txtComment" cols="40" rows="5" onclick="selectall('txtComment');">comments</textarea></td>
		</tr>
		<tr>
		<td colspan="3" style="text-align:right">&nbsp;</td><td colspan="4" style="text-align:left"><button size="30" onclick="postfeedback();">post</button</td>
		</tr>
	</table>
