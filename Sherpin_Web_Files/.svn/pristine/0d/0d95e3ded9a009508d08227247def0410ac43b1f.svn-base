<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<!-- saved from url=(0014)about:internet -->
<head>
	<?php include("head.html") ?>
	<?php include 'setstyle.php'; ?>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<script type="text/javascript">
	function selectall(id)
	{
		document.getElementById(id).focus();
		document.getElementById(id).select();
	}

    function showuser() {
		var isloggedin = getloggedin();
        if (isloggedin != 0) {
            var viewer = document.getElementById("aviewer");
            if (viewer != null) viewer.style.visibility = "visible";

            var btns = document.getElementById("loginbuttons");
            if (btns != null) {
				btns.style.visibility = "collapse";
				btns.style.height = "0px";
			}
            var loggedin = document.getElementById("loggedinuser");
            if (loggedin != null) loggedin.style.visibility = "visible";
        }
		setwelcomebar();
    }
	</script>
</head>
<body style="text-align:center; min-width:500px; min-height:300px"  >
    <?php include("header.html") ?>
    <?php $page = "mobile"; include("topmenubar.php") ?>

    <form id="form1" style="height:75%" runat="server">
        <table border="0" style="height:100%; width:100%">
            <tr style="height:100%">
            <td style="height:100%">
            <div id="silverlightControlHost" style="height:95%; vertical-align:middle; text-align:center; border-style:solid; border-color:#3b5998; border-width:3px;" >
            
            <div style="text-align:center">
            	<img src="/Images/ios.png" alt="iOS" style="height:80px;margin:20px"/>
            	<img src="/Images/android.png" alt="Android" style="height:80px;margin:20px"/>
            	<img src="/Images/winphone7.png" alt="Windows Phone 7" style="height:80px;margin:20px"/>
            </div>
            <div style="text-align:center">
	            <p>
	            	<b>Coming Soon</b> ...  Soon you will be able to get ‘sherpin’ on your favorite mobile device!  We’re putting the finishing touches on our mobile apps so you can get ‘sherpin’ while you are on the go!  Stay tuned for information regarding our release dates!
	            </p>
            </div>
            <div style="text-align:center">
            	<img src="/Images/tablets.png" alt="Tablets" style="height:80px;margin:20px"/>
            	<img src="/Images/phones.png" alt="Phones" style="height:80px;margin:20px"/>
            	<img src="/Images/desktop.png" alt="Desktops" style="height:80px;margin:20px"/>
			</div>            
            <div style="text-align:center; vertical-align:middle; margin:20px">
            	<img src="/Images/xboxconsole.png" alt="Console" style="height:80px;"/>
				<span style="vertical-align:middle; margin:20px; height:80px"><b>Coming in Spring 2012</b> ...  you will be able to get ‘sherpin’ on your favorite gaming platform, the XBox360!</span>
            	<img src="/Images/xboxlogo.png" alt="Xbox 360" style="height:80px;"/>
			</div>            
            <div style="text-align:center">
	            <p>
	            	Our mission at ‘sherpin.com’ is to bring  media you want to watch to every platform our users want media.  So, we are planning on adding additional devices, gaming consoles and internet enabled televisions as platform options for our users  along with additional content sources and features.  We want you to be able to be ‘sherpin’ anytime, anywhere and everywhere our users want to watch.  <i>Stop searching ... Start watching!</i>
					If you want to provide us your suggestions, thoughts or comments, please email us at: <a href="mailto:feedback@sherpin.com">feedback@sherpin.com</a>
	            </p>
            </div>
            <div style="text-align:center; margin:10px">
            	<small>All logos used are registered trademarks and all rights are reserved for the identified corporations and products owned by those corporations.</small>
            </div>

            </div>

            <?php include("bottommenubar.php") ?>
            </td>
            <td style="height:100%; width:200px; text-align:right; vertical-align:top">
            <?php include 'rightframe.php' ?>
            </td>
            </tr>
        </table>
    </form><br />
	<script>getlogininfo();</script>
</body>
</html>
