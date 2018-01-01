<?php
	$display->crumbs[] = "Home";
	$display->to_output .= "<div class='category'><div class='maintitle'>Discussions</div><table>";
	if($result = $db->query("SELECT * FROM t ORDER BY pinned DESC, i DESC")) {
		$pinned = 0;
		$started = 0;
		while($row = $result->fetch_object()) {
			if($row->pinned && $pinned == 0) {
				$pinned = 1;
				$display->to_output .= "<tr><th colspan='2'>Pinned Topics:</th></tr>";
			}
			if(!$row->pinned && $pinned == 1 && $started == 0) {
				$started = 1;
				$display->to_output .= "<tr><th colspan='2'>Topics:</th></tr>";
			}
			$trstart = "<tr>";
			$prefix = "";
			$display->to_output .= "";
			if($row->locked) {
				$trstart = "<tr class='locked'>";
				$prefix = "<strong>LOCKED: </strong>";
			}
			$display->to_output .= $trstart."<td>".$prefix;
			$display->to_output .= "<a href='./index.php?showtopic=".$row->i."'>". $row->title ."</a></td><td class='ava'>".$myforum->gravatar($row->aemail,100,"mm","g",true,array())."</td></tr>";
		}
	}
	$display->to_output .= "</table></div>";
?>
