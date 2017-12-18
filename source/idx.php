<?php
	$display->crumbs[] = "Home";
	$display->to_output .= "<div class='category'><div class='maintitle'>Discussions</div><table>";
	if($result = $db->query("SELECT * FROM t ORDER BY pinned DESC, i DESC")) {
		$pinned = 0;
		while($row = $result->fetch_object()) {
			if($row->pinned && $pinned == 0) {
				$display->to_output .= "<tr><th>Pinned Topics:</th></tr>";
			}
		}
	}
	$display->to_output .= "</table></div>";
?>
