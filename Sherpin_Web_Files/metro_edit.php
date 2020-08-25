<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>sherpin.com</title>
    <link rel="stylesheet" type="text/css" href="css/metro.css"/>
    <script type="text/javascript" src="/script/utils.js"></script>

    <script type="text/javascript">
        var sherpaid=<?php echo $_REQUEST["ProfID"];?>;
		var userid=<?php echo $_REQUEST["UserID"];?>;

		function getsherpaproperties() {
			getname();
			getkeywords();
			getchannels();
			getgenres();
			getvideolistpreview();
		}

        function getname() {
            var divname = document.getElementById('name');

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var xmlDoc = xmlhttp.responseXML;
                    var profile = xmlDoc.getElementsByTagName("Profile");
                    var profname = (profile[0].getElementsByTagName("Name")[0].childNodes[0].nodeValue).trim();
                    var profdesc = (profile[0].getElementsByTagName("Desc")[0].childNodes[0].nodeValue).trim();

                    divname.innerHTML = '<div><a href="metro_detail.php?UserID='+userid+'&ProfID='+sherpaid+'"><img src="Images/play.png" style="width:60px;float:right"></a></div>' +
										'<div style="width:100%"><span style="font-size:20px;vertical-align:text-bottom;width:30%">name: </span><input type="text" id="txtname" onchange="renameprof()" style="vertical-align:top;width:70%;float:right" value="' + profname + '"/></div>' +
										'<div style="width:100%"><span style="font-size:20px;vertical-align:text-bottom;width:30%">description: </span><textarea id="txtdesc" onchange="editdesc()" style="vertical-align:top;width:70%;float:right" rows="4" cols="30">' + profdesc + '</textarea></div>';
                }
            }
            var url = "/xml/xml_profilename.php?ProfID=" + sherpaid;
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
        }

		function renameprof() {
			var tb = document.getElementById("txtname");
			if (tb.value.length == 0)
				return;

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
				getvideolistpreview();
			}
            var url = "/xml/xml_renameprofile.php?ProfID=" + sherpaid + "&ProfName=" + tb.value;
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
		}

		function editdesc() {
			var tb = document.getElementById("txtdesc");
			if (tb.value.length == 0)
				return;

            var xmlhttp = new XMLHttpRequest();
            var url = "/xml/xml_editprofiledesc.php?ProfID=" + sherpaid + "&ProfDesc=" + tb.value;
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
		}

        function getkeywords() {
            var divkw = document.getElementById('keywords');

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var xmlDoc = xmlhttp.responseXML;
                    var kws = xmlDoc.getElementsByTagName("KW");
					var html = '<div style="width:70%;margin-left:20px;margin-top:20px;margin-right:20px;margin-bottom:10px;font-size:28px">keywords</div>';
					for (var i=0; i<kws.length; i++) {
						var kwid = (kws[i].getElementsByTagName("kid")[0].childNodes[0].nodeValue).trim();
						var kw = (kws[i].getElementsByTagName("keyword")[0].childNodes[0].nodeValue).trim();
						var active = (kws[i].getElementsByTagName("active")[0].childNodes[0].nodeValue).trim();
						var exclude = (kws[i].getElementsByTagName("exclude")[0].childNodes[0].nodeValue).trim();
						var imgsrc = "/Images/delete.png";
						var imgstate = 0;
						if (active == "1") {
							imgsrc = "/Images/check.png";
							imgstate = 1;
						}
						if (exclude == "1") {
							imgsrc = "/Images/minus.png";
							imgstate = 2;
						}
						var imgid = 'kwimg' + i;
						var spanid = 'kwspan' + i;
						html = html + '<div style="width:100%">' +
										'<img id="' + imgid + '" src="' + imgsrc + '" onclick="changekw(\'' + kw + '\', ' + imgstate + ', ' + i + ')" style="width:18px;vertical-align:middle;cursor:pointer"/>' +
										'<span id="' + spanid + '" onclick="changekw(\'' + kw + '\', ' + imgstate + ', ' + i + ')" style="vertical-align:top;width:30%;font-size:20px;vertical-align:text-bottom;cursor:pointer">' + kw + '</span>' +
										'</div>';
					}
					html = html + '<div style="width:100%">' +
									'<input id="newkeyword" onfocus="cleartxt(this)" onblur="resettxt(this)" onchange="keywordadded()" value="&lt;add new keyword&gt;"/>' +
									'</div>';
					divkw.innerHTML = html;
                }
            }
            var url = "/xml/xml_keywordlist.php?UserID=" + userid + "&ProfID=" + sherpaid;
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
        }

		function changekw(kw, state, i) {
			var img = document.getElementById('kwimg' + i);
			var span = document.getElementById('kwspan' + i);
			state = (state + 1) % 3;
			var imgsrc = "/Images/delete.png";
			var url = "/xml/xml_removekeyword.php?ProfID=" + sherpaid + "&Keyword=" + kw;
			if (state == 1) {
				imgsrc = "/Images/check.png";
				url = "/xml/xml_addkeyword.php?ProfID=" + sherpaid + "&Keyword=" + kw;
			}
			else if (state == 2) {
				imgsrc = "/Images/minus.png";
				url = "/xml/xml_excludekeyword.php?ProfID=" + sherpaid + "&Keyword=" + kw;
			}
			img.src = imgsrc;
			img.onclick = function() { changekw(kw, state, i) };
			span.onclick = function() { changekw(kw, state, i) };

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					getvideolistpreview();
				}
			}
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
		}

		function resettxt(tbox) {
			if (tbox.value.length == 0)
				tbox.value = "<add new keyword>";
		}

		function keywordadded() {
			var txtnewkw = document.getElementById("newkeyword");
			newkw = txtnewkw.value;
			if (newkw.length == 0)
				return;

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					getkeywords();
					getvideolistpreview();
				}
			}
			var url = "/xml/xml_addkeyword.php?ProfID=" + sherpaid + "&Keyword=" + newkw;
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
		}

        function getchannels() {
            var divch = document.getElementById('channels');

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var xmlDoc = xmlhttp.responseXML;
                    var chs = xmlDoc.getElementsByTagName("Channel");
					var html = '<div style="width:70%;margin-left:20px;margin-top:20px;margin-right:20px;margin-bottom:10px;font-size:28px">channels</div>';
					for (var i=0; i<chs.length; i++) {
						var chid = (chs[i].getElementsByTagName("cid")[0].childNodes[0].nodeValue).trim();
						var favicon = (chs[i].getElementsByTagName("favicon")[0].childNodes[0].nodeValue).trim();
						var name = (chs[i].getElementsByTagName("name")[0].childNodes[0].nodeValue).trim();
						var active = (chs[i].getElementsByTagName("active")[0].childNodes[0].nodeValue).trim();
						var imgsrc = "/Images/delete.png";
						var imgstate = 0;
						if (active == "1") {
							imgsrc = "/Images/check.png";
							imgstate = 1;
						}
						html = html + '<div style="width:100%">' +
										'<img id="chimg' + i + '" src="' + imgsrc + '" onclick="changechannel(' + chid + ', ' + imgstate + ', ' + i + ')" style="height:18px;vertical-align:text-bottom;cursor:pointer"/>' +
										'<img src="' + favicon + '" height="20px" style="vertical-align:text-bottom">' +
										'<span id="spanimg' + i + '" style="vertical-align:top;width:30%;margin:5px;font-size:20px;vertical-align:text-bottom;cursor:pointer" onclick="changechannel(' + chid + ', ' + imgstate + ', ' + i + ')">' + name + '</span>' +
										'</div>';
					}
					divch.innerHTML = html;
                }
            }
            var url = "/xml/xml_channellist.php?UserID=" + userid + "&ProfID=" + sherpaid;
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
        }

		function changechannel(id, state, i) {
			var img = document.getElementById("chimg" + i);
			var span = document.getElementById("spanimg" + i);
			state = (state + 1) % 2;
			var imgsrc = "/Images/delete.png";
			var url = "/xml/xml_removechannel.php?ProfID=" + sherpaid + "&ChannelID=" + id;
			if (state == 1) {
				imgsrc = "/Images/check.png";
				url = "/xml/xml_addchannel.php?ProfID=" + sherpaid + "&ChannelID=" + id;
			}
			img.src = imgsrc;
			img.onclick = function() { changechannel(id, state, i) };
			span.onclick = function() { changechannel(id, state, i) };

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					getvideolistpreview();
				}
			}
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
		}

        function getgenres() {
            var divg = document.getElementById('genres');

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var xmlDoc = xmlhttp.responseXML;
                    var ps = xmlDoc.getElementsByTagName("Pref");
					var html = '<div style="width:70%;margin-left:20px;margin-top:20px;margin-right:20px;margin-bottom:10px;font-size:28px">genres</div>';
					for (var i=0; i<ps.length; i++) {
						var pid = (ps[i].getElementsByTagName("pid")[0].childNodes[0].nodeValue).trim();
						var name = (ps[i].getElementsByTagName("prefname")[0].childNodes[0].nodeValue).trim();
						var active = (ps[i].getElementsByTagName("active")[0].childNodes[0].nodeValue).trim();
						var imgsrc = "/Images/delete.png";
						var imgstate = 0;
						if (active == "1") {
							imgsrc = "/Images/check.png";
							imgstate = 1;
						}
						html = html + '<div style="width:100%">' +
										'<img id="gimg' + i + '" src="' + imgsrc + '" onclick="changegenre(' + pid + ', ' + imgstate + ', ' + i + ')" style="height:18px;vertical-align:text-bottom;cursor:pointer"/>' +
										'<span id="gspan' + i + '" onclick="changegenre(' + pid + ', ' + imgstate + ', ' + i + ')" style="vertical-align:top;width:30%;font-size:20px;vertical-align:text-bottom;cursor:pointer">' + name + '</span>' +
										'</div>';
					}
					divg.innerHTML = html;
                }
            }
            var url = "/xml/xml_categorylist.php?UserID=" + userid + "&ProfID=" + sherpaid;
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
        }

		function changegenre(id, state, i) {
			var img = document.getElementById("gimg" + i);
			var span = document.getElementById("gspan" + i);
			state = (state + 1) % 2;
			var imgsrc = "/Images/delete.png";
			var url = "/xml/xml_removepreference.php?ProfID=" + sherpaid + "&PrefID=" + id;
			if (state == 1) {
				imgsrc = "/Images/check.png";
				url = "/xml/xml_addpreferences.php?ProfID=" + sherpaid + "&PrefID=" + id;
			}
			img.src = imgsrc;
			img.onclick = function() { changegenre(id, state, i) };
			span.onclick = function() { changegenre(id, state, i) };

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					getvideolistpreview();
				}
			}
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
		}

		function getvideolistpreview() {
			var ividlist = document.getElementById("previewvideolist");
			ividlist.src = "http://www.sherpin.com/videolist.php?UserID=" + userid + "&ProfID=" + sherpaid
		}
    </script>

</head>
<body>
    <div style="height:100%">
    <div style="height:15%;width:100%;background:black">
        <div style="float:left">
            <img src="http://www.sherpin.com/Images/logo.png" alt="" height="60px"/>
        </div>
        <div style="float:left">
	        <a href="http://www.sherpin.com/metro.php" style="margin-left:10px;color:white; font-family:Helvetica, Sans-Serif; font-size:48px; letter-spacing:2px">Sherpin.com</a><br />
	        <span style="margin-left:20px;color:white; font-familyHelvetica, Sans-Serif; font-size:16px"><i>Stop searching ... start watching</i></span>
        </div>
        <div style="clear:both"></div>
    </div>

    <div id="divVideo" style="height:80%;width:100%;position:fixed;">
        <div id="edit" style="background:black; float:left;height:100%;width:65%;overflow:auto;white-space:nowrap">
			<div id="name" style="background:black; width:90%;overflow:auto;white-space:nowrap;margin:10px"></div>
			<div>
				<div id="keywords" style="background:black;overflow:auto;white-space:nowrap;margin:10px;float:left"></div>
				<div id="channels" style="background:black;overflow:auto;white-space:nowrap;margin:10px;float:left"></div>
				<div id="genres" style="background:black;overflow:auto;white-space:nowrap;margin:10px;float:left"></div>
			</div>
		</div>
        <iframe id="previewvideolist" style="float:left;width:30%;height:100%"></iframe>
        <div style="clear:both"></div>
    </div>

<!--    <div style="height:5%;width:100%;background:black;margin-left:auto;margin-right:auto;position:absolute;bottom:0px">
	    <a href="http://www.sherpin.com/metro.php" style="margin-left:10px;color:white; font-family:Berlin Sans FB Demi, Lucida Sans Unicode; font-size:14px; letter-spacing:2px">Sherpin.com</a><br />
    </div>-->
    <script type="text/javascript">
        getsherpaproperties();
    </script>
    </div>
</body>
</html>