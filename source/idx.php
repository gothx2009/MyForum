<?php
	$display->crumbs[] = "Home";
	$display->to_output .= "<div class='category'><div class='maintitle'>Discussions</div>";
	if($result = $db->query("SELECT * FROM t ORDER BY i DESC")) {
		while($row = $result->fetch_array()) {
			// List topics
		}
	}
	$display->to_output .= "</div>";
?>
