<?php
	class Register {
		function __construct() {
			global $display, $theme;
			$display->show_form = false;
			$display->crumbs[] = "Account Registration";
			$form = true;
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				$form = false;
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
