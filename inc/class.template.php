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
		function global_cat_end() {
			return "</table></div>";
		}
		function global_cat_start($title) {
			return "<div class='category'><div class='maintitle'>{$title}</div><table>";
		}
		function global_end() {
			return "</div></div></body></html>";
		}
		function global_form_end() {
			return "<tr><td colspan='2'><input type='submit' value='Submit'></td></tr></table></div></form>";
		}
		function global_form_hidden($name,$value) {
			return "<input type='hidden' name='{$name}' value='{$value}'>";
		}
		function global_form_start($action,$method,$title) {
			return "<form method='{$method}' action='{$action}'><div class='category'><div class='maintitle'>{$title}</div><table>";
		}
		function global_form_text($label,$name,$default=null) {
			return "<tr><td>{$label}:</td><td><input type='text' name='{$name}' value='{$default}'></td></tr>";
		}
		function global_form_textarea($label,$name) {
			return "<tr><td>{$label}</td><td><textarea name='{$name}'></textarea></td></tr>";
		}
		function global_start() {
			global $config;
			return "<div id='wrapper'><div id='logostrip'>{$config->site_name}</div><ul class='topmenu'><li><a href='./index.php'>Home</a></li></ul><div id='main'>";
		}
		function global_userbar($id,$user) {
			return "<div id='userbar'>{$id}{$user->avatar}<div>{$user->name}</div></div>";
		}
		function meta_extra() {
			return "";
		}
		function pagination_item($class, $bit) {
			return "<li class='pagin-item {$class}'>{$bit}</li>";
		}
		function pagination_end() {
			return "</ul></div>";
		}
		function pagination_start() {
			return "<div class='pagination'><ul><li>Pages:</li>";
		}
		function topic_post($post, $pin, $lock, $delete) {
			return "<tr><td class='author'>{$post->avatar}<br />{$post->aname}</td><td class='post'><div class='actions'>{$pin}{$lock}{$delete}</div>{$post->content}</td></tr>";
		}
	}
?>
