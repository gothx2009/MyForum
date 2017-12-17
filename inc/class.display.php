<?php
	class Display {
		var $to_output;
		function output() {
			global $board;
			$html  = "<!DOCTYPE html><html lang='en'><head>";
			// Meta Data
			$html .= "<meta charset='utf-8'>";
			// Title
			$html .= "<title>". $board['name'] ."</title>";
			// CSS
			$html .= "<link rel='stylesheet' href='css/default.css'>";
			$html .= "</head><body><div id='wrapper'>";
			// Logostrip
			$html .= "<div id='logostrip'>". $board['name'] ."</div>";
			// Menu
			$html .= "<ul class='topmenu'><li><a href='./index.php'>Home</a></li></ul>";
			echo $html;
		}
	}
?>
