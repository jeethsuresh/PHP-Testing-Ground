<html>


<?php

$q = $_GET['q'];
$con = mysql_connect("localhost","thatkidf_reader","reader");
if (!$con){
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("thatkidf_mysqltest") or die("no db");

$result = mysql_query("SELECT * FROM titles WHERE ID='".mysql_real_escape_string($q)."'");

$row = mysql_fetch_array($result);

echo $title;

$tags = $row['Tags'];
$article = nl2br($row['Article']);
$imagesource = $row['Images'];
$image = array();
for($i = 0; $i < substr_count($imagesource, "&"); $i++){
	$image[$i] = substr($imagesource, 0, strpos($imagesource, "&"));
	$imagesource = substr($imagesource, strpos($imagesource, "&")+1);
}
$image[substr_count($imagesource, "&")+1] = substr($imagesource, strripos($imagesource, "uploads"), strripos($imagesource, "&"));
$title = $row['Title'];

echo '<script>
function noFundRaisers(){
	alert("We have no fundraisers going on!");
}
</script><head><div id="cssmenu">
<ul>
   	<li class="active"><a href="http://thatkidfrommars.x10.mx/php/index.html" style="font-size: 38px">The Green Observer</a>
	<li class="active"><a href="http://thatkidfrommars.x10.mx/php/phpsystem/getissue.php?q=201304">Current Issue</a>
	<li class="active"><a href="http://thatkidfrommars.x10.mx/php/pastissues.html">Past Issues</a>
	<li class="active"><a href="http://thatkidfrommars.x10.mx/php/socialmedia.html">Social Media</a>
	<li class="active"><a href="http://thatkidfrommars.x10.mx/php/calendar.html">Calendar</a>
	<li class="active"><a href="http://thatkidfrommars.x10.mx/php/gostaff.html">About Us</a>
	<li class="active"><a href="javascript:noFundRaisers();">Donate!</a>
</ul>
</div></head>';

echo "
<div id='wrap'><body><link href='articlepage.css' rel='stylesheet' type='text/css' />
<h1>{$title}</h1><br>";
if($image != NULL){
	$imagestuff = "../".$image[0];
	echo "<div id='wrapper' style='text-align: center'><img src={$imagestuff} /></div><br>";
}
for($j = 1; $j <= count($image); $j++){
	if($image[$j] != ""){
		$imageinput = "../".$image[$j];
		$article = preg_replace("/<img>/", "<div id='wrapper' style='text-align: center; padding: 15px'><img src={$imageinput}></img></div>", $article, 1);
	}
}	

echo "<article><p>Author: {$row['Author']}	</p><br>{$article}</article>";
if($row['MediaEmbedCode'] != NULL){
	echo "<div id='video'><center>{$row['MediaEmbedCode']}</center></div>";
}
echo "<p>Tags: {$tags}</p><br>
</body></div>";

?>


</html>