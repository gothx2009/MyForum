<?php
	define("MYFORUM", true);
	include("inc/config.php");
	include("inc/class.myforum.php");
	include("inc/class.display.php");
	session_start();
	$myforum = new MyForum;
	$display = new Display;
	$db = new mysqli($sql['hostname'],$sql['username'],$sql['password'],$sql['database']);
	$db->query("CREATE TABLE IF NOT EXISTS t(i INT AUTO_INCREMENT, a INT, b TEXT, KEY(i))");
	$db->query("ALTER TABLE `t` ADD PRIMARY KEY(`i`);");
	$db->query("ALTER TABLE `t` DROP INDEX `i`;");
	$db->query("ALTER TABLE `t` CHANGE `i` `i` INT(100) NOT NULL AUTO_INCREMENT;");
	$db->query("ALTER TABLE `t` CHANGE `a` `pinned` INT(1) NOT NULL DEFAULT '0';");
	$db->query("ALTER TABLE `t` CHANGE `b` `title` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;");
	$db->query("CREATE TABLE IF NOT EXISTS p(i INT AUTO_INCREMENT, a INT, b TEXT, KEY(i))");
	$db->query("ALTER TABLE `p` ADD PRIMARY KEY(`i`)");
	$db->query("ALTER TABLE `p` DROP INDEX `i`;");
	$db->query("ALTER TABLE `p` CHANGE `i` `i` INT(100) NOT NULL AUTO_INCREMENT;");
	$db->query("ALTER TABLE `p` CHANGE `a` `parent` INT(100) NOT NULL DEFAULT '0';");
	$db->query("ALTER TABLE `p` CHANGE `b` `content` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;");
	$db->query("ALTER TABLE `p` ADD `aname` VARCHAR(255) NOT NULL AFTER `parent`;");
	$act = isset($_GET['act']) ? $_GET['act'] : false;
	if(isset($_GET['showtopic'])) {
		$act = "ST";
		$_GET['id'] = $_GET['showtopic'];
	}
	switch($act) {
		case "post":
			include("source/post.php");
			break;
		case "ST":
			include("source/topic.php");
			break;
		default:
			include("source/idx.php");
			break;
	}
	$display->output();
?>

<?php
	$v = false;
	$b = false;
	extract($_REQUEST);
	$v=intval($v);
	$i=0;
	$q='mysql_query';
	$f='mysql_fetch_row';
	$n='mysql_num_rows';
	$x='<input type="';
	$s="SELECT*FROM";
	$h='htmlspecialchars';
	$l=' ORDER BY';
	$o='';
	$u='INSERT INTO';
	$c="b)VALUES('";
	if($b){
		if(!$v)$q("$u t($c$e')");
		$v=max($v,mysql_insert_id());
		$q("$u p(a,$c$v','$b')");
	}
	if($v){
		$t=$q("$s p WHERE a=$v$l i");
		echo'<a href="./">Back</a>';
		for(;$i<$n($t);++$i){
			$r=$f($t);
			echo'<hr/>'.nl2br($h($r[2]));
		}
	}
?></body></html>
