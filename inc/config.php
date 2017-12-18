<?php
	if(!defined("MYFORUM")) {
		die("Direct initialization of this file is not allowed.");
	}
	$sql = array();
	$board = array();
  
	$sql['hostname'] = "localhost";
	$sql['username'] = "root";
	$sql['password'] = "";
	$sql['database'] = "myforum";
	
	$board["name"] 			 = "MyForum";
	$board["showversion"]	 = 1;
	$board["posts_per_page"] = 15;
?>
