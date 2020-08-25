function getsherpaproperties() {
	getname();
	geticonlist();
	getkeywords(false);
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
			var readonly = "";
			var delimg = "";
			if (USERID == -1 || sherpaid == -2 || sherpaid == -3 || sherpaid == -6 || sherpaid == -5)
				readonly = 'readonly="readonly"';
			else
				delimg = '<img id="imgdel" src="Images/delete.png" style="cursor:pointer;height:24px" onclick="sherpadelete(' + sherpaid + ', \'' + profname + '\')"/>';

			divname.innerHTML = '<div><img src="Images/play.png" onclick="detailpage()" style="width:60px;float:right;cursor:pointer"></div>' +
								'<div style="width:100%">' + delimg + '<span style="font-size:20px;vertical-align:text-bottom;width:30%">name: </span><input type="text" id="txtname" onchange="renameprof()" ' + readonly + 'style="vertical-align:top;width:70%;float:right" value="' + profname + '"/></div>' +
								'<div style="width:100%"><span style="font-size:20px;vertical-align:text-bottom;width:30%">description: </span><textarea id="txtdesc" onchange="editdesc()" ' + readonly + 'style="vertical-align:top;width:70%;float:right" rows="4" cols="30">' + profdesc + '</textarea></div>';
		}
	}
	var url = "/xml/xml_profilename.php?ProfID=" + sherpaid;
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
}

function sherpadelete(id, pname) {
	var resp = confirm('Are you sure you want to delete sherpa "' + pname + '"?');
	if (resp) {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				window.location = "https://www.sherpin.com";
			}
		}
		var url = "/xml/xml_deleteprofile.php?ProfID=" + id;
		xmlhttp.open("GET", url, true);
		xmlhttp.send();
	}
}

function detailpage() {
	window.location = '/sherpa_detail.php?ProfID='+sherpaid;
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

function getkeywords(focusonnew) {
	var divkw = document.getElementById('keywords');

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var xmlDoc = xmlhttp.responseXML;
			var kws = xmlDoc.getElementsByTagName("KW");
			var html = '<div style="width:70%;margin-left:10px;margin-right:10px;margin-bottom:10px;font-size:28px">keywords</div>';
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
				var clickfn = 'onclick="changekw(\'' + kw + '\', ' + imgstate + ', ' + i + ')"';
				var cursor = 'pointer';
				if (USERID == -1 || sherpaid == -2 || sherpaid == -3 || sherpaid == -6 || sherpaid == -5) {
					clickfn = '';
					cursor = 'default';
				}
				html = html + '<div style="width:100%">' +
								'<img id="' + imgid + '" src="' + imgsrc + '" ' + clickfn + ' style="width:18px;vertical-align:middle;cursor:' + cursor + '"/>' +
								'<span id="' + spanid + '" ' + clickfn + ' style="vertical-align:top;width:30%;font-size:20px;vertical-align:text-bottom;cursor:' + cursor + '">' + kw + '</span>' +
								'</div>';
			}
			if (USERID != -1 && sherpaid != -2 && sherpaid != -3 && sherpaid != -6 && sherpaid != -5) {
				html = html + '<div style="width:100%">' +
								'<input id="newkeyword" onfocus="cleartxt(this)" onblur="resettxt(this)" onkeydown="if (event.keyCode == 13) keywordadded()" onchange="keywordadded()" value="&lt;add new keyword&gt;"/>' +
								'</div>';
			}
			divkw.innerHTML = html;
			if (USERID != -1 && focusonnew) {
				document.getElementById('newkeyword').focus();
			}
		}
	}
	var url = "/xml/xml_keywordlist.php?ProfID=" + sherpaid;
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
			getkeywords(true);
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
			var html = '<div style="width:70%;margin-left:10px;margin-right:10px;margin-bottom:10px;font-size:28px">channels</div>';
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
				var clickfn = 'onclick="changechannel(' + chid + ', ' + imgstate + ', ' + i + ')"';
				var cursor = 'pointer';
				if (USERID == -1 || sherpaid == -2 || sherpaid == -3  || sherpaid == -6 || sherpaid == -5) {
					clickfn = '';
					cursor = 'default';
				}
				html = html + '<div style="width:100%">' +
								'<img id="chimg' + i + '" src="' + imgsrc + '" '+clickfn+' style="height:18px;vertical-align:text-bottom;cursor:'+cursor+'"/>' +
								'<img src="' + favicon + '" height="20px" '+clickfn+' style="vertical-align:text-bottom;cursor:'+cursor+'">' +
								'<span id="spanimg' + i + '" style="vertical-align:top;width:30%;margin:5px;font-size:20px;vertical-align:text-bottom;cursor:'+cursor+'" onclick="changechannel(' + chid + ', ' + imgstate + ', ' + i + ')">' + name + '</span>' +
								'</div>';
			}
			divch.innerHTML = html;
		}
	}
	var url = "/xml/xml_channellist.php?ProfID=" + sherpaid;
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
			var html = '<div style="width:70%;margin-left:10px;margin-right:10px;margin-bottom:10px;font-size:28px">genres</div>';
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
				var clickfn = 'onclick="changegenre(' + pid + ', ' + imgstate + ', ' + i + ')"';
				var cursor = 'pointer';
				if (USERID == -1 || sherpaid == -2 || sherpaid == -3 || sherpaid == -6 || sherpaid == -5) {
					clickfn = '';
					cursor = 'default';
				}
				html = html + '<div style="width:100%">' +
								'<img id="gimg' + i + '" src="' + imgsrc + '" ' + clickfn + ' style="height:18px;vertical-align:text-bottom;cursor:'+cursor+'"/>' +
								'<span id="gspan' + i + '" '+clickfn+' style="vertical-align:top;width:30%;font-size:20px;vertical-align:text-bottom;cursor:'+cursor+'">' + name + '</span>' +
								'</div>';
			}
			divg.innerHTML = html;
		}
	}
	var url = "/xml/xml_categorylist.php?ProfID=" + sherpaid;
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

function geticonlist() {
	if (sherpaid == -2 || sherpaid == -3 || sherpaid == -6 || sherpaid == -5) { return; }
	
	var divi = document.getElementById("icons");
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var xmlDoc = xmlhttp.responseXML;
			var icons = xmlDoc.getElementsByTagName("Icon");
			var html = "<div style='width:70%;margin-left:10px;margin-right:10px;margin-bottom:10px;font-size:28px'>icon</div>";
			for (var i=0; i<icons.length; i++) {
				var node = icons[i].getElementsByTagName("Path")[0];
				var path = node.childNodes[0].nodeValue.trim();
				var iid = getattribute(node, "id").value;
				var checked = getattribute(node, "checked").value;
				var alttext = getattribute(node, "alttext").value;
				var imgsrc = "";
				var clickfn = 'onclick="changeicon(' + sherpaid + ', ' + iid + ')"';
				var cursor = 'pointer';
				if (USERID == -1) {
					clickfn = '';
					cursor = 'default';
				}
				if (checked == "1") {
					imgsrc = "<img src='/Images/check.png' " + clickfn + " style='float:right;height:18px;margin:5px;vertical-align:text-bottom;cursor:" + cursor  + "'/>";
				}
				html = html + '<div style="width:100%">' + 
								'<img src="' + path + '" ' + clickfn + ' alt="' + alttext + '" title="' + alttext + '" style="float:right;height:36px;margin:5px;vertical-align:text-bottom;cursor:' + cursor  + '"/>' +
								imgsrc + '<div style="clear:both"></div>' +
								'</div>';
			}
			divi.innerHTML = html;
		}
	}
	var url = "/xml/xml_iconlist.php?ProfID=" + sherpaid;
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
}

function changeicon(pid, iid) {
	var url = "/xml/xml_changeicon.php?ProfID=" + pid + "&IconID=" + iid;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			geticonlist();
		}
	}
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
}

function getvideolistpreview() {
	var ividlist = document.getElementById("previewvideolist");
	ividlist.src = "/videolist.php?USER_ID=" + USERID + "&ProfID=" + sherpaid
}
