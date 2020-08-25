<?php
header ("Content-type: image/png");
$time = urlencode(date("h:m a"));
readfile("http://www.spokanesabersfc.net/fonts/ifr.php?text=".$time);
?>