<?php
	class ShowTopic {
		var $first = true;
		var $id;
		var $offset;
		var $page;
		var $topic;
		function __construct() {
			global $db, $board, $display, $myforum;
			$this->id = isset($_GET['id']) ? intval($_GET['id']) : false;
			if(!$this->id || $this->id == 0) {
				$_SESSION['error'] = array("error", "Improper URL");
				$myforum->redirect("index.php");
			}
			$this->load_topic();
			if($this->topic->locked) {
				$display->show_post_form = false;
			}
			$display->crumbs[] = "Viewing Topic: <a href='./index.php?showtopic=". $this->id ."'>". $this->topic->title ."</a>";
			$display->ptitle = "Reply";
			$this->set_pagination();
			$this->show_pagination();
			$this->start_topic();
			if($result = $db->query("SELECT * FROM p WHERE parent='". $this->id ."' ORDER BY i ASC LIMIT ". $this->offset .", ". $board['posts_per_page'])) {
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
			global $board, $db;
			$this->page = isset($_GET['page']) ? intval($_GET['page']) : 1;
			$result = $db->query("SELECT COUNT(*) AS pc FROM p WHERE parent='". $this->id ."'");
			$row = $result->fetch_object();
			$postCount = $row->pc;
			$this->pages = ceil($postCount/$board['posts_per_page']);
			if($this->page > $this->pages) {
				$this->page = $this->pages;
			}
			$this->offset = (($this->page - 1) * $board['posts_per_page']);
		}
		function show_pagination() {
			global $display;
			$html = "<div class='pagination'><ul><li>Pages: </li>";
			if($this->page > 1) {
				$html .= "<li><a href='./index.php?showtopic=". $this->id ."'><<</a></li><li><a href='./index.php?showtopic=". $this->id ."'><</a></li>";
			} else {
				$html .= "<li><<</li><li><</li>";
			}
			for($i=$this->page-5;$i<=$this->page+5;$i++) {
				if(($i > 0) && ($i <= $this->pages)) {
					if($i == $this->page) {
						$html .= "<li class='active'>". $i ."</li>";
					} else {
						$html .= "<li><a href='./index.php?showtopic=". $this->id. "&page=". $i ."'>". $i ."</a></li>";
					}
				}
			}
			if($this->page < $this->pages) {
				$html .= "<li><a href='./index.php?showtopic=". $this->id ."&page=". ($this->page + 1) ."'>></a></li><li><a href='./index.php?showtopic=". $this->id ."&page=". $this->pages ."'>>></a></li>";
			} else {
				$html .= "<li>></li><li>>></li>";
			}
			$html .= "</ul></div>";
			$display->to_output .= $html;
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
		function start_topic() {
			global $display;
			$html = "<div class='category'><div class='maintitle'>". $this->topic->title ."</div><table>";
			$display->to_output .= $html;
		}
	}
	$idx = new ShowTopic;
?>
