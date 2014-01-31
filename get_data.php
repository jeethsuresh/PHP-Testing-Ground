<?php

	$q = $_REQUEST["q"];
	
	$con = mysql_connect("localhost","thatkidf_user","password");
	if (!$con){
  		die('Could not connect: ' . mysql_error());
 	}
	mysql_select_db("thatkidf_mysqltest") or die("no db");

	$result = mysql_query("SELECT * FROM titles WHERE Title='%q%'");
	

	$data = mysql_fetch_assoc($result);
	echo "{$data[Title]}";
	
	
?>