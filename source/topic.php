<?php
	class ShowTopic {
		var $first = true;
		var $id;
		var $offset;
		var $page;
		var $pagination = array();
		var $topic;
		function __construct() {
			global $db, $config, $display, $myforum, $theme;
			$this->id = isset($_GET['id']) ? intval($_GET['id']) : false;
			if(!$this->id) {
				$_SESSION['error'] = array("error", "Improper URL");
				$myforum->redirect("index.php");
			}
			$this->load_topic();
			if($this->topic->locked) {
				$display->show_form = false;
			}
			$display->crumbs[] = "Viewing Topic";
			$display->crumbs[] = "<a href='./index.php?showtopic=". $this->topic->i ."'>". $this->topic->title ."</a>";
			$display->ptitle = "Reply";
			$this->set_pagination();
			$display->to_output .= $theme->pagination_start();
			$display->to_output .= implode(" ", $this->pagination);
			$display->to_output .= $theme->pagination_end();
			$display->to_output .= $theme->global_cat_start($this->topic->title);
			if($result = $db->query("SELECT * FROM p WHERE parent='". $this->id ."' ORDER BY i ASC LIMIT ". $this->offset .", ". $config->post_per_page)) {
				while($row = $result->fetch_object()) {
					$this->show_post($row);
					$this->first = false;
				}
			}
			$this->end_topic();
		}
		function end_topic() {
			global $display;
			$html = "</table></div>";
			$display->to_output .= $html;
		}
		function load_topic() {
			global $db;
			if($result = $db->query("SELECT * FROM t WHERE i='". $this->id ."'")) {
				if($result->num_rows < 1) {
					$_SESSION['error'] = array("error", "Topic #". $this->id ." does not exist.");
					header("Location: ./index.php");
					exit;
				}
				$this->topic = $result->fetch_object();
			}
		}
		function set_pagination() {
			global $config, $db, $theme;
			$this->page = isset($_GET['page']) ? intval($_GET['page']) : 1;
			$result = $db->query("SELECT COUNT(*) AS pc FROM p WHERE parent='". $this->id ."'");
			$row = $result->fetch_object();
			$postCount = $row->pc;
			$this->pages = ceil($postCount/$config->post_per_page);
			if($this->page > $this->pages) {
				$this->page = $this->pages;
			}
			$this->offset = (($this->page - 1) * $config->post_per_page);
			if($this->page === 1) {
				$this->pagination[] = $theme->pagination_item("disabled", "&laquo;");
				$this->pagination[] = $theme->pagination_item("disabled", "&lsaquo;");
			} else {
				$this->pagination[] = $theme->pagination_item("", "<a href='./index.php?showtopic='". $this->id ."'>&laquo;</a>");
				$this->pagination[] = $theme->pagination_item("", "<a href='./index.php?showtopic='".$this->id."&page=".($this->page - 1)."'><</a>");
			}
			for($i=$this->page-5;$i<=$this->page+5;$i++) {
				if(($i > 0) && ($i <= $this->pages)) {
					if($i == $this->page) {
						$this->pagination[] = $theme->pagination_item("active", $i);
					} else {
						$this->pagination[] = $theme->pagination_item("", "<a href='./index.php?showtopic=". $this->id. "&page=". $i ."'>". $i ."</a>");
					}
				}
			}
			if($this->page < $this->pages) {
				$this->pagination[] = $theme->pagination_item("", "<a href='./index.php?showtopic=". $this->id ."&page=". ($this->page + 1) ."'>></a>");
				$this->pagination[] = $theme->pagination_item("", "<a href='./index.php?showtopic=". $this->id ."&page=". $this->pages ."'>>></a>");
			} else {
				$this->pagination[] = $theme->pagination_item("disabled", "&rsaquo;");
				$this->pagination[] = $theme->pagination_item("disabled", "&raquo;");
			}
		}
		function show_post($post) {
			global $display, $myforum;
			$html = "<tr><td class='author'>";
			$html .= $myforum->gravatar($post->aemail,80,"mm","g",true,array());
			$html .= "<br />".$post->aname ."</td><td class='post'><div class='actions'>";
			if($this->first) {
				$pin = "<a href='./index.php?act=pin&c=3&i=". $this->id ."'><i class='fa fa-thumbtack'></i></a> ";
				$lock = "<a href='./index.php?act=pin&c=5&i=". $this->id ."'><i class='fa fa-lock'></i></a> ";
				if($this->topic->pinned) {
					$pin = "<a href='./index.php?act=pin&c=4&i=". $this->id ."'><i class='fa fa-thumbtack'></i></a> ";
				}
				if($this->topic->locked) {
					$lock = "<a href='./index.php?act=pin&c=6&i=". $this->id ."'><i class='fa fa-unlock'></i></a> ";
				}
				$html .= $pin.$lock;
				$html .= "<a href='./index.php?act=pin&c=2&i=". $this->id ."'>";
			} else {
				$html .= "<a href='./index.php?act=pin&c=1&i=". $post->i ."'>";
			}
			$html .= "<i class='fa fa-times-circle'></i></a></div>";
			$html .= $post->content ."</td></tr>";
			$display->to_output .= $html;
		}
	}
	$idx = new ShowTopic;
?>
