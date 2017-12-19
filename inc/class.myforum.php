<?php
	class MyForum {
		var $sym_version = "0.7.0";
		var $version = "1-DEV";
		function gravatar($email,$s=80,$d="mm",$r="g",$img=false,$atts=array()) {
			$url = "//www.gravatar.com/avatar/";
			$url .= md5(strtolower(trim($email)));
			$url .= "?s=$s&d=$d&r=$r";
			if($img) {
				$url = "<img src='".$url."'";
				foreach($atts as $k => $v) {
					$url .= " ".$k."='".$v."'";
				}
				$url .= ">";
			}
			return $url;
		}
		function redirect($location) {
			header("Location: ".$location);
			exit;
		}
	}
?>