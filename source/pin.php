<?php
	class Pin {
		function __construct() {
			global $display;
			$display->show_post_form = false;
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				
			} else {
				$this->show_pin_form();
			}
		}
		function show_pin_form() {
			global $display;
			$display->crumbs[] = "Administration PIN";
			$code = isset($_GET['c']) ? intval($_GET['c']) : false;
			$id = isset($_GET['i']) ? intval($_GET['i']) : false;
			$html = "<div class='category pinform'><form action='./index.php?act=pin'><input type='hidden' name='code' value='". $code ."'><input type='hidden' name='id' value='". $id ."'><div class='maintitle'>Administration PIN</div><table><tr><td>";
			switch($code) {
				case 1:
				default:
					$html .= "Enter the PIN to delete post #". $id;
					break;
			}
			$html .= "<br /><br /><input type='text' name='adminpin'></td></tr></table></form></div>";
			
			$display->to_output .= $html;
		}
	}
	$idx = new Pin;
?>