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
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$ppp = $board["posts_per_page"];
	$result = $db->query("SELECT COUNT(*) AS ppp FROM p");
	$row = $result->fetch_object();
	$postCount = $row->ppp;
	$pages = ceil($postCount/$ppp);
	$display->to_output .= "<div class='pagination'><ul><li>Pages: </li>";
	if($page > 1) {
		$display->to_output .= "<li><a href='./index.php?showtopic=".$id."'><<</a></li>";
		$display->to_output .= "<li><a href='./index.php?showtopic=".$id."&page=".($page-1)."'><</a></li>";
	} else {
		$display->to_output .= "<li><<</li><li><</li>";
	}
	for($i=$page-5;$i<=$page+5;$i++) {
		if($i>0 && $i<=$pages) {
			if($i == $page) {
				$display->to_output .= "<li class='active'>".$i."</li>";
			} else {
				$display->to_output .= "<li><a href='./index.php?showtopic=".$id."&page=".$i."'>".$i."</a></li>";
			}
		}
	}
	if($page < $pages) {
		$display->to_output .= "<li><a href='./index.php?showtopic=".$id."&page=".($page+1)."'>></a><li><a href='./index.php?showtopic=".$id."&page=".$pages."'>>></a></li>";
	} else {
		$display->to_output .= "<li>></li><li>>></li>";
	}
	$display->to_output .= "</ul></div>";
	$display->to_output .= "<div class='category'><div class='maintitle'>".$topic->title."</div><table>";
	$offset = (($page-1)*$ppp);
	if($result = $db->query("SELECT * FROM p WHERE parent='".$id."' LIMIT {$offset},{$ppp}")) {
		while($row = $result->fetch_object()) {
			$display->to_output .= "<tr><td>".$row->aname."</td><td>".$row->content."</td></tr>";
		}
	}
	$display->to_output .= "</table></div>";
?>
