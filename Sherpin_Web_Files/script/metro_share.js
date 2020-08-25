function pinvideo(videoid, profid, pin, btnid) {
	if (USERID == -1) return;

	var xmlhttp = new XMLHttpRequest();
	var url = "/xml/xml_pinvideo.php?VideoID=" + videoid + "&Pin=" + pin;
	xmlhttp.open("GET", url, false);
	xmlhttp.send();

	var btn = document.getElementById(btnid);
	if (btn != null) {
		btn.innerHTML = pinbtncontents(pin);
		var pf = "";
		if (pin == "1") {
			pf = "0";
			pinimg = "/Images/pinned.png";
		}
		else {
			pf = "1";
			pinimg = "/Images/unpinned.png";
		}
		btn.onclick = function() { pinvideo(videoid, profid, pf, btnid); }
		btn.src = pinimg;
	}
}

function populatevideos(start, limit) {
	sherpaloading();

	var divVideoList = document.getElementById('videolist');
	divVideoList.innerHTML = "";

	clastvideo = 0;

	showmorevideos(start, limit);
}

function savesharedsherpa() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var xmlDoc = xmlhttp.responseXML;
			var profid = getattribute(xmlDoc.childNodes[0], "ProfID").value;
			window.location = "/sherpa_edit.php?ProfID=" + profid;
		}
	}
	var url = "/xml/xml_savesharedsherpa.php?VideoID=" + videoid;
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
}

function showmorevideos(start, limit) {
	var divVideoList = document.getElementById('videolist');

	var dshowmore = document.getElementById('divshowmore');
	if (dshowmore != null)
		divVideoList.removeChild(dshowmore);

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var xmlDoc = xmlhttp.responseXML;
			if (start == 0) {
				var dSave = document.getElementById('divsave');
				var attrs = "";
				var img = "";
				if (USERID != -1) {
					attrs = ' onclick="savesharedsherpa()" style="cursor:pointer"';
					img = '<image style="float:left" src="Images/save.png">';
				}
				var vidlist = xmlDoc.getElementsByTagName("VideoList")[0];
				if (vidlist != null) {
					savehtml = '<div' + attrs + '>' + img + '<span style="float:left;font-size:24px; margin-left:20px;color:white">' + getattribute(vidlist, "SharedTitle").value + '</span>';
					savehtml = savehtml + '<div style="clear:both"></div>';
					savehtml = savehtml + '</div>';
				}
				dSave.innerHTML = savehtml;
			}
			listhtml = divVideoList.innerHTML;
			var vs = xmlDoc.getElementsByTagName("Video");
			var idshared = "";
			for (i=0; i<vs.length; i++) {
				var shared = getattribute(vs[i], "shared").value;
				var fw = "normal";
				var id = (vs[i].getElementsByTagName("ID")[0].childNodes[0].nodeValue).trim();
				var fnshowvid = "showvideo(" + id + ", 1)";
				var title = vs[i].getElementsByTagName("Title")[0].childNodes[0].nodeValue;
				var favicon = vs[i].getElementsByTagName("favicon")[0].childNodes[0].nodeValue;
				var apin = getattribute(vs[i], "pinned");
				var pin = "0";
				if (apin != null)
					pin = apin.value;
				var desc = "";
				if (vs[i].getElementsByTagName("Desc")[0].childNodes[0] != null)
					desc = vs[i].getElementsByTagName("Desc")[0].childNodes[0].nodeValue;
				
				if (shared == "1") {
					var dv = document.getElementById("sharedvideo");
					dv.innerHTML = setupvideoitem(id, title, fw, fnshowvid, favicon, desc, pin);
					idshared = id;
				}
				else {
					listhtml = listhtml + setupvideoitem(id, title, fw, fnshowvid, favicon, desc, pin);
				}
				clastvideo = clastvideo + 1;
			}

			listhtml = listhtml + '<div id="divshowmore" style="text-align:center;cursor:pointer"><p class="listitem" onclick="showmorevideos(clastvideo, 200)">show more videos</p></div>';
			divVideoList.innerHTML = listhtml;
			showvideo(idshared, 0);
		}
	}
	var url = "/xml/xml_sharelist.php?VideoID=" + videoid + "&Mobile=2&StartRow=" + start + "&RowLimit=" + limit;
	if (USERID != -1)
		url = url + "&UserID=" + USERID;
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
}

function setupvideoitem(id, title, fw, fnshowvid, favicon, desc, pin) {
	var atitle = "";
	if (desc.length > 0)
		atitle = ' title="' + desc.replace(/<[^>]*>/g, '').replace(/"/g, '\'') + '"';
	var pinicon = "";
	if (USERID != -1)
		pinicon = pinbtncontents(pin, id, -1, "1", "pinbtn" + id);
	var ficon = '<img src="' + favicon + '" style="margin:2px;width:10px;">';
	var aitem = '<span onclick="' + fnshowvid + '" class="listitem" style="margin:2px;cursor:pointer;font-weight:' + fw + '"' + atitle + '>' + title + '</span>';
	var item = '<div id="video' + id + '" style="background:#00263a;color:white;margin:6px">' + pinicon + ficon + aitem + '</div>';

	return item;
}
