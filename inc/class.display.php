<?php
	class Display {
		var $crumbs = array();
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
			
			// Page content.
			$html .= $this->to_output;
			echo $html;
		}
	}
?>
