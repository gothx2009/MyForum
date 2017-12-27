<?php
	class Pin {
		function __construct() {
			global $display, $config;
			$display->show_form = false;
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				$code = isset($_POST['code']) ? intval($_POST['code']) : false;
				$id = isset($_POST['id']) ? intval($_POST['id']) : false;
				$pin = isset($_POST['adminpin']) ? $_POST['adminpin'] : false;
				if(!$pin) {
					$_SESSION['error'] = array("error", "You must enter a pin.");
					$this->show_pin_form();
				} if($pin !== $config->admin_pin) {
					$_SESSION['error'] = array("error", "Invalid PIN");
					$this->show_pin_form();
				} else {
					switch($code) {
						case 5:
							$this->lock_topic($id);
							break;
						case 4:
							$this->unpin_topic($id);
							break;
						case 3:
							$this->pin_topic($id);
							break;
						case 2:
							$this->delete_topic($id);
							break;
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
			global $db, $display;
			$sql = "DELETE FROM p WHERE i='". $id ."'";
			if($result = $db->query($sql)) {
				$display->crumbs[] = "Post Deleted";
				$_SESSION['error'] = array("success", "Your post has been deleted.");
			}
		}
		function delete_topic($id) {
			global $db, $display;
			$db->query("DELETE FROM p WHERE parent='". $id ."'");
			$db->query("DELETE FROM t WHERE i='". $id ."'");
			$display->crumbs[] = "Topic Deleted.";
			$_SESSION['error'] = array("success", "The topic has been deleted.");
		}
		function lock_topic($id) {
			global $db, $myforum;
			$db->query("UPDATE t SET locked=1 WHERE i='".$id."'");
			$myforum->redirect("index.php?showtopic=".$id);
		}
		function pin_topic($id) {
			global $db, $myforum;
			$db->query("UPDATE t SET pinned=1 WHERE i='".$id."'");
			$myforum->redirect("index.php?showtopic=".$id);
		}
		function show_pin_form() {
			global $display;
			$display->crumbs[] = "Administration PIN";
			$code = isset($_GET['c']) ? intval($_GET['c']) : false;
			$id = isset($_GET['i']) ? intval($_GET['i']) : false;
			$html = "<div class='category pinform'><form action='./index.php?act=pin' method='post'><input type='hidden' name='code' value='". $code ."'><input type='hidden' name='id' value='". $id ."'><div class='maintitle'>Administration PIN</div><table><tr><td>";
			switch($code) {
				case 5:
					$html .= "Enter the PIN to lock topic #". $id;
					break;
				case 4:
					$html .= "Enter the PIN to unpin topic #". $id;
					break;
				case 3:
					$html .= "Enter the PIN to pin topic #". $id;
					break;
				case 2:
					$html .= "Enter the PIN to delete topic #". $id;
					break;
				case 1:
				default:
					$html .= "Enter the PIN to delete post #". $id;
					break;
			}
			$html .= "<br /><br /><input type='text' name='adminpin'></td></tr><tr><td><input type='submit' value='Submit'></td></tr></table></form></div>";
			
			$display->to_output .= $html;
		}
		function unpin_topic($id) {
			global $db, $myforum;
			$db->query("UPDATE t SET pinned=0 WHERE i='".$id."'");
			$myforum->redirect("index.php?showtopic=".$id);
		}
	}
	$idx = new Pin;
?>