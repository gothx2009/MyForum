<?php
	class Display {
		var $crumbs = array();
		var $ptitle = "Topic";
		var $to_output;
		function output() {
			global $board, $myforum;
			$html  = "<!DOCTYPE html><html lang='en'><head>";
			$html .= "<meta charset='utf-8'>";
			$html .= "<title>". $board['name'] ."</title>";
			$html .= "<link rel='stylesheet' href='css/default.css'>";
			$html .= "</head><body><div id='wrapper'>";
			$html .= "<div id='logostrip'>". $board['name'] ."</div>";
			$html .= "<ul class='topmenu'><li><a href='./index.php'>Home</a></li></ul>";
			$html .= "<div id='main'>";
			if(isset($_SESSION['error'])) {
				$html .= "<div class='alert alert_".$_SESSION['error'][0]."'>".$_SESSION['error'][1]."</div>";
				unset($_SESSION['error']);
			}
			$html .= "<div class='crumbs'><a href='./index.php'>".$board['name']."</a> / ";
			$html .= implode(" / ", $this->crumbs);
			$html .= "</div>";
			$html .= $this->to_output;
			$html .= "<div class='category'><form method='post' action='index.php?act=post'>";
			if(isset($_GET['id'])) {
				$html .= "<input type='hidden' name='tid' value='".intval($_GET['id'])."'>";
			}
			$html .= "<div class='maintitle'>Post ".$this->ptitle."</div><table>";
			if($this->ptitle == "Topic") {
				$html .= "<tr><td>Topic Title:</td><td><input type='text' name='ttitle'></td></tr>";
			}
			$html .= "<tr><td>Post Content:</td><td><textarea name='pcontent'></textarea></td></tr><tr><td colspan='2'><input type='submit' value='Post'></td></tr></table></form></div>";
			$html .= "";
			$html .= "<div id='copyright'>Powered by <a href='http://mlutz.us'>MyForum</a>";
			if($board["showversion"]) {
				$html .= " (v".$myforum->version.")";
			}
			$html .= ".</div>";
			$html .= "</div></div></body></html>";
			echo $html;
		}
	}
?>
