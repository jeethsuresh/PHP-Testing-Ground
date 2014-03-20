<html>


<?php

$q = $_GET['q'];
$con = mysql_connect('caitga.ipagemysql.com', 'mysqlreader', 'reader'); 
if (!$con){
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("mysqltest") or die("no db");

$q = str_replace("_"," ",$q);

$result = mysql_query("SELECT * FROM titles WHERE Author='".mysql_real_escape_string($q)."'");
$writerprofile = mysql_query("SELECT * FROM writers WHERE Name='".mysql_real_escape_string($q)."'");

$row_list = array();
$rowcounter = 0;
while($this_row = mysql_fetch_array($result)){
	$row_list[$rowcounter] = $this_row;
	$rowcounter = $rowcounter + 1;
}
$writername = mysql_fetch_assoc($writerprofile);

echo "<link href='profilepage.css' rel='stylesheet' type='text/css' />";
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

$imagestring = "../GOStaff/".$writername['Image'];
$name = $writername['Name'];
$biog = $writername['Bio'];
$emailme = "mailto:".$writername['Email'];
$firstname = substr($name, 0, strpos($name, " "));
echo '<div id="profile">';
echo "<img id='profilepic' src={$imagestring} />";
echo '<div id="details">';
echo "<h1>{$name}</h1>";
echo "<h3>{$biog}</h3>";
if($writername['Email'] != NULL){
	echo "<h3><a href={$emailme}>Email {$firstname}</a></h3>";
}
echo '</div></div>';
echo "<h1 style='text-align: center'>Articles By {$firstname} </h1>";

for($i = 0; $i < count($row_list); $i++){
	$linkto = "http://greenobservermagazine.com/phpsystem/outwithphp.php?q=".$row_list[$i]['ID'];
	if(substr($row_list[$i]['IssueOrganization'], 0, 9) == "spotlight" ){
		$imgstring = "../".substr($row_list[$i]['IssueOrganization'], 10);
		echo "<div id='space' style='height: 20px;'></div>
		<div class='spotlight'>
			<img class='spotlightimage' src={$imgstring}></img>
			<a href={$linkto}><h1>{$row_list[$i]['Title']}</h1></a>
			<p>{$row_list[$i]['Blurb']}</p>
		</div>";
	}
    else if(substr($row_list[$i]['IssueOrganization'], 0, 8) == "feature,"){
        $imgstring = "../".substr($row_list[$i]['IssueOrganization'], 8);
        echo "<div id='space' style='height: 20px;'></div>
        <div class='spotlight'>
            <img class='spotlightimage' src={$imgstring}></img>
            <a href={$linkto}><h1 style='padding: 20px;'>{$row_list[$i]['Title']}</h1></a>
            <p>{$row_list[$i]['Blurb']}</p>
        </div>";
    }

	else{
		echo "
		<div class='spotlight'>
		<img class='spotlightimage' src='../go_logo.png'></img>
		<a href={$linkto}><h1>{$row_list[$i]['Title']}</h1></a>
		<p>{$row_list[$i]['Blurb']}</p>
		</div>";
	}
    echo '<HR WIDTH="75%" COLOR="#a7bc7a" SIZE="4" noshade style="background-color: #a7bc7a;">';
}
echo '</div></body></div>';	

?>
</html>