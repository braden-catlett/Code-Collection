<?php
	$primary_color="#376092";
	$secondary_color="#95b3d7";
	
	if (isset($_REQUEST['sherp']) && strlen($_REQUEST['sherp']) > 0) {
		$sherp = (int)$_REQUEST['sherp'];
		$conn = mysql_connect("fb-db2.sherpin.com", "mediabup", "Buhner19") or die("Failed to connect: " . mysql_error());
		mysql_select_db("mediabup") or die("Failed to select db: " . mysql_error($conn));
		$sql = "SELECT Skin FROM Users WHERE ID=".$sherp.";";
		$res = mysql_query($sql);
		if ($res && mysql_num_rows($res) > 0) {
			$ret = mysql_fetch_row($res);
			
			if (strlen($ret[0]) > 0) {
				$css = $ret[0].".css";
				
				if (strcmp($ret[0], "mmg-aq") == 0) {
					$primary_color = "#009999";
					$secondary_color = "#33cccc";
				}
				else if (strcmp($ret[0], "mmg-valentine") == 0) {
					$primary_color = "#9a0000";
					$secondary_color = "#95B3D7";
				}
				else if (strcmp($ret[0], "mmg-sapphire") == 0) {
					$primary_color = "#1010da";
					$secondary_color = "#86abf6";
				}
				else if (strcmp($ret[0], "mmg-royalpurple") == 0) {
					$primary_color = "#713e88";
					$secondary_color = "#e6e0ec";
				}
				else if (strcmp($ret[0], "mmg-r") == 0) {
					$primary_color = "#c00000";
					$secondary_color = "#e6b9b8";
				}
				else if (strcmp($ret[0], "mmg-o") == 0) {
					$primary_color = "#e46c0a";
					$secondary_color = "#fac090";
				}
				else if (strcmp($ret[0], "mmg-marshmallow") == 0) {
					$primary_color = "#fff7e1";
					$secondary_color = "#d9d9d9";
				}
				else if (strcmp($ret[0], "mmg-magenta") == 0) {
					$primary_color = "#a626c0";
					$secondary_color = "#e6e0ec";
				}
				else if (strcmp($ret[0], "mmg-lemonhead") == 0) {
					$primary_color = "#fcf600";
					$secondary_color = "#f2f2f2";
				}
				else if (strcmp($ret[0], "mmg-g3") == 0) {
					$primary_color = "#4f6228";
					$secondary_color = "#c3d69b";
				}
				else if (strcmp($ret[0], "mmg-g2") == 0) {
					$primary_color = "#00b050";
					$secondary_color = "#c3d69b";
				}
				else if (strcmp($ret[0], "mmg-g1") == 0) {
					$primary_color = "#77933c";
					$secondary_color = "#c3d69b";
				}
				else if (strcmp($ret[0], "mmg-flowerstem") == 0) {
					$primary_color = "#369600";
					$secondary_color = "#c3d69b";
				}
				else if (strcmp($ret[0], "mmg-emerald") == 0) {
					$primary_color = "#004c00";
					$secondary_color = "#a2a0a0";
				}
				else if (strcmp($ret[0], "mmg-crimson") == 0) {
					$primary_color = "#9a0000";
					$secondary_color = "#a2a0a0";
				}
				else if (strcmp($ret[0], "mmg-creamsicle") == 0) {
					$primary_color = "#ff9933";
					$secondary_color = "#ffee8b";
				}
				else if (strcmp($ret[0], "mmg-cascadia") == 0) {
					$primary_color = "#004c00";
					$secondary_color = "#a2a0a0";
				}
				else if (strcmp($ret[0], "mmg-buttercup") == 0) {
					$primary_color = "#ffffa7";
					$secondary_color = "#d9d9d9";
				}
				else if (strcmp($ret[0], "mmg-burntorange") == 0) {
					$primary_color = "#dd6409";
					$secondary_color = "#fac090";
				}
				else if (strcmp($ret[0], "mmg-bubblegum") == 0) {
					$primary_color = "#ea449b";
					$secondary_color = "#ffd5f0";
				}
				else if (strcmp($ret[0], "mmg-aquamist") == 0) {
					$primary_color = "#45bee9";
					$secondary_color = "#b7dee8";
				}
				else if (strcmp($ret[0], "mmg-aq") == 0) {
					$primary_color = "#009999";
					$secondary_color = "#33cccc";
				}
			}
		}
	}
?>

<style>
	body   
	{
	    background: #fff;
	    font-size: .80em;
	    font-family: "Helvetica Neue", "Lucida Grande", "Segoe UI", Arial, Helvetica, Verdana, sans-serif;
	    margin: 0px;
	    padding: 0px;
	    color: #696969;
	}
	
	div.border 
	{
	    border-style:solid; 
	    border-color:<?php echo $secondary_color; ?>; 
	    border-width:3px;
	    padding:4px;
	}
	
	b
	{
		color:<?php echo $primary_color;?>;
	}
	
	.primary
	{
	    background:<?php echo $primary_color; ?>; 
	}
	
	.secondary
	{
	    background:<?php echo $secondary_color; ?>;
	}
	
	a:link 
	{
		text-decoration: none;
	}
	a:visited 
	{
		text-decoration: none;
	}
	a:hover 
	{
		text-decoration: none;
	}
	
	a.listitem {
		font-family:"Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
		font-size:medium;
		color:#333333
	}
	
	a.listitem:hover {
		text-decoration: none;
		background-color:#d0d0d0;
	}
	
	/* HEADINGS   
	----------------------------------------------------------*/
	
	h1, h2, h3, h4, h5, h6
	{
	    font-size: 1.5em;
	    color: <?php echo $primary_color; ?>;
	    font-variant: small-caps;
	    text-transform: none;
	    font-weight: 200;
	    margin-bottom: 0px;
	}
	
	h1
	{
	    font-size: 1.6em;
	    padding-bottom: 0px;
	    margin-bottom: 0px;
	    color:<?php echo $primary_color; ?>;
	}
	
	h2
	{
	    font-size: 1.5em;
	    font-weight: 600;
	    color: <?php echo $secondary_color; ?>;
	}
	
	h3
	{
	    font-size: 1.2em;
	}
	
	h4
	{
	    font-size: 1.1em;
	}
	
	h5, h6
	{
	    font-size: 1em;
	}
	
	.menuitem {
	    font-size: 1.5em;
	    color: <?php echo $primary_color; ?>;
	    font-variant: small-caps;
	    text-transform: none;
	    font-weight: 200;
	    margin-bottom: 0px;
	}

	.draggable {
		position: relative;
	}
</style>