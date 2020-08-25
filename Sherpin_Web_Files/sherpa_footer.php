<div style="width:100%;background:#00263a;position:fixed;bottom:0px">
	<script>
	function showfeedback() {
		$.colorbox({ href: 'feedback.php', width: 500, height: 320, opacity: 0.70 })
	}
	</script>

	<?php if ($index != 1) { ?>
	<span style="margin-left:20px;color:white; font-family:Segoe UI, Sans-Serif; font-size:10px; cursor:pointer" onclick="showfeedback()"><i>feedback</i></span>
	<?php } ?>
	<?php
		if (isset($_SESSION["USER_ID"]) && $_SESSION["USER_ID"] != -1) {
			$mysqli = new mysqli("fb-db2.sherpin.com", "mediabup", "Buhner19");
			$mysqli->select_db("mediabup");
			$res = $mysqli->query("call GetIsAdmin(".$_SESSION["USER_ID"].");");
			while ($mysqli->next_result());
			$usr = $res->fetch_assoc();
			if ($usr['Admin'] == 1) {
	?>
	<a href="/review.php" style="margin-left:20px;color:white; font-family:Segoe UI, Sans-Serif; font-size:10px"><i>review</i></a>
	<?php } } ?>
	<a href="/privacy.php" style="margin-left:20px;color:white; font-family:Segoe UI, Sans-Serif; font-size:10px"><i>privacy</i></a>
	<a href="/termsuse.php" style="margin-left:20px;color:white; font-family:Segoe UI, Sans-Serif; font-size:10px"><i>terms of use</i></a>
	<a href="/about.php" style="margin-left:20px;color:white; font-family:Segoe UI, Sans-Serif; font-size:10px"><i>about</i></a>
</div>
