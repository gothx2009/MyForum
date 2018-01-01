<?php
	class MyForum {
		var $user;
		var $version = "0.8.1";
		function __construct() {
			$u = new stdclass;
			$u->name = isset($_SESSION['aname']) ? $_SESSION['aname'] : "Anonymous";
			$u->email = isset($_SESSION['aemail']) ? $_SESSION['aemail'] : "anonymous@user.tld";
			$u->avatar = $this->gravatar($u->email,100,'mm','g',true,array("class"=>"userbar_avatar"));
			$this->user = $u;
		}
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