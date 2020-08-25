<html>
<body>

<?php
$client_multi_results = 131072;
$conn = mysql_connect("localhost", "mediabup", "Buhner19", 0, $client_multi_results);
mysql_select_db("mediabup", $conn);

$res = mysql_query("call UserVideoList(7)") or die("failed to execute query: ".mysql_error($conn));
while ($row = mysql_fetch_row($res)) {
   echo $row[1] . "<br/>\n";
}
?>

</body>
</html>
