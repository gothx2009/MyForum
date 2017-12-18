<?php
	class Display {
		var $crumbs = array();
		var $ptitle = "Topic";
		var $to_output;
		function output() {
			global $board;
			$html  = "<!DOCTYPE html><html lang='en'><head>";
			$html .= "<meta charset='utf-8'>";
			$html .= "<title>". $board['name'] ."</title>";
			$html .= "<link rel='stylesheet' href='css/default.css'>";
			$html .= "</head><body><div id='wrapper'>";
			$html .= "<div id='logostrip'>". $board['name'] ."</div>";
			$html .= "<ul class='topmenu'><li><a href='./index.php'>Home</a></li></ul>";
			$html .= "<div id='main'>";
			$html .= "<div class='crumbs'><a href='./index.php'>".$board['name']."</a> / ";
			$html .= implode(" / ", $this->crumbs);
			$html .= "</div>";
			$html .= $this->to_output;
			$html .= "<div class='category'><form method='post'><div class='maintitle'>Post ".$this->ptitle."</div><table>";
			if($this->ptitle == "Topic") {
				$html .= "<tr><td>Topic Title:</td><td></td></tr>";
			}
			$html .= "<tr><td></td><td></td></tr></table></form></div>";
			echo $html;
		}
	}
?>
