<?php
	define("MYFORUM", true);
	include("inc/config.php");
	$db = new mysqli($sql['hostname'],$sql['username'],$sql['password'],$sql['database']);
	$sql = array();
	$sql[] = "CREATE TABLE `t` ( `i` INT(100) NOT NULL AUTO_INCREMENT , `pinned` INT(100) NOT NULL DEFAULT '0' , `aemail` VARCHAR(255) NULL DEFAULT NULL , `title` VARCHAR(255) NOT NULL , PRIMARY KEY (`i`)) ENGINE = InnoDB;";
	$sql[] = "CREATE TABLE `p` ( `i` INT(100) NOT NULL AUTO_INCREMENT , `parent` INT(100) NOT NULL , `aname` VARCHAR(255) NULL DEFAULT NULL , `aemail` VARCHAR(255) NULL DEFAULT NULL , `content` TEXT NOT NULL , PRIMARY KEY (`i`)) ENGINE = InnoDB;";
	foreach($sql as $s) {
		$db->query($s);
	}
?>
