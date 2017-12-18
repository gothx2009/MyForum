<?php
	$content = isset($_POST['pcontent']) ? trim($_POST['pcontent']) : false;
	if(!$content || $content == "") {
		$_SESSION['error'] = array("error", "You must fill out the form completely.");
		if(!$myforum->in_forum) {
			header("Location: ./index.php");
			exit;
		} else {
		}
	}
	$topicID = 0;
	if(!$myforum->in_forum) {
		$title = isset($_POST['ttitle']) ? $db->real_escape_string($_POST['ttitle']) : false;
		$sql = "INSERT INTO t(pinned,title) VALUES (0,'".$title."');";
		$db->query($sql);
		$topicID = $db->insert_id;
	}
	$sql = "INSERT INTO p(parent,text) VALUES ('".$topicID."','".$db->real_escape_string($content)."');";
	header("Location: ./index.php?showtopic=".$topicID);
	exit;
?>
