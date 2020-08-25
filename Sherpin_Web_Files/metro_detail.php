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
        var clastvideo = 0;

        function sherpaloading() {
            var frmVideo = document.getElementById('_showvideo');
            frmVideo.src = "/loading.html";
        }

        function pinbtncontents(pin, id, profid, pinflag, idbtn) {
            var pinimg = "";
            var pinnext = 1-pin;
            if (pin == "1")
                pinimg = "/Images/pinned.png";
            else
                pinimg = "/Images/unpinned.png";
            return '<img src="' + pinimg + '" onclick="pinvideo('+id+', '+profid+', '+pinnext+', '+idbtn+')" style="margin:2px;width:10px;cursor:pointer">';
        }

        function populatevideos(start, limit) {
            if (sherpaid != "-1")
                sherpaloading();
		
            // var divVideoList = document.getElementById('videolist');
            // divVideoList.innerHTML = "";

            clastvideo = 0;

            showmorevideos(start, limit);
        }

        function showmorevideos(start, limit) {
            //var divVideoList = document.getElementById('videolist');
			var divVideoList = document.getElementById('divVideoList');

            var dshowmore = document.getElementById('divshowmore');
            if (dshowmore != null)
                divVideoList.removeChild(dshowmore);

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    listhtml = divVideoList.innerHTML;
                    var xmlDoc = xmlhttp.responseXML;
                    if (start == 0) {
                        listhtml = listhtml + '<div><span style="float:left;font-size:24px; margin-left:20px">results for: ' + getattribute(xmlDoc.childNodes[0], "ProfName").value + '</span>';
                        listhtml = listhtml + '<a href="/metro_edit.php?UserID=' + userid + '&ProfID=' + sherpaid + '" style="font-size:14"><img src="/Images/gear.png" style="float:right;margin-right:10px"></a>';
                        listhtml = listhtml + '<div style="clear:both"></div>';
                        listhtml = listhtml + '</div>';
                    }
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
                        var fnshowvid = "showvideo(" + id + ")";
                        var title = vs[i].getElementsByTagName("Title")[0].childNodes[0].nodeValue;
                        var favicon = vs[i].getElementsByTagName("favicon")[0].childNodes[0].nodeValue;
                        var desc = "";
                        if (vs[i].getElementsByTagName("Desc")[0].childNodes[0] != null)
                            desc = vs[i].getElementsByTagName("Desc")[0].childNodes[0].nodeValue;
                        listhtml = listhtml + setupvideoitem(id, profid, title, fw, fnshowvid, favicon, pin, desc);
                        if (idfirst == "")
                            idfirst = id;
                        clastvideo = clastvideo + 1;
                    }

                    listhtml = listhtml + '<div id="divshowmore" style="text-align:center;cursor:pointer"><p class="listitem" onclick="showmorevideos(clastvideo, 200)">show more videos</p></div>';

                    divVideoList.innerHTML = listhtml;
                    if (start == 0) {
                        if (idfirst != "")
                            showvideo(idfirst);
                        else
                            noresults();
                    }
                }
            }
            var url = "/xml/xml_videolist.php?UserID=" + userid + "&ProfID=" + sherpaid + "&Mobile=2&StartRow=" + start + "&RowLimit=" + limit;
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
        }

        function setupvideoitem(id, profid, title, fw, fnshowvid, favicon, pin, desc) {
            var delicon = '';
            var picon = '';
            if (userid != -1) {
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
                atitle = ' title="' + desc + '"';
            var ficon = '<img src="' + favicon + '" style="margin:2px;width:10px;">';
            var aitem = '<span onclick="' + fnshowvid + '" class="listitem" style="margin:2px;cursor:pointer;font-weight:' + fw + '"' + atitle + '>' + title + '</span>';
            var item = '<div id="video' + id + '" style="background:black;margin:6px">' + delicon + picon + ficon + aitem + '</div>';

            return item;
        }

        function pinbtncontents(pin, id, profid, pinflag, idbtn) {
            var pinimg = "";
            if (pin == "1")
                pinimg = "/Images/pinned.png";
            else
                pinimg = "/Images/unpinned.png";
            return '<img id="' + idbtn + '" src="' + pinimg + '" onclick="pinvideo(' + id + ', ' + profid + ', ' + pinflag + ', \'' + idbtn + '\')" style="margin:2px;width:14px;cursor:pointer">';
        }

        function pinvideo(videoid, profid, pin, btnid) {
            var xmlhttp = new XMLHttpRequest();
            var url = "/xml/xml_pinvideo.php?ProfID=" + profid + "&VideoID=" + videoid + "&Pin=" + pin;
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

        function delvideo(videoid) {
            var xmlhttp = new XMLHttpRequest();
            var url = "/xml/xml_excludeuservideo.php?UserID=" + userid + "&VideoID=" + videoid;
            xmlhttp.open("GET", url, false);
            xmlhttp.send();
    
            var dnode = document.getElementById('videolist');
            var delnode = document.getElementById("video"+videoid);
            if (dnode != null && delnode != null)
                dnode.removeChild(delnode);
        }

        function unselectchildren(divnode) {
            var dnode = document.getElementById(divnode);
            if (dnode != null) {
                var cnode = dnode.firstChild;
                while (cnode != null) {
                    cnode.style.backgroundColor = "black";
                    cnode = cnode.nextSibling;
                }
            }
        }

        function showvideo(videoid) {
            var avideo = document.getElementById('video' + videoid);
            if (avideo != null) {
                unselectchildren('videolist');
                avideo.style.backgroundColor = "#a0a0a0";
            }
	
            var frmVideo = document.getElementById('_showvideo');
            frmVideo.src = "/showvideo.php?id=" + videoid + "&sherp=" + userid;
        }

        function setdivsize() {
            var div = document.getElementById("divVideo");
            var newheight = (document.body.clientHeight * 0.90) + "px";
            div.style.height = newheight;
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
	        <span style="margin-left:20px;color:white; font-family:Helvetica, Sans-Serif; font-size:16px"><i>Stop searching ... start watching</i></span>
        </div>
        <div style="clear:both"></div>
    </div>

    <div id="divVideo" style="height:80%;width:100%;position:fixed;">
        <div id="videolist" style="background:black; float:left;height:100%;width:45%;overflow:auto;white-space:nowrap">&nbsp;</div>
        <iframe id="_showvideo" style="float:left;width:50%;height:100%"></iframe>
        <div style="clear:both"></div>
    </div>

<!--    <div style="height:5%;width:100%;background:black;margin-left:auto;margin-right:auto;position:absolute;bottom:0px">
	    <a href="http://www.sherpin.com/metro.php" style="margin-left:10px;color:white; font-family:Berlin Sans FB Demi, Lucida Sans Unicode; font-size:14px; letter-spacing:2px">Sherpin.com</a><br />
    </div>-->
    <script type="text/javascript">
        populatevideolist(0, 200);
    </script>
    </div>
</body>
</html>