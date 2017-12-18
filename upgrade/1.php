<?php
	$sql = array();
	$sql[] = "ALTER TABLE `t` ADD `aemail` VARCHAR(255) NULL DEFAULT NULL AFTER `pinned`;";
	$sql[] = "ALTER TABLE `p` ADD `aemail` VARCHAR(255) NOT NULL AFTER `aname`;";
?>
