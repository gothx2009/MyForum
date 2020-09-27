<?php
	define("MYFORUM", true);
	$config = new stdclass;
	include("inc/config.php");
	include("inc/class.display.php");
	include("inc/class.template.php");
	include("inc/class.myforum.php");
  include("inc/pages.php");
  include("inc/class.hooks.php");
	session_start();
	$db = new mysqli($sql['hostname'],$sql['username'],$sql['password'],$sql['database']);
	$display = new Display;
	$myforum = new MyForum;
  $hooks = new Hooks;

  /* Load all plugins */
  if($handle = opendir("./hooks/")) {
    while(false !== ($file = readdir($handle))) {
      if('.' === $file) continue;
      if('..' === $file) continue;
    }
    closedir($handle);
  }

	if(file_exists("themes/". $config->theme .".php")) {
		include("themes/". $config->theme .".php");
		$theme = new Theme;
	} else {
		$theme = new Template;
	}
	$act = isset($_GET['act']) ? $_GET['act'] : "idx";
	if(isset($_GET['showtopic'])) {
		$act = "ST";
		$_GET['id'] = $_GET['showtopic'];
	}
  $choices = $myforum->choices;
	if(!array_key_exists($act,$choices)) {
		$act = "idx";
	}
  $idx = new $choices[$act];
?>
