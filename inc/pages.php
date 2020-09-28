<?php
  class BoardIndex {
    var $offset;
    var $page;
    var $pages;
    var $pagination = array();
    function __construct() {
      global $display, $db, $hooks, $theme, $config, $myforum;
      $display->crumbs[] = "List of discussions";
      $this->set_pagination();
      if($this->pages > 1) {
        $display->to_output .= $theme->pagination_start();
        $display->to_output .= implode(" ", $this->pagination);
        $display->to_output .= $theme->pagination_end();
        $display->crumbs[] = "Page ". $this->page ." of ". $this->pages;
      }
      $display->to_output .= "<div class='category'><div class='maintitle'>Discussions</div><table>";
      if($result = $db->query("SELECT * FROM t ORDER BY pinned DESC, i DESC LIMIT {$this->offset}, {$config->idx_tpp}")) {
        $pinned = 0;
        $started = 0;
        while($row = $result->fetch_object()) {
          if($row->pinned && $pinned == 0) {
            $pinned = 1;
            $display->to_output .= "<tr><th colspan='2'>Pinned Discussions:</th></tr>";
          }
          if(!$row->pinned && $started == 0 && $pinned == 1) {
            $started = 1;
            $display->to_output .= "<tr><th colspan='2'>Discussions:</th></tr>";
          }
          $trstart = "<tr>";
          $prefix = "";
          if($row->locked) {
            $trstart = "<tr class='locked'>";
            $prefix = "<strong>LOCKED: </strong>";
          }
          $display->to_output .= $trstart."<td>".$prefix."<a href='./index.php?showtopic=". $row->i ."'>". $row->title ."</a></td><td class='ava'>";
          $display->to_output .= $myforum->gravatar($row->aemail, 100, 'mm', 'g', true, array()) ."</td></tr>";
        }
      } else {
        die($db->error);
      }
      $display->to_output .= "</table></div>";
      
      $display->output();
    }
    function set_pagination() {
      global $config, $db, $theme;
      $this->page = isset($_GET['page']) ? intval($_GET['page']) : 1;
      $result = $db->query("SELECT COUNT(*) AS tc FROM t");
      $row = $result->fetch_object();
      $topicCount = $row->tc;
      $this->pages = ceil($topicCount/$config->idx_tpp);
      if($this->page > $this->pages) {
        $this->page = $this->pages;
      }
      if($this->page < 1) {
        $this->page = 1;
      }
      $this->offset = (($this->page - 1) * $config->idx_tpp);
      if($this->page === 1) {
        $this->pagination[] = $theme->pagination_item("disabled", "&laquo;");
        $this->pagination[] = $theme->pagination_item("disabled", "&lsaquo;");
      } else {
        $this->pagination[] = $theme->pagination_item("", "<a href='./index.php'>&laquo;</a>");
        $this->pagination[] = $theme->pagination_item("", "<a href='./index.php?page=". ($this->page - 1) ."'>&lsaquo;</a>");
      }
      for($i=$this->page-5;$i<=$this->page+5;$i++) {
        if(($i>0) && ($i <= $this->pages)) {
          if($i == $this->page) {
            $this->pagination[] = $theme->pagination_item("active", $i);
          } else {
            $this->pagination[] = $theme->pagination_item("", "<a href='./index.php?page=". $i ."'>". $i ."</a>");
          }
        }
      }
      if($this->page < $this->pages) {
				$this->pagination[] = $theme->pagination_item("", "<a href='./index.php?page=". ($this->page + 1) ."'>&rsaquo;</a>");
				$this->pagination[] = $theme->pagination_item("", "<a href='./index.php?page=". $this->pages ."'>&raquo;</a>");
			} else {
				$this->pagination[] = $theme->pagination_item("disabled", "&rsaquo;");
				$this->pagination[] = $theme->pagination_item("disabled", "&raquo;");
			}
    }
  }
  class Identify {
		function __construct() {
			global $display,$theme;
			$display->crumbs[] = "Identification";
			$display->show_form = false;
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				$aname = isset($_POST['aname']) ? $_POST['aname'] : false;
				$aemail = isset($_POST['aemail']) ? $_POST['aemail'] : false;
				if($aname) {
					$_SESSION['aname'] = $aname;
				}
				if($aemail) {
					$_SESSION['aemail'] = $aemail;
				}
        header("Location: ./index.php");
        exit;
			}
			$display->to_output .= $theme->global_form_start("index.php?act=id","post","Identification");
			$display->to_output .= $theme->global_form_text("Display Name","aname",(isset($_SESSION['aname']) ? $_SESSION['aname'] : false));
			$display->to_output .= $theme->global_form_text("Email","aemail",(isset($_SESSION['aemail']) ? $_SESSION['aemail'] : false));
			$display->to_output .= $theme->global_form_end();
      $display->output();
		}
  }
	class Pin {
		function __construct() {
			global $display, $config;
			$display->show_form = false;
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				$code = isset($_POST['code']) ? intval($_POST['code']) : false;
				$id = isset($_POST['id']) ? intval($_POST['id']) : false;
				$pin = isset($_POST['adminpin']) ? $_POST['adminpin'] : false;
				if(!$pin) {
					$_SESSION['error'] = array("error", "You must enter a pin.");
					$this->show_pin_form();
				} if($pin !== $config->admin_pin) {
					$_SESSION['error'] = array("error", "Invalid PIN");
					$this->show_pin_form();
				} else {
					switch($code) {
						case 5:
							$this->lock_topic($id);
							break;
						case 4:
							$this->unpin_topic($id);
							break;
						case 3:
							$this->pin_topic($id);
							break;
						case 2:
							$this->delete_topic($id);
							break;
						case 1:
						default:
							$this->delete_post($id);
							break;
					}
				}
			} else {
				$this->show_pin_form();
			}
		}
		function delete_post($id) {
			global $db, $display, $myforum;
			$sql = "DELETE FROM p WHERE i='". $id ."'";
			if($result = $db->query($sql)) {
				$_SESSION['error'] = array("success", "Your post has been deleted.");
        $myforum->redirect("index.php");
			}
		}
		function delete_topic($id) {
			global $db, $display, $myforum;
			$db->query("DELETE FROM p WHERE parent='". $id ."'");
			$db->query("DELETE FROM t WHERE i='". $id ."'");
			$display->crumbs[] = "Topic Deleted.";
			$_SESSION['error'] = array("success", "The topic has been deleted.");
        $myforum->redirect("index.php");
		}
		function lock_topic($id) {
			global $db, $myforum;
			$db->query("UPDATE t SET locked=1 WHERE i='".$id."'");
			$myforum->redirect("index.php?showtopic=".$id);
		}
		function pin_topic($id) {
			global $db, $myforum;
			$db->query("UPDATE t SET pinned=1 WHERE i='".$id."'");
			$myforum->redirect("index.php?showtopic=".$id);
		}
		function show_pin_form() {
			global $display;
			$display->crumbs[] = "Administration PIN";
			$code = isset($_GET['c']) ? intval($_GET['c']) : false;
			$id = isset($_GET['i']) ? intval($_GET['i']) : false;
			$html = "<div class='category pinform'><form action='./index.php?act=pin' method='post'><input type='hidden' name='code' value='". $code ."'><input type='hidden' name='id' value='". $id ."'><div class='maintitle'>Administration PIN</div><table><tr><td>";
			switch($code) {
				case 5:
					$html .= "Enter the PIN to lock topic #". $id;
					break;
				case 4:
					$html .= "Enter the PIN to unpin topic #". $id;
					break;
				case 3:
					$html .= "Enter the PIN to pin topic #". $id;
					break;
				case 2:
					$html .= "Enter the PIN to delete topic #". $id;
					break;
				case 1:
				default:
					$html .= "Enter the PIN to delete post #". $id;
					break;
			}
			$html .= "<br /><br /><input type='text' name='adminpin'></td></tr><tr><td><input type='submit' value='Submit'></td></tr></table></form></div>";
			
			$display->to_output .= $html;
      $display->output();
		}
		function unpin_topic($id) {
			global $db, $myforum;
			$db->query("UPDATE t SET pinned=0 WHERE i='".$id."'");
			$myforum->redirect("index.php?showtopic=".$id);
		}
	}

	class Post {
		function __construct() {
			global $myforum, $db;
			if($_SERVER['REQUEST_METHOD'] !== "POST") {
				$myforum->redirect("index.php");
			}
			$tid = isset($_POST['tid']) ? intval($_POST['tid']) : 0;
			$content = isset($_POST['pcontent']) ? trim($_POST['pcontent']) : false;
			$email = isset($_POST['aemail']) ? trim($_POST['aemail']) : false;
			$title = isset($_POST['ttitle']) ? $db->real_escape_string($_POST['ttitle']) : false;
			$authorname = isset($_POST['aname']) ? $db->real_escape_string(trim($_POST['aname'])) : null;
			$email = $db->real_escape_string($email);
			$content = $db->real_escape_string($content);
			if(!$content || !$email || $content == "" || $email == "") {
				$myforum->redirect("index.php");
			}
			if(!$tid) {
				$db->query("INSERT INTO t (pinned,locked,aemail,title) VALUES(0,0,'{$email}','{$title}');");
				$tid = $db->insert_id;
			}
			$db->query("INSERT INTO p (parent,aname,aemail,content) VALUES ('{$tid}','{$authorname}','{$email}','{$content}');");
			$myforum->redirect("index.php?showtopic=".$tid);
		}
	}
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
			$sql = "SELECT * FROM p WHERE parent='{$this->id}' ORDER BY i ASC LIMIT {$this->offset}, {$config->post_per_page}";
			if($result = $db->query($sql)) {
				while($row = $result->fetch_object()) {
					$pin = "";
					$lock = "";
					$delete = "<a href='./index.php?act=pin&c=1&i=".$row->i."'>Delete Post</a>";
					if($this->first) {
						$pin = "<a href='./index.php?act=pin&c=3&i=". $this->id ."'>Pin</a>";
						$lock = "<a href='./index.php?act=pin&c=5&i=". $this->id ."'>Lock</a>";
						$delete = "<a href='./index.php?act=pin&c=2&i=".$this->id."'>Delete Topic</a>";
					}
					if($this->topic->pinned) {
						$pin = "<a href='./index.php?act=pin&c=4&i=". $this->id ."'>Unpin</a>";
					}
					if($this->topic->locked) {
						$lock = "<a href='./index.php?act=pin&c=6&i=". $this->id ."'>Unlock</a>";
					}
					$row->avatar = $myforum->gravatar($row->aemail,80,"mm","g",true,array());
					$display->to_output .= $theme->topic_post($row, $pin, $lock, $delete);
					$this->first = false;
				}
			}
			$display->to_output .= $theme->global_cat_end();
      
      $display->output();
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
				$this->pagination[] = $theme->pagination_item("", "<a href='./index.php?showtopic=". $this->id ."&page=". ($this->page + 1) ."'>&rsaquo;</a>");
				$this->pagination[] = $theme->pagination_item("", "<a href='./index.php?showtopic=". $this->id ."&page=". $this->pages ."'>&raquo;</a>");
			} else {
				$this->pagination[] = $theme->pagination_item("disabled", "&rsaquo;");
				$this->pagination[] = $theme->pagination_item("disabled", "&raquo;");
			}
		}
	}
