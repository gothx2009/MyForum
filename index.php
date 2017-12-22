<?php
	define("MYFORUM", true);
	$c = new stdclass;
	include("inc/config.php");
	include("inc/class.myforum.php");
	include("inc/class.display.php");
	session_start();
	$myforum = new MyForum($c);
	$display = new Display;
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