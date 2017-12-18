<?php
	$display->crumbs[] = "Home";
	$display->to_output .= "<div class='category'><div class='maintitle'>Discussions</div><table>";
	if($result = $db->query("SELECT * FROM t ORDER BY pinned DESC, i DESC")) {
		$pinned = 0;
		while($row = $result->fetch_object()) {
			if($row->pinned && $pinned == 0) {
				$pinned = 1;
				$display->to_output .= "<tr><th>Pinned Topics:</th></tr>";
			}
			if(!$row->pinned && $pinned == 1) {
				$display->to_output .= "<tr><th>Topics:</th></tr>";
			}
			$display->to_output .= "<tr><td><a href='./index.php?showtopic=".$row->i."'>". $row->title ."</a></td></tr>";
		}
	}
	$display->to_output .= "</table></div>";
?>
