    <div id="sherpa_header" style="width:100%;">
        <div style="float:left">
			<?php if (strstr($_SERVER['PHP_SELF'], 'sherpa_view.php') == FALSE && strstr($_SERVER['PHP_SELF'], 'sherpa_share.php') == FALSE) { ?>
			<img src="/Images/backbutton.png" alt="" height="60px" style="cursor:pointer;vertical-align:top" onclick="window.location='/sherpa_view.php'"/>
			<?php } ?>
        </div>
        <div style="float:left">
	        <a href="/sherpa_view.php" style="margin-left:40px;"><img src="Images/header.png" style="height:50px"></a>
        </div>
        <div style="float:right">
            <span id="spanUser" style="cursor:pointer;color: white; font: <?php echo $spanfontsize ?> Helvetica, Sans-Serif; padding: 10px; margin: 10px;" onclick="startlogin(<?php echo $detect->isMobile(); ?>)">sign in</span>
            <!--<span id="spanLogout" style="cursor:pointer;color: white; font: <?php echo $spanfontsize ?> Helvetica, Sans-Serif; padding: 10px; margin: 10px;"></span>-->
			<input id="txtsearch" type="input" size="20"/><img style="cursor:pointer;margin-right:70px;" src="Images/search.png" onclick="quicksearch();"/>
        </div>
        <div style="clear:both"></div>
    </div>
