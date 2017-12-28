<?php
	class Index {
		var $pinned = false;
		var $started = false;
		function __construct() {
			global $db, $display, $myforum, $theme;
			$display->crumbs[] = "Home";
			$display->to_output .= $theme->global_cat_start("Discussions");
			if($result = $db->query("SELECT * FROM t ORDER BY pinned DESC, i DESC")) {
				while($row = $result->fetch_object()) {
					$pin = "";
					if($row->pinned && !$this->pinned) {
						$this->pinned = true;
						$pin = "";
						$display->to_output .= $theme->index_pinned_start();
					}
					if(!$row->pinned && $this->pinned && !$this->started) {
						$this->started = true;
						$display->to_output .= $theme->index_pinned_end();
					}
					$author = new stdclass;
					$link = "<a href='./index.php?showtopic=".$row->i."'>".$row->title."</a>";
					$author->avatar = $myforum->gravatar($row->aemail,100,"mm","g",true,array());
					if($row->locked) {
						$display->to_output .= $theme->index_row_locked($pin, $link, $author);
					} else {
						$display->to_output .= $theme->index_row($pin, $link, $author);
					}
				}
			}
			$display->to_output .= $theme->global_cat_end();
		}
	}
	$idx = new Index;
?>
