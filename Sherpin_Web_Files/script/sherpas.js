var currentsherpa = "-1";	//which sherpa are we currently viewing
var currentrow = 0;			//which row of videos are we currently on
var maxrows = 50;			//how many videos should we download at a time

function unselectchildren(divnode) {
	var dnode = document.getElementById(divnode);
	if (dnode != null) {
		var cnode = dnode.firstChild;
		while (cnode != null) {
			cnode.style.backgroundColor = "#FFFFFF";
			cnode = cnode.nextSibling;
		}
	}
}

function getattribute(node, attr) {
	var a = null;
	for (j=0;j<node.attributes.length;j++) {
		if (node.attributes[j].name == attr)
			a = node.attributes[j]
	}
	return a;
}

function selectall(id)
{
	document.getElementById(id).focus();
	document.getElementById(id).select();
}

function view_populatesherpas() {
    var prevbtn = '<a id="viewprevbtn" style="float:left;text-align:center;width:45%;color:White" href="#" onclick="view_prevvideos()">&lt;&lt;prev</a>';
    var nextbtn = '<a id="viewnextbtn" style="float:left;text-align:center;width:45%;color:White" href="#" onclick="view_nextvideos()">next&gt;&gt;</a>';

	var dsherpa = document.getElementById("divsherpa");
	dsherpa.innerHTML = '<div id="lstsherpas" style="background-color:white;padding:5px;text-align:left;height:40%;overflow:auto;white-space:nowrap;"></div>' +
						'<div style="height:5%">' + prevbtn + nextbtn + '<div style="clear:both"></div></div>' +
						'<div id="lstvideos" style="background-color:white;padding:5px;text-align:left;height:45%;overflow:auto;white-space:nowrap;"></div>' +
						'<div style="height:5%;overflow:hidden"><a class="menuitem" style="float:left;text-align:center;width:45%;color:White;border-width:thin;border-color:Black;font-weight:bold" href="#">view sherpas</a><a class="menuitem" style="float:right;text-align:center;width:45%;color:Black;border-width:thin;border-color:Black;font-weight:bold" href="#" onclick="edit_populatesherpas()">edit sherpas</a><div style="clear:both"></div></div>';

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        	var xmlDoc = xmlhttp.responseXML;
        	var ps = xmlDoc.getElementsByTagName("Prof");
        	var divSherpaList = document.getElementById('lstsherpas');
        	var idfirst = currentsherpa;
        	divSherpaList.innerHTML = "";
        	for (i=0; i<ps.length; i++) {
        		var names = ps[i].getElementsByTagName("name");
    			var ids = ps[i].getElementsByTagName("pid");
    			var id = (ids[0].childNodes[0].nodeValue).trim();
    			var fnpopulate = "view_populatevideos(" + id + ", 0, " + maxrows + ")";
        		divSherpaList.innerHTML = divSherpaList.innerHTML + '<div id="sherpa'+id+'" style="margin-bottom:3px"><a class="listitem" href="#" onclick="' + fnpopulate + '">' + names[0].childNodes[0].nodeValue + '</a></div>';
        		if (idfirst == "") {
        			if (id == "-1") {
        				//make sure the backpack has items
        				if (ps[i].getElementsByTagName("count")[0].childNodes[0].nodeValue.trim() != "0")
        					idfirst = id;
        			}
        			else
        				idfirst = id;
        		}
        	}
        	if (idfirst != "") {
        		view_populatevideos(idfirst, 0, maxrows);
        	}
        }
    }
    var url = "";
    if (getloggedin() == 1)
    	url = "/xml/xml_profilelist.php?FBID=" + getfbid();
    else if (getloggedin() == 2)
    	url = "/xml/xml_profilelist.php?UserID=" + getsherpid();
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function view_prevvideos() {
	if (currentrow > 0) {
		currentrow = currentrow - maxrows;
		if (currentrow < 0)
			currentrow = 0;
		view_populatevideos(currentsherpa, currentrow, maxrows);
	}
}

function view_nextvideos() {
	currentrow = currentrow + maxrows;
	view_populatevideos(currentsherpa, currentrow, maxrows);
}

function view_populatevideos(sherpaid, start, limit) {
	if (sherpaid != "-1")
		view_sherpaloading();
		
	currentsherpa = sherpaid;
	currentrow = start;
	
	var divVideoList = document.getElementById('lstvideos');
	divVideoList.innerHTML = "";
	var asherpa = document.getElementById('sherpa' + sherpaid);
	if (asherpa != null) {
		unselectchildren('lstsherpas');
		asherpa.style.backgroundColor = "#a0a0a0";
	}
	
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        	var xmlDoc = xmlhttp.responseXML;
        	var vs = xmlDoc.getElementsByTagName("Video");
        	var idfirst = "";
        	for (i=0; i<vs.length; i++) {
        		var anew = getattribute(vs[i], "new");
        		var fw = "normal";
        		if (anew != null && anew.value == "1")
        			fw = "bold";
        		var apin = getattribute(vs[i], "pinned");
        		var pin = "0";
        		if (apin != null)
        			pin = apin.value;
        		var id = (vs[i].getElementsByTagName("ID")[0].childNodes[0].nodeValue).trim();
        		var profid = (vs[i].getElementsByTagName("ProfID")[0].childNodes[0].nodeValue).trim();
        		var fnshowvid = "view_showvideo(" + id + ")";
        		var title = vs[i].getElementsByTagName("Title")[0].childNodes[0].nodeValue;
        		var favicon = vs[i].getElementsByTagName("favicon")[0].childNodes[0].nodeValue;
        		var desc = "";
        		if (vs[i].getElementsByTagName("Desc")[0].childNodes[0] != null)
        		    desc = vs[i].getElementsByTagName("Desc")[0].childNodes[0].nodeValue;
        		view_setupvideoitem(divVideoList, id, profid, title, fw, fnshowvid, favicon, pin, desc);
        		if (idfirst == "")
	        		idfirst = id;
        	}
        	if (idfirst != "")
        		view_showvideo(idfirst);
        	else
        		view_noresults();
        }
    }
    var url = "";
    if (getloggedin() == 1)
    	url = "/xml/xml_videolist.php?FBID=" + getfbid() + "&ProfID=" + sherpaid + "&Mobile=2&StartRow=" + start + "&RowLimit=" + limit;
    else if (getloggedin() == 2)
    	url = "/xml/xml_videolist.php?UserID=" + getsherpid() + "&ProfID=" + sherpaid + "&Mobile=2&StartRow=" + start + "&RowLimit=" + limit;
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function view_setupvideoitem(divVList, id, profid, title, fw, fnshowvid, favicon, pin, desc) {
	var fndelvid = "view_delvideo(" + id + ")";
	var delicon = '<button type="button" onclick="' + fndelvid + '"><img src="/Images/delete.png" style="margin:2px;width:10px;"></button>';
	var pinflag = "";
	if (pin == "1")
		pinflag = "0";
	else
	    pinflag = "1";
	var atitle = "";
	if (desc.length > 0)
	    atitle = ' title="' + desc + '"';
	var idbtn = "pinbtn" + id + "";
	var picon = '<button id="' + idbtn + '" type="button" onclick="view_pinvideo(' + id + ', ' + profid + ', ' + pinflag + ', \'' + idbtn + '\')">' + view_pinbtncontents(pin) + '</button>';
	var ficon = '<img src="' + favicon + '" style="margin:2px;width:10px;">';
    var aitem = '<a href="#" onclick="' + fnshowvid + '" class="listitem" style="margin:2px;font-weight:' + fw + '"' + atitle + '>' + title + '</a>';
	var item = '<div id="video' + id + '">' + delicon + picon + ficon + aitem + '</div>';
	divVList.innerHTML = divVList.innerHTML + item;
}

function view_pinbtncontents(pin) {
	var pinimg = "";
	if (pin == "1")
		pinimg = "/Images/pinned.png";
	else
		pinimg = "/Images/unpinned.png";
	return '<img src="' + pinimg + '" style="margin:2px;width:10px;">';
}

function view_pinvideo(videoid, profid, pin, btnid) {
	var xmlhttp = new XMLHttpRequest();
    var url = "/xml/xml_pinvideo.php?ProfID=" + profid + "&VideoID=" + videoid + "&Pin=" + pin;
    xmlhttp.open("GET", url, false);
    xmlhttp.send();

    var btn = document.getElementById(btnid);
    if (btn != null) {
    	btn.innerHTML = view_pinbtncontents(pin);
    	var pf = "";
    	if (pin == "1")
    		pf = "0";
    	else
    		pf = "1";
    	btn.onclick = function() { view_pinvideo(videoid, profid, pf, btnid); }
    }
}

function view_delvideo(videoid) {
	var xmlhttp = new XMLHttpRequest();
    var url = "/xml/xml_excludeuservideo.php?UserID=" + getsherpid() + "&VideoID=" + videoid;
    xmlhttp.open("GET", url, false);
    xmlhttp.send();
    
	var dnode = document.getElementById('lstvideos');
	var delnode = document.getElementById("video"+videoid);
	if (dnode != null && delnode != null)
		dnode.removeChild(delnode);
}

function view_noresults() {
	var frmVideo = document.getElementById('_showvideo');
	frmVideo.src = "/noresults.php";
}

function view_sherpaloading() {
	var frmVideo = document.getElementById('_showvideo');
	frmVideo.src = "/loading.html";
}

function view_showvideo(videoid) {
	var avideo = document.getElementById('video' + videoid);
	if (avideo != null) {
		unselectchildren('lstvideos');
		avideo.style.backgroundColor = "#a0a0a0";
	}
	
	var frmVideo = document.getElementById('_showvideo');
	frmVideo.src = "/showvideo.php?id=" + videoid + "&sherp=" + getsherpid();
}

function edit_gensherpaanchor(id, name) {
	var fn = "edit_showsherpadetail(" + id + ")";
	return '<a class="listitem" href="#" onclick="' + fn + '">' + name + '</a>';
}

var textboxnewsherpa = '<input type="text" id="newsherpa" value="&lt;new sherpa&gt;" style="width:90%;margin:5px" onclick="edit_newsherpatextclick()"/>';
var btnsavenewsherpa = '<button onclick="edit_newsherpasave()"><img src="/Images/include.png" height="10px"></img></button>';
function edit_populatesherpas() {
	var dsherpa = document.getElementById("divsherpa");
	dsherpa.innerHTML = '<div id="lstsherpas" style="background-color:white;padding:5px;text-align:left;height:35%;overflow:auto;white-space:nowrap;"></div>' +
						'<div style="height:5%"></div>' +
						'<div id="edtsherpas" style="background-color:white;padding:5px;text-align:left;height:50%;overflow:auto;white-space:nowrap;"></div>' +
						'<div style="height:5%;overflow:hidden"><a class="menuitem" style="float:left;text-align:center;width:45%;color:Black;border-width:thin;border-color:Black;font-weight:bold" href="#" onclick="view_populatesherpas()">view sherpas</a><a class="menuitem" style="float:right;text-align:center;width:45%;color:White;border-width:thin;border-color:Black;font-weight:bold" href="#">edit sherpas</a><div style="clear:both"></div></div>';

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        	var xmlDoc = xmlhttp.responseXML;
        	var ps = xmlDoc.getElementsByTagName("Prof");
        	var divSherpaList = document.getElementById('lstsherpas');
        	var idfirst = currentsherpa;
        	if (idfirst == "-1")
        		idfirst = "";
        	divSherpaList.innerHTML = '<div id="divnewsherpa">' + textboxnewsherpa + '</input></div>';
        	for (i=0; i<ps.length; i++) {
        		var names = ps[i].getElementsByTagName("name");
    			var ids = ps[i].getElementsByTagName("pid");
    			var id = (ids[0].childNodes[0].nodeValue).trim();
    			var fnpopulate = "edit_showsherpadetail(" + id + ")";
    			if (id != "-1") {
    				var btndel = '<button onclick="edit_deletesherpa(' + id + ')"><img src="/Images/delete.png" style="height:10px"/></button>';
        			divSherpaList.innerHTML = divSherpaList.innerHTML + '<div id="sherpa'+id+'" style="margin:5px;cursor:pointer">' + btndel + edit_gensherpaanchor(id, names[0].childNodes[0].nodeValue) + '</div>';
        			divtmp = document.getElementById("sherpa" + id);
        		}
        		if (idfirst == "" && id != "-1")
    				idfirst = id;
        	}
        	if (idfirst != "") {
        		edit_showsherpadetail(idfirst);
        	}
        }
    }
    
    var url = "";
    if (getloggedin() == 1)
    	url = "/xml/xml_profilelist.php?FBID=" + getfbid();
    else if (getloggedin() == 2)
    	url = "/xml/xml_profilelist.php?UserID=" + getsherpid();
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function edit_newsherpatextclick() {
	var divns = document.getElementById('divnewsherpa');
	divns.innerHTML = textboxnewsherpa + btnsavenewsherpa;
	selectall('newsherpa');
}

function edit_newsherpasave() {
	var newprof = document.getElementById('newsherpa').value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        	var xmlDoc = xmlhttp.responseXML;
        	var id = xmlDoc.childNodes[0].getAttribute("id");
        	var divSherpaList = document.getElementById('lstsherpas');
			var fnpopulate = "edit_showsherpadetail(" + id + ")";
			var btndel = '<button onclick="edit_deletesherpa(' + id + ')"><img src="/Images/delete.png" style="height:10px"/></button>';
			divSherpaList.innerHTML = divSherpaList.innerHTML + '<div id="sherpa'+id+'" style="margin:5px;cursor:pointer">' + btndel + edit_gensherpaanchor(id, newprof) + '</div>';
        }
    }
    if (getloggedin() == 1)
    	uid = "FBID="+ getfbid();
    else if (getloggedin() == 2)
    	uid = "UserID=" + getsherpid();
    var url = "/xml/xml_addnewprofile.php?" + uid + "&ProfName=" + newprof;
    xmlhttp.open("GET", url, true);
    xmlhttp.send();

	var divns = document.getElementById('divnewsherpa');
	divns.innerHTML = textboxnewsherpa;
}

function edit_deletesherpa(id) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var dnode = document.getElementById('lstsherpas');
			var delnode = document.getElementById('sherpa'+id);
			if (dnode != null && delnode != null)
				dnode.removeChild(delnode);
        }
    }
    var url = "/xml/xml_deleteprofile.php?ProfID=" + id;
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function edit_showsherpadetail(sherpaid) {
	var asherpa = document.getElementById('sherpa' + sherpaid);
	var sherpaanchor = asherpa.innerHTML;
	if (asherpa != null) {
		unselectchildren('lstsherpas');
		asherpa.style.backgroundColor = "#a0a0a0";
	}
	
	var frmVideo = document.getElementById('_showvideo');
	frmVideo.src = "/videolist.php?ProfID=" + sherpaid + "&UserID=" + getsherpid();
	
	edit_setupdetails(sherpaid);
	
	edit_fetchname(sherpaid);
	edit_fetchkeywords(sherpaid);
	edit_fetchchannels(sherpaid);
	edit_fetchgenres(sherpaid);

	currentsherpa = sherpaid;
}

function edit_setupdetails(sherpaid) {
	var divedit = document.getElementById("edtsherpas");
	divedit.innerHTML = '<p><input type="text" id="sherpaname" style="width:90%;margin:5px" onchange="edit_renamesherpa(' + sherpaid + ')"></input></p>';
	divedit.innerHTML = divedit.innerHTML + '<p><span style="font-style:italic;color:#808080">description:</span><br/>';
	divedit.innerHTML = divedit.innerHTML + '<textarea id="sherpadesc" rows="3" style="width:90%;margin:5px" onchange="edit_updatesherpadescription(' + sherpaid + ')"></textarea></p>';
	divedit.innerHTML = divedit.innerHTML + '<p><button id="btnkeywords">&nbsp;v&nbsp;</button>&nbsp;<span style="font-style:italic;color:#808080">keywords:</span>';
	divedit.innerHTML = divedit.innerHTML + '<div id="sherpakeywords" style="width:90%;max-width:90%;margin:5px;border-color:#808080;border-width:thin;border-style:solid;color:#808080;word-wrap:break-word"></div></p>';
	divedit.innerHTML = divedit.innerHTML + '<p><button id="btnchannels">&nbsp;v&nbsp;</button>&nbsp;<span style="font-style:italic;color:#808080">channels:</span><br/>';
	divedit.innerHTML = divedit.innerHTML + '<div id="sherpachannels" style="width:90%;max-width:90%;margin:5px;border-color:#808080;border-width:thin;border-style:solid;color:#808080;word-wrap:break-word"></div></p>';
	divedit.innerHTML = divedit.innerHTML + '<p><button id="btngenres">&nbsp;v&nbsp;</button>&nbsp;<span style="font-style:italic;color:#808080">genres:</span><br/>';
	divedit.innerHTML = divedit.innerHTML + '<div id="sherpagenres" style="width:90%;max-width:90%;margin:5px;border-color:#808080;border-width:thin;border-style:solid;color:#808080;word-wrap:break-word"></div></p>';
}

function edit_fetchname(sherpaid) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        	var xmlDoc = xmlhttp.responseXML;
        	var name = (xmlDoc.getElementsByTagName("Name")[0].childNodes[0].nodeValue).trim();
        	var desc = (xmlDoc.getElementsByTagName("Desc")[0].childNodes[0].nodeValue).trim();
        	document.getElementById("sherpaname").value = name;
        	document.getElementById("sherpadesc").innerHTML = desc;
        }
    }
    var url = "/xml/xml_profilename.php?ProfID=" + sherpaid;
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function edit_fetchkeywords(sherpaid) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        	var xmlDoc = xmlhttp.responseXML;
        	var kws = xmlDoc.getElementsByTagName("KW");
        	var divkw = document.getElementById('sherpakeywords');
        	divkw.innerHTML = '';
        	var line = '';
        	var cchline = divkw.clientWidth / 8;
        	for (i=0; i<kws.length; i++) {
        		var kw = (kws[i].getElementsByTagName("keyword")[0].childNodes[0].nodeValue).trim();
    			var kid = (kws[i].getElementsByTagName("kid")[0].childNodes[0].nodeValue).trim();
    			var active = (kws[i].getElementsByTagName("active")[0].childNodes[0].nodeValue).trim();
    			var exclude = (kws[i].getElementsByTagName("exclude")[0].childNodes[0].nodeValue).trim();
    			if (i != 0)
    				line = line + ", ";
    			if (line.length + kw.length > cchline) {
    				line = line + "<br/>";
    				divkw.innerHTML = divkw.innerHTML + line;
    				line = kw;
    			}
    			else
    				line = line + kw;
        	}
        	if (line.length > 0)
        		divkw.innerHTML = divkw.innerHTML + line;
			if (divkw.innerHTML.length == 0)
				divkw.innerHTML = "<i>none</i>";
        	var btnkw = document.getElementById("btnkeywords");
        	btnkw.onclick = function() { edit_editkeywords(sherpaid); };
        }
    }
    var url = "/xml/xml_keywordlist.php?ProfID=" + sherpaid + "&UserID=" + getsherpid();
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function edit_editkeywords(sherpaid) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        	var xmlDoc = xmlhttp.responseXML;
        	var kws = xmlDoc.getElementsByTagName("KW");
        	var divkw = document.getElementById('sherpakeywords');
        	divkw.innerHTML = '<input id="txtnewkw" type="text" value="new keyword" style="width:90%" onclick="selectall(\'txtnewkw\')" onchange="edit_addkeyword('+sherpaid+')"></input><br/>';
        	for (i=0; i<kws.length; i++) {
        		var kw = (kws[i].getElementsByTagName("keyword")[0].childNodes[0].nodeValue).trim();
    			var kid = (kws[i].getElementsByTagName("kid")[0].childNodes[0].nodeValue).trim();
    			var active = (kws[i].getElementsByTagName("active")[0].childNodes[0].nodeValue).trim();
    			var exclude = (kws[i].getElementsByTagName("exclude")[0].childNodes[0].nodeValue).trim();
    			var imgfile = "/Images/include.png";
    			var state = 0;
    			if (exclude == "1") {
    				imgfile = "/Images/exclude.png";
    				state = 1;
    			}
    			if (i != 0)
    				divkw.innerHTML = divkw.innerHTML + "<br/>";
    			divkw.innerHTML = divkw.innerHTML + '<button id="btnkw' + kid + '" onclick="edit_changekw(\'' + kw + '\', ' + kid + ', '+ sherpaid + ', ' + state + ')"><img src="' + imgfile + '" height="10px"></img></button>' + kw;
        	}
        	var btnkw = document.getElementById("btnkeywords");
        	btnkw.onclick = function() { edit_fetchkeywords(sherpaid); };
        }
    }
    var url = "/xml/xml_keywordlist.php?ProfID=" + sherpaid + "&UserID=" + getsherpid();
    xmlhttp.open("GET", url, false);
    xmlhttp.send();
    
}

function edit_addkeyword(sherpaid) {
	var txt = document.getElementById("txtnewkw");
	var url = "/xml/xml_addkeyword.php?ProfID=" + sherpaid + "&Keyword=" + txt.value
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", url, false);
    xmlhttp.send();
    
    var frmVideo = document.getElementById('_showvideo');
	frmVideo.src = "/videolist.php?ProfID=" + sherpaid + "&UserID=" + getsherpid();

    edit_editkeywords(sherpaid);
}

function edit_fetchchannels(sherpaid) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        	var xmlDoc = xmlhttp.responseXML;
        	var kws = xmlDoc.getElementsByTagName("Channel");
        	var divch = document.getElementById('sherpachannels');
        	divch.innerHTML = "";
        	var line = '';
        	var cchline = divch.clientWidth / 8;
        	var fadded = false;
        	for (i=0; i<kws.length; i++) {
        		var ch = (kws[i].getElementsByTagName("name")[0].childNodes[0].nodeValue).trim();
    			var cid = (kws[i].getElementsByTagName("cid")[0].childNodes[0].nodeValue).trim();
    			var active = (kws[i].getElementsByTagName("active")[0].childNodes[0].nodeValue).trim();
    			if (active == "1") {
	    			if (fadded == true)
	    				line = line + ", ";
	    			if (line.length + ch.length > cchline) {
	    				line = line + "<br/>";
	    				divch.innerHTML = divch.innerHTML + line;
	    				line = ch;
	    			}
	    			else
	    				line = line + ch;
    				fadded = true;
    			}
        	}
        	if (line.length > 0)
				divch.innerHTML = divch.innerHTML + line;
			if (divch.innerHTML.length == 0)
				divch.innerHTML = "<i>none</i>";

        	var btnch = document.getElementById("btnchannels");
        	btnch.onclick = function() { edit_editchannels(sherpaid); };
        }
    }
    var url = "/xml/xml_channellist.php?ProfID=" + sherpaid + "&UserID=" + getsherpid();
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function edit_editchannels(sherpaid) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        	var xmlDoc = xmlhttp.responseXML;
        	var kws = xmlDoc.getElementsByTagName("Channel");
        	var divch = document.getElementById('sherpachannels');
        	divch.innerHTML = "";
        	var fadded = false;
        	for (i=0; i<kws.length; i++) {
        		var ch = (kws[i].getElementsByTagName("name")[0].childNodes[0].nodeValue).trim();
    			var cid = (kws[i].getElementsByTagName("cid")[0].childNodes[0].nodeValue).trim();
    			var active = (kws[i].getElementsByTagName("active")[0].childNodes[0].nodeValue).trim();
    			var imgfile = "/Images/delete.png";
    			var state = 1;
    			if (active == "1") {
    				imgfile = "/Images/include.png";
    				state = 0;
    			}
    			if (i != 0)
    				divch.innerHTML = divch.innerHTML + "<br/>";
    			divch.innerHTML = divch.innerHTML + '<button id="btnch' + cid + '" onclick="edit_changechannel(' + cid + ', ' + sherpaid + ', ' + state + ')"><img src="' + imgfile + '" height="10px"></img></button>' + ch;
        	}
        	var btnch = document.getElementById("btnchannels");
        	btnch.onclick = function() { edit_fetchchannels(sherpaid); };
        }
    }
    var url = "/xml/xml_channellist.php?ProfID=" + sherpaid + "&UserID=" + getsherpid();
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function edit_fetchgenres(sherpaid) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        	var xmlDoc = xmlhttp.responseXML;
        	var gs = xmlDoc.getElementsByTagName("Pref");
        	var divg = document.getElementById('sherpagenres');
        	divg.innerHTML = "";
        	var line = '';
        	var cchline = divg.clientWidth / 8;
        	var fadded = false;
        	for (i=0; i<gs.length; i++) {
        		var genre = (gs[i].getElementsByTagName("prefname")[0].childNodes[0].nodeValue).trim();
    			var pid = (gs[i].getElementsByTagName("pid")[0].childNodes[0].nodeValue).trim();
    			var active = (gs[i].getElementsByTagName("active")[0].childNodes[0].nodeValue).trim();
    			if (active == "1") {
	    			if (fadded == true)
	    				line = line + ", ";
	    			if (line.length + genre.length > cchline) {
	    				line = line + "<br/>";
	    				divg.innerHTML = divg.innerHTML + line;
	    				line = genre;
	    			}
	    			else
	    				line = line + genre;
    				fadded = true;
    			}
        	}
        	if (line.length > 0)
				divg.innerHTML = divg.innerHTML + line;
			if (divg.innerHTML.length == 0)
				divg.innerHTML = "<i>none</i>";
        	var btng = document.getElementById("btngenres");
        	btng.onclick = function() { edit_editgenres(sherpaid); };
        }
    }
    var url = "/xml/xml_categorylist.php?ProfID=" + sherpaid + "&UserID=" + getsherpid();
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function edit_editgenres(sherpaid) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        	var xmlDoc = xmlhttp.responseXML;
        	var gs = xmlDoc.getElementsByTagName("Pref");
        	var divg = document.getElementById('sherpagenres');
        	divg.innerHTML = "";
        	var fadded = false;
        	for (i=0; i<gs.length; i++) {
        		var genre = (gs[i].getElementsByTagName("prefname")[0].childNodes[0].nodeValue).trim();
    			var pid = (gs[i].getElementsByTagName("pid")[0].childNodes[0].nodeValue).trim();
    			var active = (gs[i].getElementsByTagName("active")[0].childNodes[0].nodeValue).trim();
    			var imgfile = "/Images/delete.png";
    			var state = 1;
    			if (active == "1") {
    				imgfile = "/Images/include.png";
    				state = 0;
    			}
    			if (i != 0)
    				divg.innerHTML = divg.innerHTML + "<br/>";
    			divg.innerHTML = divg.innerHTML + '<button id="btng' + pid + '" onclick="edit_changegenre(' + pid + ', ' + sherpaid + ', ' + state + ')"><img src="' + imgfile + '" height="10px"></img></button>' + genre;
        	}
        	var btng = document.getElementById("btngenres");
        	btng.onclick = function() { edit_fetchgenres(sherpaid); };
        }
    }
    var url = "/xml/xml_categorylist.php?ProfID=" + sherpaid + "&UserID=" + getsherpid();
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function edit_renamesherpa(sherpaid) {
	var name = document.getElementById("sherpaname").value;
	name.replace(" ", "%20");
    var xmlhttp = new XMLHttpRequest();
    var url = "/xml/xml_renameprofile.php?ProfID=" + sherpaid + "&ProfName=" + name;
    xmlhttp.open("GET", url, false);
    xmlhttp.send();

	url = "";
    if (getloggedin() == 1)
    	url = "/xml/xml_profilelist.php?FBID=" + getfbid();
    else if (getloggedin() == 2)
    	url = "/xml/xml_profilelist.php?UserID=" + getsherpid();
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function edit_updatesherpadescription(sherpaid) {
	var desc = document.getElementById("sherpadesc").value;
	desc.replace(" ", "%20");
    var xmlhttp = new XMLHttpRequest();
    var url = "/xml/xml_editprofiledesc.php?ProfID=" + sherpaid + "&ProfDesc=" + desc;
    xmlhttp.open("GET", url, false);
    xmlhttp.send();

	url = "";
    if (getloggedin() == 1)
    	url = "/xml/xml_profilelist.php?FBID=" + getfbid();
    else if (getloggedin() == 2)
    	url = "/xml/xml_profilelist.php?UserID=" + getsherpid();
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function edit_changekw(kw, kid, sherpaid, state) {
	var btnkw = document.getElementById("btnkw" + kid);
	state = (state + 1) % 3;
	var imgfile = "/Images/include.png";
	if (state == 1)
		imgfile = "/Images/exclude.png";
	else if (state == 2)
		imgfile = "/Images/delete.png";
	btnkw.innerHTML = '<img src="' + imgfile + '" height="10px"></img>';
	btnkw.onclick = function() { edit_changekw(kw, kid, sherpaid, state); };

    var xmlhttp = new XMLHttpRequest();
    var url = "";
    if (state == 0)
        url = "/xml/xml_addkeyword.php?ProfID=" + sherpaid + "&Keyword=" + kw;
    else if (state == 1)
        url = "/xml/xml_excludekeyword.php?ProfID=" + sherpaid + "&Keyword=" + kw;
    else if (state == 2)
        url = "/xml/xml_removekeyword.php?ProfID=" + sherpaid + "&Keyword=" + kw;
    xmlhttp.open("GET", url, false);
    xmlhttp.send();

    var frmVideo = document.getElementById('_showvideo');
	frmVideo.src = "/videolist.php?ProfID=" + sherpaid + "&UserID=" + getsherpid();
}

function edit_changechannel(chid, sherpaid, state) {
	var btnch = document.getElementById("btnch" + chid);
	state = (state + 1) % 2;
	var imgfile = "/Images/include.png";
	if (state == 1)
		imgfile = "/Images/delete.png";
	btnch.innerHTML = '<img src="' + imgfile + '" height="10px"></img>';
	btnch.onclick = function() { edit_changechannel(chid, sherpaid, state); };

    var xmlhttp = new XMLHttpRequest();
    var url = "";
    if (state == 0)
        url = "/xml/xml_addchannel.php?ProfID=" + sherpaid + "&ChannelID=" + chid;
    else if (state == 1)
        url = "/xml/xml_removechannel.php?ProfID=" + sherpaid + "&ChannelID=" + chid;
    xmlhttp.open("GET", url, false);
    xmlhttp.send();

    var frmVideo = document.getElementById('_showvideo');
	frmVideo.src = "/videolist.php?ProfID=" + sherpaid + "&UserID=" + getsherpid();
}

function edit_changegenre(gid, sherpaid, state) {
	var btng = document.getElementById("btng" + gid);
	state = (state + 1) % 2;
	var imgfile = "/Images/include.png";
	if (state == 1)
		imgfile = "/Images/delete.png";
	btng.innerHTML = '<img src="' + imgfile + '" height="10px"></img>';
	btng.onclick = function() { edit_changegenre(gid, sherpaid, state); };

    var xmlhttp = new XMLHttpRequest();
    var url = "";
    if (state == 0)
        url = "/xml/xml_addpreferences.php?ProfID=" + sherpaid + "&PrefID=" + gid;
    else if (state == 1)
        url = "/xml/xml_removepreference.php?ProfID=" + sherpaid + "&PrefID=" + gid;
    xmlhttp.open("GET", url, false);
    xmlhttp.send();

    var frmVideo = document.getElementById('_showvideo');
	frmVideo.src = "/videolist.php?ProfID=" + sherpaid + "&UserID=" + getsherpid();
}