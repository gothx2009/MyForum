<?php
	$id = isset($_GET['id']) ? intval($_GET['id']) : false;
	if(!$id || $id == 0) {
		$_SESSION['error'] = array("error", "Improper URL.");
		header("Location: ./index.php");
		exit;
	}
	$topic = false;
	if($result = $db->query("SELECT * FROM t WHERE i='".$id."'")) {
		if($result->num_rows < 1) {
			$_SESSION['error'] = array("error", "Topic #".$id." does not exist.");
			header("Location: ./index.php");
			exit;
		}
		$topic = $result->fetch_object();
	}
	$display->crumbs[] = "Viewing topic: <a href='./index.php?showtopic=".$id."'>".$topic->title."</a>";
	$display->ptitle = "Reply";
	$display->to_output .= "<div class='category'><div class='maintitle'>".$topic->title."</div><table>";
	if($result = $db->query("SELECT * FROM p WHERE parent='".$id."'")) {
		while($row = $result->fetch_object()) {
			$display->to_output .= "<tr><td>".$row->content."</td></tr>";
		}
	}
	$display->to_output .= "</table></div>";
?>
