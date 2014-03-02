<html>


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
echo "<link href='issuepage.css' rel='stylesheet' type='text/css' />";
echo '<script>
function noFundRaisers(){
	alert("We have no fundraisers going on!");
}
</script><head><ul id=menu class="center">
<li><a href="http://greenobservermagazine.com/newindex.html" style="font-size: 38px">The Green Observer</a>
<li><a href="http://greenobservermagazine.com/ArticlesAndImages/goissuefall2013.html">Current Issue</a>
<li><a href="http://greenobservermagazine.com/previous%20issues.html">Past Issues</a>
<li><a href="http://greenobservermagazine.com/SocialMedia.html">Social Media</a>
<li><a href="http://greenobservermagazine.com/your%20planet.html">Calendar</a>
<li><a href="http://greenobservermagazine.com/about.html">About Us</a>
<li><a href="javascript:noFundRaisers();">Donate!</a>
</ul></head>';
echo '<div id="wrap"><body><div class="container">';
for($i = 0; $i < count($row_list); $i++){
	$linkto = "http://thatkidfrommars.x10.mx/php/outwithphp.php?q=".$row_list[$i]['ID'];
	if(substr($row_list[$i]['IssueOrganization'], 0, 9) == "spotlight"){
		$imgstring = substr($row_list[$i]['IssueOrganization'], 10);
		echo "<div id='space' style='height: 56px;'></div>
		<div class='spotlight'>
			<img class='spotlightimage' src={$imgstring}></img>
			<a href={$linkto}><h1>{$row_list[$i]['Title']}</h1></a>
			<p>{$row_list[$i]['Blurb']}</p>
		</div>";
	}
	else if(substr($row_list[$i]['IssueOrganization'], 0) == "feature"){
		echo "
		<div class='featurenoimage'>
			<a href={$linkto}><h3>{$row_list[$i]['Title']}</h3></a>
			<p>{$row_list[$i]['Blurb']}</p>
		</div>";
	}
	else if(substr($row_list[$i]['IssueOrganization'], 0, 8) == "feature,"){
		$imgstring = substr($row_list[$i]['IssueOrganization'], 8);
		echo "
		<div class='feature'>
			<img class='imgfeature' src={$imgstring}></img>
			<a href={$linkto}><h3>{$row_list[$i]['Title']}</h3></a>
			<p>{$row_list[$i]['Blurb']}</p>
		</div>";
	}
	else{
		echo "
		<div class='single'>
		<a href={$linkto}><h3>{$row_list[$i]['Title']}</h3></a>
		<p>{$row_list[$i]['Blurb']}</p>
		</div>";
	}
}
echo '</div></body></div>';	

?>
</html>