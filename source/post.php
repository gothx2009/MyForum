<?php
	class Post {
		function __construct() {
			global $myforum, $db;
			if($_SERVER['REQUEST_METHOD'] !== "POST") {
				$myforum->redirect("index.php");
			}
			$tid = isset($_POST['tid']) ? intval($_POST['tid']) : 0;
			$content = isset($_POST['pcontent']) ? trim($_POST['pcontent']) : false;
			$email = isset($_POST['aemail']) ? trim($_POST['aemail']) : false;
			$title = isset($_POST['ttitle']) ? $db->real_escape_string($_POST['ttitle']) : false;
			$authorname = isset($_POST['aname']) ? $db->real_escape_string(trim($_POST['aname'])) : null;
			$email = $db->real_escape_string($email);
			$content = $db->real_escape_string($content);
			if(!$content || !$email || $content == "" || $email == "") {
				$myforum->redirect("index.php");
			}
			if(!$tid) {
				$db->query("INSERT INTO t (pinned,locked,aemail,title) VALUES(0,0,'{$email}','{$title}');");
				$tid = $db->insert_id;
			}
			$db->query("INSERT INTO p (parent,aname,aemail,content) VALUES ('{$tid}','{$authorname}','{$email}','{$content}');");
			$myforum->redirect("index.php?showtopic=".$tid);
		}
	}
	$idx = new Post;
?>
