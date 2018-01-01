<?php
	class Display {
		var $crumbs = array();
		var $ptitle = "Topic";
		var $show_form = true;
		var $to_output;
		function output() {
			global $config, $myforum, $theme;
			$css = "<link rel='stylesheet' href='html/myforum.css'>";
			if(file_exists("themes/".$config->theme.".css")) {
				$css = "<link rel='stylesheet' href='themes/".$config->theme.".css'>";
			}
			$html = "<!DOCTYPE html><html><head><meta charset='utf-8'>";
			$html .= $theme->meta_extra();
			$html .= "<title>". $config->site_name ."</title>";
			$html .= $css;
			$html .= $theme->css_extra();
			$html .= "</head><body>";
			$idlink = "<a href='./index.php?act=id' class='link'>Identify</a>";
			if($myforum->user->name !== "Anonymous") {
				$idlink = "";
			}
			$html .= $theme->global_userbar($idlink, $myforum->user);
			$html .= $theme->global_start();
			if(isset($_SESSION['error'])) {
				$html .= $theme->global_alert($_SESSION['error'][0],$_SESSION['error'][1]);
				unset($_SESSION['error']);
			}
			$html .= $theme->global_bread_start();
			$html .= $theme->global_bread_sep();
			$html .= implode($theme->global_bread_sep(), $this->crumbs);
			$html .= $theme->global_bread_end();
			$html .= $this->to_output;
			if($this->show_form) {
				$tid = isset($_GET['id']) ? intval($_GET['id']) : 0;
				$title = "Post ".$this->ptitle;
				$html .= $theme->global_form_start("index.php?act=post","post",$title);
				$html .= $theme->global_form_hidden("tid",$tid);
				$html .= $theme->global_form_hidden("aname",$myforum->user->name);
				$html .= $theme->global_form_hidden("aemail",$myforum->user->email);
				if($this->ptitle == "Topic") {
					$html .= $theme->global_form_text("Topic Title", "ttitle");
				}
				$html .= $theme->global_form_textarea("Post Content", "pcontent");
				$html .= $theme->global_form_end();
			}
			$version = false;
			if($config->show_version) {
				$version = " (v".$myforum->version.")";
			}
			$copyright = "<div id='copyright'>Powered by <a href='http://mlutz.us'>MyForum</a>{$version}</div>";
			$html .= $copyright;	
			$html .= $theme->global_end();
			exit($html);
		}
	}
?>
