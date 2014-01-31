<?php

$con = mysql_connect("localhost","thatkidf_user","password");
if (!$con){
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("thatkidf_mysqltest") or die("no db");

$articlesubmit = str_replace("'", "''", $_POST[article]);

$finalimagelist = "";

for($i = 0; $i < count($_FILES['img']['name']); $i++){
	$tmpfilepath = $_FILES['img']['tmp_name'][$i];
	
	if($tmpfilepath != "" && ((strcasecmp(substr($_FILES['img']['name'][$i], -4), ".jpg") == 0) 
							|| (strcasecmp(substr($_FILES['img']['name'][$i], -4), ".gif") == 0) 
							|| (strcasecmp(substr($_FILES['img']['name'][$i], -4), ".jpg") == 0))){
		$newfilepath = "uploads/" . uniqid() . substr(md5(rand()), 0, 10) . substr($_FILES['img']['name'][$i], strrpos($_FILES['img']['name'][$i], "."));
		if(move_uploaded_file($tmpfilepath, $newfilepath)){
			echo "Uploaded ". $tmpfilepath . " to " . $newfilepath; 
		}
		$finalimagelist = $finalimagelist . $newfilepath . "&";
	}
}

$titlesubmit = str_replace("'", "''", $_POST[title]);
$tagsubmit = str_replace("'", "''", $_POST[tags]);
$articleid = uniqid() . substr(md5(rand()), 0, 5);


mysql_query("INSERT INTO titles (Title, Article, Images, ID, Tags)
	VALUES ('$titlesubmit', '$articlesubmit', '$finalimagelist', '$articleid', '$tagsubmit')") or die (mysql_error());

echo "Finished";

mysql_close($con);

?>