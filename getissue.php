<html>
<link href='articlepage.css' rel='stylesheet' type='text/css' />

<?php

$q = $_GET['q'];
$con = mysql_connect("localhost","thatkidf_reader","reader");
if (!$con){
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("thatkidf_mysqltest") or die("no db");

$result = mysql_query("SELECT * FROM titles WHERE Issue='".mysql_real_escape_string($q)."'");

$row_list = array();
while($this_row = mysql_fetch_array($result)){
	$row_list[$this_row['TableOrg']-1] = $this_row;
}

echo '<script>
function noFundRaisers(){
	alert("We have no fundraisers going on!");
}
</script><head><ul id=menu class="center">
<li><a href="http://greenobservermagazine.com/newindex.html" style="font-size: 42px">The Green Observer</a>
<li><a href="http://greenobservermagazine.com/ArticlesAndImages/goissuefall2013.html">Current Issue</a>
<li><a href="http://greenobservermagazine.com/previous%20issues.html">Past Issues</a>
<li><a href="http://greenobservermagazine.com/SocialMedia.html">Social Media</a>
<li><a href="http://greenobservermagazine.com/your%20planet.html">Calendar</a>
<li><a href="http://greenobservermagazine.com/about.html">About Us</a>
<li><a href="javascript:noFundRaisers();">Donate!</a>
</ul></head>';
echo '<body><div class="container">';
for($i = 0; $i < count($row_list); $i++){
	$linkto = "http://thatkidfrommars.x10.mx/php/outwithphp.php?q=".$row_list[$i]['ID'];
	if(substr($row_list[$i]['IssueOrganization'], 0, 9) == "spotlight"){
		$imgstring = substr($row_list[$i]['IssueOrganization'], 10);
		echo "
		<div class='spotlight' style='display: block'>
		<img class='spotlight' src={$imgstring} style='width: 500px; height: 400px; display: block; margin: 0 auto;'></img>
		<a href={$linkto}><h1>{$row_list[$i]['Title']}</h1></a>
		<p>{$row_list[$i]['Blurb']}</p>
		</div>";
	}
	else if(substr($row_list[$i]['IssueOrganization'], 0) == "feature"){
		echo "
		<div class='feature' style='float: left; width: 50%; height: 250px; text-align: center;'>
		<a href={$linkto}><h3>{$row_list[$i]['Title']}</h3></a>
		<p>{$row_list[$i]['Blurb']}</p>
		</div>";
	}
	else if(substr($row_list[$i]['IssueOrganization'], 0, 8) == "feature,"){
		$imgstring = substr($row_list[$i]['IssueOrganization'], 8);
		echo "
		<div class='feature' style='display: inline; width: 50%; height: 300px; float: left; overflow: auto; text-align: center'>
		<img class='feature' src={$imgstring} style='width: 200px; height: 150px;display: block; margin: 0 auto;'></img>
		<a href={$linkto}><h3>{$row_list[$i]['Title']}</h3></a>
		<p>{$row_list[$i]['Blurb']}</p>
		</div>";
	}
	else{
		echo "
		<div class='single' style='float:left; overflow: auto; display: inline; width: 25%; height: 300px; text-align: center'>
		<a href={$linkto}><h3>{$row_list[$i]['Title']}</h3></a>
		<p>{$row_list[$i]['Blurb']}</p>
		</div>";
	}
}
echo '</div></body>';	

?>
</html>