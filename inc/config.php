<?php
	if(!defined("MYFORUM")) {
		die("Direct initialization of this file is not allowed.");
	}
	$c->show_version	= true;
	$c->theme			= "8bit";
	$sql = array();
	$board = array();
  
	$sql['hostname'] = "localhost";
	$sql['username'] = "root";
	$sql['password'] = "";
	$sql['database'] = "myforum";
	
	$board["name"] 			 = "MyForum";
	$board["posts_per_page"] = 15;
	$board["admin_pin"]		 = "0000";
?>
