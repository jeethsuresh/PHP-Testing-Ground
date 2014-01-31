<html>
<body>

<?php

$q = $_GET['q'];
$con = mysql_connect("localhost","thatkidf_user","password");
if (!$con){
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("thatkidf_mysqltest") or die("no db");

$result = mysql_query("SELECT * FROM titles WHERE ID='".mysql_real_escape_string($q)."'");

$row = mysql_fetch_array($result);

echo $title;

$tags = $row['Tags'];
$article = $row['Article'];
$title = $row['Title'];

echo "<p>Title: {$title}</p><br>
	<p>Article: {$article}</p><br>
	<p>Tags: {$tags}</p>
	<p>ID: {$q}</p>";

?>

</body>
</html>