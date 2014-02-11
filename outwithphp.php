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
$image = substr($row['Images'], 0, strpos($row['Images'], "&"));
$title = $row['Title'];

echo '<head><ul id=menu class="center">
<li><a href="http://greenobservermagazine.com/newindex.html" style="font-size: 42px">The Green Observer</a>
<li><a href="http://greenobservermagazine.com/ArticlesAndImages/goissuefall2013.html">Current Issue</a>
<li><a href="http://greenobservermagazine.com/previous%20issues.html">Past Issues</a>
<li><a href="http://greenobservermagazine.com/SocialMedia.html">Social Media</a>
<li><a href="http://greenobservermagazine.com/your%20planet.html">Calendar</a>
<li><a href="http://greenobservermagazine.com/about.html">About Us</a>
<li><a href="javascript:noFundRaisers();">Donate!</a>
</ul></head>';

echo "<body><link href='articlepage.css' rel='stylesheet' type='text/css' />
<h1>{$title}</h1><br>
<div id='video'><center>{$row['MediaEmbedCode']}</center></div>
<article>{$article}</article><br>";
if($image != NULL){
echo "<div id='wrapper' style='text-align: center'><img src={$image} /></div><br>";
}
echo "<p>Tags: {$tags}</p><br>
<p>Author: {$row['Author']}</p></body>";

?>


</html>