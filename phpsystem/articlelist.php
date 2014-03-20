<html>


<?php

$q = $_GET['q'];
$con = mysql_connect('caitga.ipagemysql.com', 'mysqlreader', 'reader'); 
if (!$con){
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("mysqltest") or die("no db");

$q = str_replace("_", " ", $q);

$result = mysql_query("SELECT * FROM titles WHERE Author='".mysql_real_escape_string($q)."'");

$row_list = array();
$rowcounter = 0;
while($this_row = mysql_fetch_array($result)){
	$row_list[$rowcounter] = $this_row;
	$rowcounter = $rowcounter + 1;
}
echo "<link href='issuepage.css' rel='stylesheet' type='text/css' />";
echo '<script>
function noFundRaisers(){
	alert("We have no fundraisers going on!");
}
</script>

<div id="cssmenu">
<ul>
   	<li class="active"><a href="http://greenobservermagazine.com/index.html" style="font-size: 38px">The Green Observer</a>
	<li class="active"><a href="http://greenobservermagazine.com/phpsystem/getissue.php?q=201401">Current Issue</a>
	<li class="active"><a href="http://greenobservermagazine.com/pastissues.html">Past Issues</a>
	<li class="active"><a href="http://greenobservermagazine.com/socialmedia.html">Social Media</a>
	<li class="active"><a href="http://greenobservermagazine.com/calendar.html">Calendar</a>
	<li class="active"><a href="http://greenobservermagazine.com/gostaff.html">About Us</a>
	<li class="active"><a href="javascript:noFundRaisers();">Donate!</a>
</ul>
</div>';
echo '<div id="wrap"><body><div class="container">';
$count = 0;
for($i = 0; $i < count($row_list); $i++){
	$linkto = "http://greenobservermagazine.com/phpsystem/outwithphp.php?q=".$row_list[$i]['ID'];
	if(substr($row_list[$i]['IssueOrganization'], 0, 9) == "spotlight"){
		$imgstring = "../".substr($row_list[$i]['IssueOrganization'], 10);
		echo "<div id='space' style='height: 20px;'></div>
		<div class='spotlight'>
			<img class='spotlightimage' src={$imgstring}></img>
			<a href={$linkto}><h1>{$row_list[$i]['Title']}</h1></a>
			<p>{$row_list[$i]['Blurb']}</p>
		</div>";
		$count = 4;
	}
	/*else if(substr($row_list[$i]['IssueOrganization'], 0) == "feature"){
		echo "
		<div class='featurenoimage'>
			<a href={$linkto}><h3>{$row_list[$i]['Title']}</h3></a>
			<p>{$row_list[$i]['Blurb']}</p>
		</div>";
		$count = $count + 2;
	}*/
	else if(substr($row_list[$i]['IssueOrganization'], 0, 8) == "feature,"){
		$imgstring = "../".substr($row_list[$i]['IssueOrganization'], 8);
		echo "
		<div class='feature'>
			<img class='imgfeature' src={$imgstring}></img>
			<a href={$linkto}><h1>{$row_list[$i]['Title']}</h1></a>
			<p>{$row_list[$i]['Blurb']}</p>
		</div>";
		$count = $count + 2;
	}
	else{
		echo "
		<div class='single'>
		<a href={$linkto}><h3>{$row_list[$i]['Title']}</h3></a>
		<p>{$row_list[$i]['Blurb']}</p>
		</div>";
		$count = $count + 1;
	}
	if($count == 4 && $i != count($row_list) - 1){
		echo '<HR WIDTH="75%" COLOR="#a7bc7a" SIZE="4" noshade style="background-color: #a7bc7a;">';
		$count = 0;
	}
}
echo '</div></body></div>';	

?>
</html>