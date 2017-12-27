<?php
	class Ident {
		function __construct() {
			global $display,$theme;
			$display->crumbs[] = "Identification";
			$display->show_form = false;
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				$aname = isset($_POST['aname']) ? $_POST['aname'] : false;
				$aemail = isset($_POST['aemail']) ? $_POST['aemail'] : false;
				if($aname) {
					$_SESSION['aname'] = $aname;
				}
				if($aemail) {
					$_SESSION['aemail'] = $aemail;
				}
			}
			$display->to_output .= $theme->global_form_start("index.php?act=id","post","Identification");
			$display->to_output .= $theme->global_form_text("Display Name","aname",(isset($_SESSION['aname']) ? $_SESSION['aname'] : false));
			$display->to_output .= $theme->global_form_text("Email","aemail",(isset($_SESSION['aemail']) ? $_SESSION['aemail'] : false));
			$display->to_output .= $theme->global_form_end();
		}
	}
	$idx = new Ident;
?>
