<html>


<?php

$q = $_GET['q'];
$con = mysql_connect('caitga.ipagemysql.com', 'mysqlreader', 'reader'); 
if (!$con){
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("mysqltest") or die("no db");

$result = mysql_query("SELECT * FROM titles WHERE ID='".mysql_real_escape_string($q)."'");

$row = mysql_fetch_array($result);

echo $title;

$tags = $row['Tags'];
$article = nl2br($row['Article']);
$imagesource = $row['Images'];
$image = array();
if($imagesource != NULL){
	for($i = 0; $i < substr_count($imagesource, "&"); $i++){
		$image[$i] = substr($imagesource, 0, strpos($imagesource, "&"));
		$imagesource = substr($imagesource, strpos($imagesource, "&")+1);
	}
}
$image[substr_count($imagesource, "&")+1] = substr($imagesource, strripos($imagesource, "uploads"), strripos($imagesource, "&"));
$title = $row['Title'];

echo '<script>
function noFundRaisers(){
	alert("We have no fundraisers going on!");
}
</script><head><div id="cssmenu">
<ul>
   	<li class="active"><a href="http://greenobservermagazine.com/index.html" style="font-size: 38px">The Green Observer</a>
	<li class="active"><a href="http://greenobservermagazine.com/phpsystem/getissue.php?q=201401">Current Issue</a>
	<li class="active"><a href="http://greenobservermagazine.com/pastissues.html">Past Issues</a>
	<li class="active"><a href="http://greenobservermagazine.com/socialmedia.html">Social Media</a>
	<li class="active"><a href="http://greenobservermagazine.com/calendar.html">Calendar</a>
	<li class="active"><a href="http://greenobservermagazine.com/gostaff.html">About Us</a>
	<li class="active"><a href="javascript:noFundRaisers();">Donate!</a>
</ul>
</div></head>';

echo "
<div id='wrap'><body><link href='articlepage.css' rel='stylesheet' type='text/css' />
<h1>{$title}</h1><br>";
if($image[0] != NULL){
	$imagestuff = "../".$image[0];
	echo "<div id='wrapper' style='text-align: center'><img src={$imagestuff} /></div><br>";
}
for($j = 1; $j <= count($image); $j++){
	if($image[$j] != ""){
		$imageinput = "../".$image[$j];
		$article = preg_replace("/<img>/", "<div id='wrapper' style='text-align: center; padding: 15px'><img src={$imageinput}></img></div>", $article, 1);
	}
}	
$authorname = str_replace(" ", "_", $row['Author']);
$authorpic = "../GOStaff/".$authorname.".jpg";
$authorlink = "profilepage.php?q=".$authorname;

echo "<article><img id='authorpic' src={$authorpic} /><div id='authorname'>By {$row['Author']} <br> <a href={$authorlink}>See {$row['Author']}'s Profile</a><br></div><br>{$article}";
if($row['MediaEmbedCode'] != NULL){
	echo "<div id='video'><center>{$row['MediaEmbedCode']}</center></div>";
}
/**echo "<p><b><u>Tags:</u></b> {$tags}</p>";**/
echo "</article><br>
</body></div>";

?>


</html>