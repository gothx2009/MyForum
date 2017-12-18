<?php
	$title = isset($_POST['ttitle']) ? $_POST['ttitle'] : false;
	$sql = "INSERT INTO t(pinned,title) VALUES (0,'".$title."');";
	$sql = "INSERT INTO p(i,a,b) VALUES ('','','');";
?>
