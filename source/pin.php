<?php
	class Pin {
		function __construct() {
			global $display, $board;
			$display->show_post_form = false;
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				$code = isset($_POST['code']) ? intval($_POST['code']) : false;
				$id = isset($_POST['id']) ? intval($_POST['id']) : false;
				$pin = isset($_POST['adminpin']) ? $_POST['adminpin'] : false;
				if(!$pin) {
					$_SESSION['error'] = array("error", "You must enter a pin.");
					$this->show_pin_form();
				} if($pin !== $board['admin_pin']) {
					$_SESSION['error'] = array("error", "Invalid PIN");
					$this->show_pin_form();
				} else {
					switch($code) {
						case 1:
						default:
							$this->delete_post($id);
							break;
					}
				}
			} else {
				$this->show_pin_form();
			}
		}
		function delete_post($id) {
			global $db;
			$sql = "DELETE FROM p WHERE i='". $id ."'";
			if($result = $db->query($sql)) {
				
			}
		}
		function show_pin_form() {
			global $display;
			$display->crumbs[] = "Administration PIN";
			$code = isset($_GET['c']) ? intval($_GET['c']) : false;
			$id = isset($_GET['i']) ? intval($_GET['i']) : false;
			$html = "<div class='category pinform'><form action='./index.php?act=pin' method='post'><input type='hidden' name='code' value='". $code ."'><input type='hidden' name='id' value='". $id ."'><div class='maintitle'>Administration PIN</div><table><tr><td>";
			switch($code) {
				case 1:
				default:
					$html .= "Enter the PIN to delete post #". $id;
					break;
			}
			$html .= "<br /><br /><input type='text' name='adminpin'></td></tr><tr><td><input type='submit' value='Submit'></td></tr></table></form></div>";
			
			$display->to_output .= $html;
		}
	}
	$idx = new Pin;
?>