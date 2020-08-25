<script type="text/javascript">
	function quickadd() {
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      			window.location.reload(false);
      		}
        }
        var url = "";
        if (getloggedin() == 1)
        	url = "/xml/xml_addquickprofile.php?FBID=" + getfbid() + "&ProfName=" + sherpa.value + "&Keywords="+keywords.value
        else if (getloggedin() == 2)
        	url = "/xml/xml_addquickprofile.php?UserID=" + getsherpid() + "&ProfName=" + sherpa.value + "&Keywords="+keywords.value

		
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
	}
</script>

<div style="padding:10px; background:#fff">
<div style="position:absolute;top:2px;left:2px">
<img src="Images/Edit.jpg" width="35px" alt="Edit"/>
</div>
<div style="position:absolute;top:0;left:0;text-align:center;vertical-align:middle">
<p style="text-align:center">What do you like?</p>
<p style="text-align:center">Create your sherpa</p>

<table border="0">
<tr><td>sherpa name:</td><td><input type="text" name="sherpa" id="sherpa"/></td></tr>
<tr><td colspan="2" style="text-align:center">Keywords (separated by a comma)</td></tr>
<tr><td colspan="2" style="text-align:center">&nbsp;<textarea cols="28" rows="7" id="keywords"></textarea></td></tr>
<tr><td colspan="2" style="text-align:center"><input type="submit" value="add sherpa" onclick="quickadd()"></td></tr>
<tr><td colspan="2" style="text-align:center">Note, you can always edit your<br>sherpa from the Viewer page</td></tr>
</table>
</div>
</div>