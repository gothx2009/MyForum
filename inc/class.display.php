<?php
	class Display {
		var $to_output;
		function output() {
			$html  = "<!DOCTYPE html><html lang='en'><head>";
			// Meta Data
			$html .= "<meta charset='utf-8'>";
			// CSS
			$html .= "<link rel='stylesheet' href='css/default.css'>";
			$html .= "</head><body><div id='wrapper'>";
			echo $html;
		}
	}
?>
