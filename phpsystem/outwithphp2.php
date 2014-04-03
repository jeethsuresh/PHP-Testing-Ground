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

$resultIssue = $row['Issue'];
$sidebar = mysql_query("SELECT * FROM titles WHERE Issue={$resultIssue}");

$row_list = array();
while($this_row = mysql_fetch_array($sidebar)){
	$row_list[$this_row['TableOrg']-1] = $this_row;
}

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
   	<li class="active"><a href="http://thatkidfrommars.x10.mx/php/index.html" style="font-size: 38px">The Green Observer</a>
	<li class="active"><a href="http://thatkidfrommars.x10.mx/php/phpsystem/getissue.php?q=201401">Current Issue</a>
	<li class="active"><a href="http://thatkidfrommars.x10.mx/php/pastissues.html">Past Issues</a>
	<li class="active"><a href="http://thatkidfrommars.x10.mx/php/socialmedia.html">Social Media</a>
	<li class="active"><a href="http://thatkidfrommars.x10.mx/php/calendar.html">Calendar</a>
	<li class="active"><a href="http://thatkidfrommars.x10.mx/php/gostaff.html">About Us</a>
	<li class="active"><a href="javascript:noFundRaisers();">Donate!</a>
</ul>
</div></head>';

echo "<div id='supercontainer' style='display: inline-flex; width:100%;'><div id='sidebar' style='display: inline-block; width: 300px; background-color: #7eb704; text-align: center;'>";

echo "<h1 style='font-size:25px; background-color: #7eb704;'>More from this issue:</h1>";
for($i = 0; $i < count($row_list); $i++){	
	$linkto = "http://greenobservermagazine.com/phpsystem/outwithphp.php?q=".$row_list[$i]['ID'];
        if($row_list[$i]['ID'] != $q){
	echo "<a href={$linkto}><p style='background: #7eb704; padding: 10px;'>{$row_list[$i]['Title']}</p></a>";
        }else{echo "<a href={$linkto}><p style='padding: 10px;'>{$row_list[$i]['Title']}</p></a>";}
}

echo "</div>";

echo "<div id='wrap' style='display:inline-block; width: 850px'><body><link href='articlepage.css' rel='stylesheet' type='text/css' />
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

echo "<article><img id='authorpic' src={$authorpic} /><div id='authorname'>By {$row['Author']} <br> <a href={$authorlink}>See {$row['Author']}'s Profile</a><br></div><br>{$article}<br><p>Tags: {$tags}</p></article>";
if($row['MediaEmbedCode'] != NULL){
	echo "<div id='video'><center>{$row['MediaEmbedCode']}</center></div>";
}
echo "<br>
</body></div></div></div>";

?>


</html>