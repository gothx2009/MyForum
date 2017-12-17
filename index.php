<?php
	define("MYFORUM", true);
	include("inc/config.php");
	include("inc/class.display.php");
	$display = new Display;
	$db = new mysqli($sql['hostname'],$sql['username'],$sql['password'],$sql['database']);
	$db->query("CREATE TABLE IF NOT EXISTS t(i INT AUTO_INCREMENT, a INT, b TEXT, KEY(i))");
	$db->query("CREATE TABLE IF NOT EXISTS p(i INT AUTO_INCREMENT, a INT, b TEXT, KEY(i))");
	$act = isset($_GET['act']) ? $_GET['act'] : false;
	switch($act) {
		default:
			include("source/idx.php");
			break;
	}
	$display->output();
?>

<?php
	$v = false;
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
	}else{
		$t=$q("$s t$l-i");
		for(;$i<$n($t);++$i){
			$r=$f($t);
			echo'<a href="./?v='.$r[0].'">'.$h($r[2]).'</a><br/>';
		}
		$o='Title:'.$x.'text"name="e"/><br/>';
	}
	echo'<hr/>Post:<form action="./"method="post">'.$x.'hidden"name="v"value="'."$v\"/>$o<textarea name=\"b\"></textarea>$x";
?>submit"name="w"value="Post"/></form></body></html>
