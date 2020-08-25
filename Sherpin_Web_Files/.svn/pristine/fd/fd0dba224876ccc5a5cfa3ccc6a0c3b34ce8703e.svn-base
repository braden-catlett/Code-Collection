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

    <form id="form1" style="height:70%" runat="server">
        <div class="border" id="silverlightControlHost" style="height:95%;" >
            <object id="_sl_facebookapp" data="data:application/x-silverlight-2," type="application/x-silverlight-2"
                    width="345" style="height:98%; vertical-align:top; text-align:left;">
		        <param name="source" value="bin/slMyMediaGuide2.xap"/>
		        <param name="id" value="_sl_facebookapp" />
		        <param name="onError" value="onSilverlightError" />
		        <param name="background" value="white" />
		        <param name="minRuntimeVersion" value="3.0.40818.0" />
		        <param name="autoUpgrade" value="true" />
		        <param name="initParams" value="css=<?php echo $css; ?>" />
		        <a href="https://go.microsoft.com/fwlink/?LinkID=149156&v=3.0.40818.0" style="text-decoration:none">
 			        <img src="https://go.microsoft.com/fwlink/?LinkId=108181" alt="Get Microsoft Silverlight" style="border-style:none"/>
		        </a>
	        </object>
            <iframe id="_showvideo" style="height:95%; border-style:none; vertical-align:top; text-align:center;" />
            <iframe id="_sl_historyFrame" style="visibility:hidden;height:0px;width:0px;border:0px"></iframe>
        </div>
    </form><br />
    <?php include("bottommenubar.php") ?>
	<script>getlogininfo();</script>
</body>
</html>
