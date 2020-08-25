var cachedVideos = Array();

function populatevideolist(start, limit) {
	if (sherpaid != "-1")
		sherpaloading();

	// var divVideoList = document.getElementById('videolist');
	// divVideoList.innerHTML = "";
	clastvideo = 0;
	
	cachedVideos = Array();

	showmorevideos(start, limit);
}

function showmorevideos(start, limit) {
	var divVideoTools = document.getElementById('videotools');
	var divVideoList = document.getElementById('videolist');

	var dshowmore = document.getElementById('divshowmore');
	if (dshowmore != null)
		divVideoList.removeChild(dshowmore);

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var listhtml = divVideoList.innerHTML;
			var toolshtml = "";
			var xmlDoc = xmlhttp.responseXML;
			var vidlist = xmlDoc.getElementsByTagName("VideoList")[0];
			var prefix = 'results for: ';
			if (sherpaid == -4) { prefix = ''; }
			if (start == 0 && vidlist != null && getattribute(vidlist, "ProfName") != null) {
				toolshtml = toolshtml + '<div><span style="float:left;font-size:24px; margin-left:20px">' + prefix + getattribute(vidlist, "ProfName").value + '</span>';
				toolshtml = toolshtml + '<span style="float:left;font-size:20px; margin-left:10px;text-align:center"><input id="chkNew" type="checkbox" onclick="filterresults()">new</span>';
				toolshtml = toolshtml + '<span style="float:left;font-size:20px; margin-left:10px;text-align:center"><input class="searchBox" id="txtSearch" type="text" size="10" oninput="filterresults()" onkeyup="filterresults()"></span>';
				if (sherpaid != -1 && sherpaid != -4) {
					toolshtml = toolshtml + '<img src="/Images/gear.png" onclick="editpage()" style="float:right;margin-right:10px;cursor:pointer">';
				}
				toolshtml = toolshtml + '<div style="clear:both"></div>';
				toolshtml = toolshtml + '</div>';
				divVideoTools.innerHTML = toolshtml;
			}
			var vs = xmlDoc.getElementsByTagName("Video");
			if (start == 0 && (vs == null || vs.length == 0)) {
				divVideoList.innerHTML = listhtml;
				novideos();
				return;
			}
			listhtml = listhtml + '<div id="divVideoList">';
			var idfirst = 0;
			for (i=0; i<vs.length; i++) {
				var anew = getattribute(vs[i], "new");
				var fw = "normal";
				var newvid = false;
				if (anew != null && anew.value == "1") {
					newvid = true;
					fw = "bold";
				}
				var apin = getattribute(vs[i], "pinned");
				var pin = "0";
				if (apin != null)
					pin = apin.value;
				var id = (vs[i].getElementsByTagName("ID")[0].childNodes[0].nodeValue).trim();
				var profid = (vs[i].getElementsByTagName("ProfID")[0].childNodes[0].nodeValue).trim();
				var fnshowvid = "showvideo(" + id + ", 1)";
				var title = vs[i].getElementsByTagName("Title")[0].childNodes[0].nodeValue;
				var favicon = vs[i].getElementsByTagName("favicon")[0].childNodes[0].nodeValue;
				var tnail = "";
				if (vs[i].getElementsByTagName("Thumbnail")[0].childNodes.length) {
					tnail = vs[i].getElementsByTagName("Thumbnail")[0].childNodes[0].nodeValue;
				}
				var desc = "";
				if (vs[i].getElementsByTagName("Desc")[0].childNodes[0] != null)
					desc = vs[i].getElementsByTagName("Desc")[0].childNodes[0].nodeValue;
				
				var vid = {ID:id, ProfID:profid, Title:title, New:newvid, Pin:pin, Favicon:favicon, Desc:desc, TNail: tnail};
				cachedVideos.push(vid);
					
				//listhtml = listhtml + setupvideoitem(id, profid, title, fw, fnshowvid, favicon, pin, desc);
				listhtml = listhtml + setupvideoitem2(vid);
				if (i == videooffset)
					idfirst = id;
				clastvideo = clastvideo + 1;
			}
			listhtml = listhtml + '</div>';

			listhtml = listhtml + '<div id="divshowmore" style="text-align:center;cursor:pointer"><p class="listitem" onclick="showmorevideos(clastvideo, 200)">show more videos</p></div>';

			divVideoList.innerHTML = listhtml;
			if (start == 0) {
				if (idfirst != "")
					showvideo(idfirst, 0);
				else
					noresults();
			}
		}
	}
	var url = "/xml/xml_videolist.php?ProfID=" + sherpaid + "&Mobile=2&StartRow=" + start + "&RowLimit=" + limit;
	if (sherpaid == -4) {
		url = "/xml/xml_quicksearch.php?Search=" + qsearch + "&Mobile=2&StartRow=" + start + "&RowLimit=" + limit;
	}
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
}

function editpage() {
	window.location = '/sherpa_edit.php?ProfID=' + sherpaid;
}

function setupvideoitem(id, profid, title, fw, fnshowvid, favicon, pin, desc) {
	var delicon = '';
	var picon = '';
	if (USERID != -1) {
		var fndelvid = "delvideo(" + id + ")";
		var delicon = '<img src="/Images/delete.png" onclick="' + fndelvid + '" style="margin:2px;width:14px;cursor:pointer">';
		var pinflag = "";
		if (pin == "1")
			pinflag = "0";
		else
			pinflag = "1";
		var idbtn = "pinbtn" + id + "";
		var picon = pinbtncontents(pin, id, profid, pinflag, idbtn);
	}

	var atitle = "";
	if (desc.length > 0)
		atitle = ' title="' + desc.replace(/<[^>]*>/g, '').replace(/"/g, '\'') + '"';
	var ficon = '<img src="' + favicon + '" style="margin:2px;width:10px;">';
	var aitem = '<span onclick="' + fnshowvid + '" class="listitem" style="margin:2px;cursor:pointer;font-weight:' + fw + '"' + atitle + '>' + title + '</span>';
	var item = '<div id="video' + id + '" style="background:#4e8db0;margin:6px">' + delicon + picon + ficon + aitem + '</div>';

	return item;
}

function setupvideoitem2(v) {
	var delicon = '';
	var picon = '';
	if (USERID != -1) {
		var fndelvid = "delvideo(" + v.ID + ")";
		var delicon = '<img src="/Images/delete.png" onclick="' + fndelvid + '" style="margin:2px;width:14px;cursor:pointer">';
		var pinflag = "";
		if (v.Pin == "1")
			pinflag = "0";
		else
			pinflag = "1";
		var idbtn = "pinbtn" + v.ID + "";
		var picon = pinbtncontents(v.Pin, v.ID, v.ProfID, pinflag, idbtn);
	}

	var fnshowvid = "showvideo(" + v.ID + ", 1)";
	
	var fw = "normal";
	if (v.New == true)
		fw = "bold";
	var atitle = "";
	if (v.Desc.length > 0)
		atitle = ' title="' + v.Desc.replace(/<[^>]*>/g, '').replace(/"/g, '\'') + '"';
	var ficon = '<img src="' + v.Favicon + '" style="margin:2px;width:50px;">';
	var tnail = "";
	if (v.TNail.length > 0)
		tnail = '<img src="' + v.TNail + '" style="margin:2px;width:50px;">';
	var aitem = '<span onclick="' + fnshowvid + '" class="listitem" style="margin:2px;cursor:pointer;font-weight:' + fw + '"' + atitle + '>' + v.Title + '</span>';
	var vidimg = tnail;
	if (tnail.length == 0)
		vidimg = ficon;
	var item = '<div id="video' + v.ID + '" style="background:#00263a;margin:6px">' + delicon + picon + vidimg + aitem + '</div>';

	return item;
}

function filterresults() {
	var vidlist = document.getElementById('divVideoList');
	var newonly = document.getElementById('chkNew').checked;
	var searchtext = document.getElementById('txtSearch').value.toLowerCase();
	var listhtml = "";
	for (var i=0; i<cachedVideos.length; i++) {
		var show = true;
		if (newonly && !cachedVideos[i].New) { show = false; }
		if (show && searchtext.length > 0 && cachedVideos[i].Title.toLowerCase().indexOf(searchtext) == -1) { show = false; }

		if (show) { listhtml = listhtml + setupvideoitem2(cachedVideos[i]); }
	}
	
	vidlist.innerHTML = listhtml;
}

function pinbtncontents(pin, id, profid, pinflag, idbtn) {
	return '';
	//var pinimg = "";
	//if (pin == "1")
	//	pinimg = "/Images/pinned.png";
	//else
	//	pinimg = "/Images/unpinned.png";
	//return '<img id="' + idbtn + '" src="' + pinimg + '" onclick="pinvideo(' + id + ', ' + profid + ', ' + pinflag + ', \'' + idbtn + '\')" style="margin:2px;width:14px;cursor:pointer">';
}

function pinvideo(videoid, profid, pin, btnid) {
	var xmlhttp = new XMLHttpRequest();
	var url = "/xml/xml_pinvideo.php?ProfID=" + profid + "&VideoID=" + videoid + "&Pin=" + pin;
	xmlhttp.open("GET", url, false);
	xmlhttp.send();

	var btn = document.getElementById(btnid);
	if (btn != null) {
		//btn.innerHTML = pinbtncontents(pin);
		var pf = "";
		if (pin == "1") {
			pf = "0";
			pinimg = "/Images/pinned.png";
			tooltip = "unpin this from your sherpa";
		}
		else {
			pf = "1";
			pinimg = "/Images/unpinned.png";
			tooltip = "pin this to your sherpa";
		}
		btn.onclick = function() { pinvideo(videoid, profid, pf, btnid); }
		btn.src = pinimg;
		btn.title = tooltip;
	}
}

function delvideo(videoid) {
	var xmlhttp = new XMLHttpRequest();
	var url = "/xml/xml_excludeuservideo.php?VideoID=" + videoid;
	xmlhttp.open("GET", url, false);
	xmlhttp.send();

	//var dnode = document.getElementById('divVideoList');
	var delnode = document.getElementById("video"+videoid);
	if (delnode != null && delnode.parentNode != null)
		delnode.parentNode.removeChild(delnode);
}

function unselectchildren(divnode) {
	var dnode = document.getElementById(divnode);
	if (dnode != null) {
		var cnode = dnode.firstChild;
		while (cnode != null) {
			cnode.style.backgroundColor = "#00263a";
			cnode = cnode.nextSibling;
		}
	}
}

function showvideo(videoid, click) {
	var divdrawer = document.getElementById('sherpalistparent');
	if (divdrawer.style.visibility == 'visible')
		handledrawer();

	var avideo = document.getElementById('video' + videoid);
	if (avideo != null) {
		//unselectchildren('videolist');
		unselectchildren('divVideoList');
		avideo.style.backgroundColor = "black";
	}

	var frmVideo = document.getElementById('_showvideo');
	frmVideo.src = "/showvideo.php?id=" + videoid + "&click=" + click + "&profid=" + sherpaid;
}

function setdivsize() {
	var div = document.getElementById("divVideo");
	var newheight = (document.body.clientHeight * 0.90) + "px";
	div.style.height = newheight;
}
