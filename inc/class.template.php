<?php
	class Template {
		function css_extra() {
			return "";
		}
		function global_alert($class,$msg) {
			return "<div class='alert alert_{$class}'>{$msg}</div>";
		}
		function global_bread_end() {
			return "</div>";
		}
		function global_bread_sep() {
			return " / ";
		}
		function global_bread_start() {
			global $config;
			return "<div class='crumbs'><a href='./index.php'>{$config->site_name}</a>";
		}
		function global_end() {
			return "</div></div></body></html>";
		}
		function global_form_end() {
			return "<tr><td colspan='2'><input type='submit' value='Submit Post'></td></tr></table></div></form>";
		}
		function global_form_hidden($name,$value) {
			return "<input type='hidden' name='{$name}' value='{$value}'>";
		}
		function global_form_start($action,$method,$title) {
			return "<form method='{$method}' action='{$action}'><div class='category'><div class='maintitle'>{$title}</div><table>";
		}
		function global_form_text($label,$name) {
			return "<tr><td>{$label}:</td><td><input type='text' name='{$name}'></td></tr>";
		}
		function global_form_textarea($label,$name) {
			return "<tr><td>{$label}</td><td><textarea name='{$name}'></textarea></td></tr>";
		}
		function global_start() {
			global $config;
			return "<div id='wrapper'><div id='logostrip'>{$config->site_name}</div><ul class='topmenu'><li><a href='./index.php'>Home</a></li></ul><div id='main'>";
		}
		function meta_extra() {
			return "";
		}
	}
?>
