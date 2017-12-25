<?php
	if(!defined("MYFORUM")) {
		die("Direct initialization of this file is not allowed.");
	}
	$config->admin_pin		= "0000";
	$config->show_version	= true;
	$config->site_name		= "MyForum";
	$config->theme			= "default";
	$config->post_per_page	= 15;
	$sql = array();
  
	$sql['hostname'] = "localhost";
	$sql['username'] = "root";
	$sql['password'] = "";
	$sql['database'] = "myforum";
?>
