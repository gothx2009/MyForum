<?php
	define("MYFORUM", true);
	include("inc/config.php");
	include("inc/class.myforum.php");
	include("inc/class.display.php");
	session_start();
	$myforum = new MyForum;
	$display = new Display;
	$db = new mysqli($sql['hostname'],$sql['username'],$sql['password'],$sql['database']);
	$db->query("CREATE TABLE IF NOT EXISTS p(i INT AUTO_INCREMENT, a INT, b TEXT, KEY(i))");
	$db->query("ALTER TABLE `p` ADD PRIMARY KEY(`i`)");
	$db->query("ALTER TABLE `p` DROP INDEX `i`;");
	$db->query("ALTER TABLE `p` CHANGE `i` `i` INT(100) NOT NULL AUTO_INCREMENT;");
	$db->query("ALTER TABLE `p` CHANGE `a` `parent` INT(100) NOT NULL DEFAULT '0';");
	$db->query("ALTER TABLE `p` CHANGE `b` `content` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;");
	$db->query("ALTER TABLE `p` ADD `aname` VARCHAR(255) NOT NULL AFTER `parent`;");
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