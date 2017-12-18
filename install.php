<?php
	$sql = array();
	$sql[] = "CREATE TABLE `t` ( `id` INT(100) NOT NULL AUTO_INCREMENT , `pinned` INT(100) NOT NULL DEFAULT '0' , `aemail` VARCHAR(255) NULL DEFAULT NULL , `title` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
?>
