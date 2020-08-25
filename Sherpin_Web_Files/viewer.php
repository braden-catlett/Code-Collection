<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<!-- saved from url=(0014)about:internet -->
<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<?php include 'head.html'; ?>
	<?php include 'setstyle.php'; ?>
	<script type="text/javascript">
		function showuser() {
			var isloggedin = getloggedin();
			if (isloggedin != 0) {
				var viewer = document.getElementById("aviewer");
				if (viewer != null) viewer.style.visibility = "visible";
			}
			setwelcomebar();
		}
	</script>
	<!--<script type="text/javascript" src="/script/dragdrop.js"></script>-->
	<script type="text/javascript" src="/script/sherpas.js"></script>
</head>
<body style="text-align:center; min-width:500px; min-height:300px; height: 100%">
    <?php 
		$page = "viewer";
		include 'header.html'; 
		include 'topmenubar.php';
	?>
	<script type="text/javascript" src="https://connect.facebook.net/en_US/all.js"></script>
	<script type="text/javascript" src="/script/cookies.js"></script>
	<script type="text/javascript" src="/script/userinfo.js"></script>
    <script type="text/javascript" src="/script/Silverlight.js"></script>
    <script type="text/javascript">
        function getobjectwidth(obj) {
            var o = document.getElementById(obj);
            return o.clientWidth;
        }

        function getobjecttop(obj) {
            var t = 0;
            if (obj.offsetParent) {
                do {
                    t += obj.offsetTop;
                } while (obj = obj.offsetParent);
            }
            return t;
        }

        function getobjectleft(obj) {
            var l = 0;
            if (obj.offsetParent) {
                do {
                    l += obj.offsetLeft;
                } while (obj = obj.offsetParent);
            }
            return l;
        }

        function setvideowidth() {
            var ifvideo = document.getElementById("_showvideo");
            var divcontainer = document.getElementById("silverlightControlHost");
            var slapp = document.getElementById("_sl_facebookapp");
            var newwidth = divcontainer.clientWidth - slapp.clientWidth - 20;

            ifvideo.style.width = newwidth + "px";
        }

        function setsldivwidth(w) {
            //var divcontainer = document.getElementById("silverlightControlHost");
            //divcontainer.clientWidth = w + "px";
        }

        window.onresize = setvideowidth;

        var commentsShow = 0;

        function toggleComments() {
            var p = document.getElementById("pcomments");
            var d = document.getElementById("divcomments");
            if (commentsShow == 0) {
                p.innerHTML = "hide comments";
                d.style.visibility = "visible";
            }
            else {
                p.innerHTML = "show comments";
                d.style.visibility = "hidden";
            }
            commentsShow = 1 - commentsShow;
        }

    </script>
    <script type="text/javascript">
        function onSilverlightError(sender, args) {
            var appSource = "";
            if (sender != null && sender != 0) {
                appSource = sender.getHost().Source;
            }

            var errorType = args.ErrorType;
            var iErrorCode = args.ErrorCode;

            if (errorType == "ImageError" || errorType == "MediaError") {
                return;
            }

            var errMsg = "Unhandled Error in Silverlight Application " + appSource + "\n";

            errMsg += "Code: " + iErrorCode + "    \n";
            errMsg += "Category: " + errorType + "       \n";
            errMsg += "Message: " + args.ErrorMessage + "     \n";

            if (errorType == "ParserError") {
                errMsg += "File: " + args.xamlFile + "     \n";
                errMsg += "Line: " + args.lineNumber + "     \n";
                errMsg += "Position: " + args.charPosition + "     \n";
            }
            else if (errorType == "RuntimeError") {
                if (args.lineNumber != 0) {
                    errMsg += "Line: " + args.lineNumber + "     \n";
                    errMsg += "Position: " + args.charPosition + "     \n";
                }
                errMsg += "MethodName: " + args.methodName + "     \n";
            }

            throw new Error(errMsg);
        }
    </script>
    
    <div class="primary" style="height:70%; min-height:400px;">
    	<div id="divsherpa" class="secondary" style="padding:5px;width:25%; height:95%; float:left;">
    	</div>
    	<iframe id="_showvideo" style="float:left;height:95%; padding:5px;width:70%; border-style:none; vertical-align:top; text-align:center;"></iframe>
    	<div style="clear:both"></div>
    </div>

	<br />
    <?php include("bottommenubar.php") ?>
	<script type="text/javascript">
		getlogininfo();
		view_populatesherpas();
	</script>
</body>
</html>
