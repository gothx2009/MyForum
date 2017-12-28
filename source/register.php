<?php
	class Register {
		function __construct() {
			global $display, $theme, $db, $myforum;
			$display->show_form = false;
			$display->crumbs[] = "Account Registration";
			$form = true;
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				$form = false;
				$username   = isset($_POST['aname'])  ? trim($_POST['aname'])  : false;
				$email      = isset($_POST['aemail']) ? trim($_POST['aemail']) : false;
				$password   = isset($_POST['apass'])  ? trim($_POST['apass'])  : false;
				$passverify = isset($_POST['apass2']) ? trim($_POST['apass2']) : false;
				if(!$username||!$email||!$password||!$passverify) {
					$form = true;
				} else if($username==""||$email==""||$password==""||$passverify=="") {
					$form = true;
				} else if($password !== $passverify) {
					$form = true;
				} else {
					$found = false;
					$username = $db->real_escape_string($username);
					if($result = $db->query("SELECT * FROM users WHERE username='{$username}'")) {
						if($result->num_rows >= 1) {
							$found = true;
							$form = true;
						}
					}
					if(!$found) {
						$email = $db->real_escape_string($email);
						$password = md5($password);
						$db->query("INSERT INTO users(username,email,pass) VALUES ('{$username}','{$email}','{$password}')");
						$myforum->redirect("index.php?act=login");
					}
				}
			}
			if($form) {
				$display->to_output .= $theme->global_form_start("index.php?act=reg","post","Account Registration");
				$display->to_output .= $theme->global_form_text("Username","aname","","(Required)");
				$display->to_output .= $theme->global_form_text("Email Address","aemail","","(Required)");
				$display->to_output .= $theme->global_form_password("Password","apass","","(Required)");
				$display->to_output .= $theme->global_form_password("Password Verification","apass2","","(Required)");
				$display->to_output .= $theme->global_form_end();
			}
		}
	}
	$idx = new Register;
?>
