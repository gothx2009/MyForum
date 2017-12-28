<?php
	define("MYFORUM", true);
	include("../inc/config.php");
	$db = new mysqli($sql['hostname'],$sql['username'],$sql['password'],$sql['database']);
	$sql = array();
	$sql[] = "CREATE TABLE `myforum`.`users` ( `id` INT(100) NOT NULL AUTO_INCREMENT , `username` VARCHAR(255) NOT NULL , `email` VARCHAR(255) NOT NULL , `pass` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;"
	foreach($sql as $s) {
		$db->query($s);
	}
?>