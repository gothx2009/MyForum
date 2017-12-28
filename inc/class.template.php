<?php
	class Template {
		function css_extra() {
			return "";
		}
		function global_before_end() {
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
		function global_end($copyright, $before_end) {
			return "{$copyright}</div></div></body></html>";
		}
		function global_form_end() {
			return "<tr><td colspan='2'><input type='submit' value='Submit'></td></tr></table></div></form>";
		}
		function global_form_hidden($name,$value) {
			return "<input type='hidden' name='{$name}' value='{$value}'>";
		}
		function global_form_password($label,$name,$default=null,$extra=null) {
			return "<tr><td>{$label}:</td><td><input type='text' name='{$name}' value='{$default}'></td></tr>";
		}
		function global_form_start($action,$method,$title) {
			return "<form method='{$method}' action='{$action}'><div class='category'><div class='maintitle'>{$title}</div><table>";
		}
		function global_form_text($label,$name,$default=null,$extra=null) {
			return "<tr><td>{$label}:</td><td><input type='text' name='{$name}' value='{$default}'></td></tr>";
		}
		function global_form_textarea($label,$name,$extra=null) {
			return "<tr><td>{$label}</td><td><textarea name='{$name}'></textarea></td></tr>";
		}
		function global_start($userbar,$crumbs) {
			global $config;
			return "{$userbar}<div id='wrapper'><div id='logostrip'>{$config->site_name}</div><ul class='topmenu'><li><a href='./index.php'>Home</a></li></ul><div id='main'>{$crumbs}";
		}
		function global_userbar($id,$login,$register,$user) {
			return "<div id='userbar'>{$id}{$login}{$register}{$user->avatar}<div>{$user->name}</div></div>";
		}
		function global_userbar_idlink() {
			return "<a href='./index.php?act=id' class='link'>Identify</a>";
		}
		function global_userbar_loginlink() {
			return "<a href='./index.php?act=login' class='link'>Login</a>";
		}
		function global_userbar_reglink() {
			return "<a href='./index.php?act=reg' class='link'>Register</a>";
		}
		function index_pinned_start() {
			return "<tr><th colspan='2'>Pinned Topics:</th></tr>";
		}
		function index_pinned_end() {
			return "<tr><th colspan='2'>Topics:</th></tr>";
		}
		function index_row_locked($pin, $link, $author) {
			return "<tr class='locked'><td><strong>LOCKED: </strong>{$link}</td><td class='ava'>{$author->avatar}</td></tr>";
		}
		function index_row($pin, $link, $author) {
			return "<tr><td><strong>LOCKED: </strong>{$link}</td><td class='ava'>{$author->avatar}</td></tr>";
		}
		function js_extra() {
			return "";
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
