<?php 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="https://www.facebook.com/2008/fbml">
<?php
	$share = "1";
	$redirectprefix = "https://www.sherpin.com/redirect/";
	if (isset($_REQUEST['share']))
		$share = $_REQUEST['share'];
	if (isset($_REQUEST["media"]))
	{
		$mediaurl = "\"".html_entity_decode($_REQUEST["media"])."\"";
	}
	else if (isset($_REQUEST["id"]))
	{
		$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
		if ($mysqli->connect_errno) {
			$stRet.= "<error_connecting number='" . $mysqli->connect_errno . "'>" . $mysqli->connect_error . "</error_connecting>";
		}
		$mysqli->select_db("mediabup");

		//First, increment the ClickThrough field if this video was clicked
		if (isset($_REQUEST["click"]) && $_REQUEST["click"] == "1") {
			$mysqli->query("call ModifyClickThrough(".$_REQUEST["id"].", 1);");
			while ($mysqli->next_result());
		}

		//Now get the video details
		$res = $mysqli->query("call GetVideoDetailsExtended(".$_REQUEST["id"].");");
		while ($mysqli->next_result());
		if (($row = $res->fetch_assoc()) != null)
		{
			$mediaurl = $row['URIEmbedded'];
			$title = $row['Title'];
			$channel = $row['ChID'];
			$desc = $row['Description'];
			$dur = $row['Duration'];
			$url = $row['URI'];
			$yid = $row['YoutubeID'];
			$wid = $row['Width'];
			$hgt = $row['Height'];
			$origid = $row['OrigID'];
			$dateupdated = $row['DateUpdated'];
			$embedhtml = $row['EmbedHTML'];
			$tnail = $row['ThumbnailURL'];
			if ($tnail == NULL || strlen($tnail) == 0)
				$tnail = "https://www.sherpin.com/Images/logo.jpg";

			//hulu doesn't seem to support https when reading from media
			//if (strpos($mediaurl, "hulu.com") == false) {
			//	$mediaurl = str_replace("http:", "https:", $mediaurl);
			//	$url = str_replace("http:", "https:", $url);
			//	$embedhtml = str_replace("http:", "https:", $embedhtml);
			//	$tnail = str_replace("http:", "https:", $tnail);
			//}
		}
		else
		    echo "<!--no rows-->";
	}
	$profid = -1;
	if (isset($_REQUEST["profid"]))
	{
		$profid = $_REQUEST["profid"];
		$res = $mysqli->query("call GetIsVideoPinned(".$_REQUEST["id"].", ".$profid.");");
		while ($mysqli->next_result());
		if (($row = $res->fetch_assoc()) != null)
			$pinned = $row['Pinned'];
	}
	$header = 1;
	if (isset($_REQUEST["header"]))
		$header = intval($_REQUEST["header"]);
?>
<head>
	<link rel="stylesheet" type="text/css" href="css/metro.css" />
	<style>
		#custom-tweet-button a {
			display: block;
			padding: 2px 5px 2px 20px;
			background: url('https://twitter.com/favicons/favicon.ico') 1px center no-repeat;
			border: 1px solid #ccc;
		}
  </style>
	<link rel='canonical' href='/sherpa_share.php?VideoID=<?php echo $_REQUEST["id"];?>' />
	<?php if ($channel == 12) {
		//anyclip.com needs it's javascript library for the player
	?>
		<script type="text/javascript" src="https://player.anyclip.com/embed/AnyClipPlayer.js"></script>
	<?php } else if ($channel == 5) { 
		//espn needs its own libraries to run its player.
	?>
		<!--<script type="text/javascript" src="https://a.espncdn.com/combiner/c?js=jquery-1.7.1.js,plugins/json2.r3.js,plugins/teacrypt.js,plugins/jquery.metadata.js,plugins/jquery.bgiframe.r3.js,plugins/jquery.easing.1.3.js,plugins/jquery.hoverIntent.js,plugins/jquery.jcarousel.js,plugins/jquery.tinysort.r4.js,plugins/jquery.pubsub.r5.js,ui/1.8.16/jquery.ui.core.js,ui/1.8.16/jquery.ui.widget.js,ui/1.8.16/jquery.ui.tabs.js,ui/1.8.16/jquery.ui.accordion.js,plugins/ba-debug-0.4.js,espn.l10n.r12.js,swfobject/2.2/swfobject.js,flashObjWrapper.r7.js,plugins/jquery.colorbox.1.3.14.js,plugins/jquery.ba-postmessage.js,espn.core.duo.r55.js,espn.mem.r27.js,stub.search.r9.js,espn.nav.mega.r33.js,espn.storage.r6.js,espn.p13n.r16.js,espn.video.r62.js,registration/staticLogin.r10-26.js,espn.universal.overlay.r11.js,insider/espn.insider.201112021227.js,espn.espn360.stub.r9.js,espn.myHeadlines.stub.r13.js,espn.myfaves.stub.r3.js,tsscoreboard.20090612.js,%2Fforesee%2Fv7%2Fforesee-alive.js,ie9pinning.r3.js"></script>-->
		<script type="text/javascript" src="https://www.sherpin.com/script/espn1.js"></script>
		<script type="text/javascript" >espn.core.navVersion = 'a';</script>
		<!--<script type="text/javascript" src="https://a.espncdn.com/prod/scripts/mbox.20.js"></script>-->
		<script type="text/javascript" src="https://www.sherpin.com/script/espn2.js"></script>

		<script type="text/javascript">
		var ad_site = 'espn.us.com.video';
		var ad_zone = 'videoPage';
		var ad_kvps = 'pgtyp=videoPage;sp=espn;';
		var ad_swid = '';
		var ad_counter = 1;
		var ad_ord = Math.floor(Math.random()*9999999999);
		var ad_seg = '';
	
		
			ad_swid = jQuery.cookie('SWID');
			if(typeof espn.core.ad_segments == 'function') {
				ad_seg = espn.core.ad_segments();
				if (ad_seg != null && ad_seg != '') {
					ad_kvps = ad_kvps + ad_seg
				}
			}
		
	
		// the u
		var ad_u = 'u=pgtyp=videoPage|sp=espn';
		var ad_seg_u = ad_seg;
		if (ad_swid != null && ad_swid != '') {
			if (ad_swid.length > 54) {
				ad_swid = ad_swid.substring(0,54);
			}
			ad_newu = 'u=swid='+ad_swid+'|';
			ad_u = ad_u.replace('u=',ad_newu);
		}
		if (ad_seg_u != null && ad_seg_u != '') {
			while(ad_seg_u.indexOf(';')!=-1) {
				ad_seg_u = ad_seg_u.replace(';','|');
			}
			ad_u = ad_u + '|' + ad_seg_u;
		}
		ad_u = ad_u + ';';
		if (ad_u.length > 255) {
			ad_u = ad_u.substring(0,254);
		}
		</script>
	<?php } ?>	
	<script type="text/javascript" src="/script/utils.js"></script>
	<script type="text/javascript" src="/script/metro_detail.js"></script>

</head>
<body id="showvideo" onload="setvideosize()" style="margin-left:auto;margin-right:auto;text-align:center">
	<div id='fb-root'></div>
    <script src='https://connect.facebook.net/en_US/all.js'></script>
	<script src='https://platform.twitter.com/widgets.js'></script>
    
	<script type="text/javascript">
		//FB.init({appId: "326133152009", status: true, cookie: true});
		
		var vidratio = <?php echo $wid/$hgt; ?>;
        function getvideowidth() {
			var w = GetWidth();
			<?php if ($header == 1) {?>
			var h = GetHeight() - 100;	//allow space for header
			<?php } else { ?>
			var h = GetHeight();
			<?php } ?>
            var winratio = w / h;

			if (winratio > vidratio) {
				return h * vidratio;
			}
			else {
				return w;
			}
        }

        function getvideoheight() {
			var w = GetWidth();
			<?php if ($header == 1) {?>
			var h = GetHeight() - 100;	//allow space for header
			<?php } else { ?>
			var h = GetHeight();
			<?php } ?>
            var winratio = w / h;

			if (winratio > vidratio) {
				return h;
			}
			else {
				return w / vidratio;
			}
        }

        function setvideosize() {
            var obj = document.getElementById("videoPlayer");
			if (obj != null) {
				obj.style.width = (getvideowidth()-6) + "px";
				obj.style.height = getvideoheight() + "px";
            
				obj = document.getElementById("objplayer");
				if (obj != null) {
					obj.style.width = (getvideowidth()-6) + "px";
					obj.style.height = getvideoheight() + "px";
				}
			}

            var obj = document.getElementById("divheader");
			if (obj != null) {
				obj.style.width = (getvideowidth()-6) + "px";
			}
		}

		function getespnflashvars() {
			var ret = "SWID={3D3C6104-BAEF-465D-BA3D-29A7C30F74B3}&adminOver=3805638&player=videoHub09&height=" + getvideoheight() + "&width=" + getvideowidth() + "&autostart=false&localSite=undefined&pageName=undefined";
			return ret;
		}

		function facebookshare() {
			var obj = {
				method: 'feed',
				redirect_uri: 'https://<?php echo $_SERVER['SERVER_NAME'];?>/sherpa_share.php?VideoID=<?php echo $_REQUEST["id"];?>',
				link: 'https://<?php echo $_SERVER['SERVER_NAME'];?>/sherpa_share.php?VideoID=<?php echo $_REQUEST["id"];?>',
				picture: 'https://<?php echo $_SERVER['SERVER_NAME'];?>/Images/logo.png',
				name: 'Check out what my Sherpa found for me',
				caption: '<?php echo str_replace("'", "\\'", $title); ?>',
				description: '<?php echo str_replace("'", "\\'", $desc); ?>)'
			};

			function callback(response) { ;}

			FB.ui(obj, callback);
		}
		
		function googleshare() {
			var url = 'https://plus.google.com/share?url=https://<?php echo $_SERVER['SERVER_NAME'];?>/sherpa_share.php?VideoID=<?php echo $_REQUEST["id"];?>';
			window.open(url, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
		}
		
		function twittershare() {
			var url = 'https://twitter.com/share?url=https://<?php echo $_SERVER['SERVER_NAME'];?>/sherpa_share.php?VideoID=<?php echo $_REQUEST["id"];?>';
			window.open(url, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
		}
		
		function stumbleshare() {
			var url = 'https://www.stumbleupon.com/submit?url=https%3A%2F%2F<?php echo $_SERVER['SERVER_NAME'];?>%2Fsherpa_share.php%3FVideoID%3D<?php echo $_REQUEST["id"];?>';
			window.open(url, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=900');
		}
		
		function deliciousshare() {
			var url = 'https://del.icio.us/post?url=https://<?php echo $_SERVER['SERVER_NAME'];?>/sherpa_share.php?VideoID=<?php echo $_REQUEST["id"];?>';
			window.open(url, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
		}
		
		function pinterestshare() {
			var url = 'https://pinterest.com/pin/create/button/?url=https://<?php echo $_SERVER['SERVER_NAME'];?>/sherpa_share.php?VideoID=<?php echo $_REQUEST["id"];?>&media=<?php echo $tnail;?>&description=<?php echo str_replace("'", "\"", $title);?>';
			window.open(url, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
		}
		
		function showshareurl() {
			var dshare = document.getElementById("divShare");
			var urlshare = 'https://<?php echo $_SERVER['SERVER_NAME'];?>/sherpa_share.php?VideoID=<?php echo $_REQUEST["id"];?>';
			var sharetitle = '<?php echo str_replace(" ", "%20", str_replace("'", "\\'", $title)); ?>';
			if (dshare.innerHTML.length == 0) {
				dshare.innerHTML = "<img src='Images/facebook-share.png' alt='share on facebook' style='cursor:pointer;margin:5px;width:24px;vertical-align:bottom' onclick='facebookshare()'/>";
				dshare.innerHTML = dshare.innerHTML + "<img src='https://<?php echo $_SERVER['SERVER_NAME'];?>/Images/twitter.png' alt='share on twitter' style='cursor:pointer;margin:5px;width:24px;vertical-align:bottom' onclick='twittershare()'/>";
				dshare.innerHTML = dshare.innerHTML + "<img src='https://www.gstatic.com/images/icons/gplus-32.png' alt='share on google+' style='cursor:pointer;margin:5px;width:24px;vertical-align:bottom' onclick='googleshare()'/>";
				dshare.innerHTML = dshare.innerHTML + "<img src='https://<?php echo $_SERVER['SERVER_NAME'];?>/Images/pinterest_badge_1x.png' alt='pin it' style='cursor:pointer;margin:5px;width:24px;vertical-align:bottom' onclick='pinterestshare()'/>";
				dshare.innerHTML = dshare.innerHTML + "<img src='https://<?php echo $_SERVER['SERVER_NAME'];?>/Images/delicious-share.png' alt='share on del.icio.us' style='cursor:pointer;margin:5px;width:24px;vertical-align:bottom' onclick='deliciousshare()'/>";
				dshare.innerHTML = dshare.innerHTML + "<img src='https://<?php echo $_SERVER['SERVER_NAME'];?>/Images/stumbleupon.png' alt='share on stumbleupon' style='cursor:pointer;margin:5px;width:24px;vertical-align:bottom' onclick='stumbleshare()'/>";
				dshare.innerHTML = dshare.innerHTML + "<a href='" + urlshare + "' style='color:#696969;font-family:Helvetica, Sans-Serif; font-size:16px' target='_blank'>url</a>:&nbsp;<input type='text' readonly='readonly' size='60' value='" + urlshare + "'/>";
			}
			else
			{
				dshare.innerHTML = "";
			}
		}

	</script>

<?php if ($header == 1) { ?>
<div id="divheader" class="border" style="max-height:100px; overflow-y:auto;margin-left:auto;margin-right:auto">
<h2>
	<?php if ($profid != "-1") {
		$img = "/Images/pinned.png";
		$tooltip = "pin this to your sherpa";
		if ($pinned == 0) {
			$img = "/Images/unpinned.png";
			$tooltip = "unpin this from your sherpa";
		}
		echo "<image id='imgPinned' src='".$img."' height='32px' title='".$tooltip."' onclick='pinvideo(".$_REQUEST['id'].", ".$profid.", ".(1-$pinned).", \"imgPinned\")' style='margin:4px;height:24px;cursor:pointer'/>\n";
	}
	?>
	<?php if ($share == "1") { ?>
		<image src="Images/share.png" style="cursor:pointer" onclick="showshareurl()"/>&nbsp;
	<?php } ?>
	<?php echo $title;?><br/></h2><div id="divShare"></div>
<?php if (strlen($desc) != 0) { ?>
<?php echo $desc; ?><br/>
<?php } ?>
<?php if ($dur != 0) { ?>
<b>Duration: </b><?php echo $dur; ?>&nbsp;&nbsp;
<?php } ?>
<b>Date Added: </b><?php echo $dateupdated; ?><br/>
</div>
<?php } ?>

<?php if ($header == 1) { ?>
<div style="width:95%;height:85%;margin-left:auto;margin-right:auto">
<?php } ?>
<?php if ($channel == 1) {?>
	<?php echo "<iframe id=\"videoPlayer\" class=\"youtube-player\" style=\"margin-left:auto;margin-right:auto\" type=\"text/html\" src=\"https://www.youtube.com/embed/".$yid."\" frameborder=\"0\">" ?>
<?php } else if ($channel == 3) {?>
<!--Hulu-->
<?php
	$huluurl = str_replace("http://", $redirectprefix, $mediaurl);
	echo "<iframe id=\"frmVideo\" src=\"".$huluurl."?Auto-Start=false\" style=\"margin-left:auto;margin-right:auto\"  frameborder=\"0\"  webkitAllowFullScreen mozallowfullscreen allowfullscreen></iframe>\n";
	echo "<script type=\"text/javascript\">\n";
	   echo "document.getElementById(\"frmVideo\").height = getvideoheight();\n";
	   echo "document.getElementById(\"frmVideo\").width = getvideowidth();\n";
	echo "</script>\n\n";
?>
<?php } else if ($channel == 5) { ?>
<!--ESPN-->
	<?php $espnurl = str_replace("http://", $redirectprefix, $mediaurl); ?>
	<div id="player" class="videoplayer videoplayer-show videoplayer-videoHub09" style="margin-left:auto; margin-right:auto; margin-top: 0px !important; float:none !important;">
		<div id="videoPlayer"></div></div>
	<script type="text/javascript">
	    espn.video.embed({
	        'id': <?php echo $espnurl; ?>,
	        'width': getvideowidth(),
	        'height': getvideoheight(),
	        'playerType':"videoHub09",
	        'autoplay':"false"
	    });
	    document.getElementById("player").height = getvideoheight();
	    document.getElementById("player").width = getvideowidth();
	</script>

<?php } else if ($channel == 6) { ?>
<!-- NetFlix -->
 <div id="videoPlayer" style="margin-left:auto;margin-right:auto" >
    <a href="#" onclick="javascript:nflx.openPlayer('<?php echo $url; ?>', 0, 0, 'wmz3y3b4xushj252mnrmf626', 'divMovie');">
    <img id="imgVideo" src="<?php echo $redirectprefix; ?>cdn-7.nflximg.com/us/boxshots/large/<?php echo $origid; ?>.jpg" /></a><br/>
	<script type="text/javascript">
	   document.getElementById("imgVideo").height = getvideoheight();
	</script>
	<a href="#" style="color:#696969;font-family:Helvetica, Sans-Serif; font-size:16px" onclick="javascript:nflx.openPlayer('<?php echo $url; ?>', 0, 0, 'wmz3y3b4xushj252mnrmf626', 'divMovie');">Watch <?php echo $title;?> Now</a>
    <script type="text/javascript" src="<?php echo $redirectprefix; ?>jsapi.netflix.com/us/api/js/api.js"></script>
 </div>
<?php } else if ($channel == 7 || $channel == 18) { ?>
<!-- BNWMovies.com, Fox News -->
<?php
		echo str_replace("http://", $redirectprefix, $embedhtml) . "\n";
?>
<?php } else if ($channel == 8) { ?>
<!-- Vimeo -->
<?php
		echo str_replace("http://", "https://", $embedhtml) . "\n";
?>
<?php } else if ($channel == 12 || $channel == 13 || $channel == 15) { ?>
<!-- anyclip, vodpod, ted.com -->
<?php
		echo str_replace("http://", $redirectprefix, $embedhtml) . "\n";
		echo "<script type=\"text/javascript\">\n";
		   echo "document.getElementById(\"imgVideo\").height = getvideoheight();\n";
		   echo "document.getElementById(\"imgVideo\").width = getvideowidth();\n";
		echo "</script>\n\n";
?>
<?php } else if ($channel == 9) { ?>
<!-- dailymotion -->
<?php
		echo str_replace("http://", "https://", $embedhtml) . "\n";
		echo "<script type=\"text/javascript\">\n";
		   echo "document.getElementById(\"imgVideo\").height = getvideoheight();\n";
		   echo "document.getElementById(\"imgVideo\").width = getvideowidth();\n";
		echo "</script>\n\n";
?>
<?php } else if ($channel == 11) { ?>
<!-- blip.tv -->
<?php
	//<iframe src="http://blip.tv/play/AYOYw0cC.x?p=1" width="720" height="433" frameborder="0" allowfullscreen></iframe><embed type="application/x-shockwave-flash" src="http://a.blip.tv/api.swf#AYOYw0cC" style="display:none"></embed>
	echo "<iframe id=\"frmVideo\" src=\"".str_replace("http://", $redirectprefix, $url)."?p=1\" width=\"".$wid."\" height=\"".$hgt."\" style=\"margin-left:auto;margin-right:auto\"  frameborder=\"0\" allowfullscreen></iframe>\n";
	echo "<script type=\"text/javascript\">\n";
	   echo "document.getElementById(\"frmVideo\").height = getvideoheight();\n";
	   echo "document.getElementById(\"frmVideo\").width = getvideowidth();\n";
	echo "</script>\n\n";
?>
<?php } ?>
<?php if ($header == 1) { ?>
</div>
<?php } ?>
</body>

</html>
