<?php
	define("MYFORUM", true);
	$c = new stdclass;
	$config = new stdclass;
	include("inc/config.php");
	include("inc/class.myforum.php");
	include("inc/class.display.php");
	session_start();
	$myforum = new MyForum($c);
	$theme_file = "themes/default.php";
	if(file_exists("themes/".$myforum->config->theme.".php")) {
		$theme_file = "themes/".$myforum->config->theme.".php";
	}
	include($theme_file);
	$display = new Display;
	$theme = new Theme;
	$db = new mysqli($sql['hostname'],$sql['username'],$sql['password'],$sql['database']);
	$act = isset($_GET['act']) ? $_GET['act'] : false;
	if(isset($_GET['showtopic'])) {
		$act = "ST";
		$_GET['id'] = $_GET['showtopic'];
	}
	switch($act) {
		case "pin":
			include("source/pin.php");
			break;
		case "post":
			include("source/post.php");
			break;
		case "ST":
			include("source/topic.php");
			break;
		default:
			include("source/idx.php");
			break;
	}
	$display->output();
?>