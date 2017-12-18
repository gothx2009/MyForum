<?php
	include("inc/config.php");
	$db = new mysqli($sql['hostname'],$sql['username'],$sql['password'],$sql['database']);
	$sql = array();
	$sql[] = "ALTER TABLE `t` ADD `aemail` VARCHAR(255) NULL DEFAULT NULL AFTER `pinned`;";
	$sql[] = "ALTER TABLE `p` ADD `aemail` VARCHAR(255) NOT NULL AFTER `aname`;";
	foreach($sql as $s) {
		$db->query($s);
	}
?>
