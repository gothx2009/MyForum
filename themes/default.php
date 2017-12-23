<?php
	if(!defined("MYFORUM")) {
		die("Direct initialization of this file is not allowed.");
	}
	class Theme {
		function end_copyright() {
			return "</div>";
		}
		function start_copyright() {
			return "<div id='copyright'>";
		}
	}
?>
