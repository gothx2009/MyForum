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
	$topicID = isset($_POST['tid']) ? $_POST['tid'] : false;
	$title = isset($_POST['ttitle']) ? $db->real_escape_string($_POST['ttitle']) : false;
	$authorname = isset($_POST['aname']) ? $db->real_escape_string(trim($_POST['aname'])) : null;
	if($title) {
		$sql = "INSERT INTO t(pinned,title) VALUES (0,'".$title."');";
		$db->query($sql);
		$topicID = $db->insert_id;
	}
	$sql = "INSERT INTO p(parent,aname,content) VALUES ('".$topicID."','".$authorname."','".$db->real_escape_string($content)."');";
	$db->query($sql);
	header("Location: ./index.php?showtopic=".$topicID);
	exit;
?>
