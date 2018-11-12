<?php

class post {

	function getPostInfo($master, $post) {

		$sql = "SELECT * FROM posts WHERE id = ?";
		$query = $master->db->prepare($sql);
		$query->execute(array($post));
		$result = $query->fetch(PDO::FETCH_ASSOC);

		return $result;

	}

	function newPost($master, $username, $post, $message) {

		if(!isset($_SESSION['username']) or $_SESSION['username'] == "") {
			header('Location: error.php?e=permissions');
		}

		$username = $_SESSION['username'];	

		$sql = "SELECT id FROM users WHERE username = ?";
		$query = $master->db->prepare($sql);
		$query->execute(array($username));	
		$author = $query->fetch(PDO::FETCH_ASSOC);

		$message = htmlentities($message);
		$t = time();

		$sql = "INSERT INTO posts (topic_id, poster_id, post_date, text, last_updated) VALUES (?, ?, ?, ?, ?)";
		$q = $master->db->prepare($sql);
		$q->execute(array($post, $author['id'], $t, $message, $t));	

		$sql = "UPDATE posts SET last_updated = ? WHERE id = ?";
		$query = $master->db->prepare($sql);
		$query->execute(array($t, $post));

		return array("topic_id" => $post, "author" => $author, "message" => $message, "time" => $t);
	}

	function verifyNewPost($master, $pinfo) {

		$sql = "SELECT * FROM posts WHERE topic_id = ? AND poster_id = ? AND post_date = ?";
		$q = $master->db->prepare($sql);
		$q->execute(array($pinfo['topic_id'], $pinfo['author']['id'], $pinfo['time']));
		$result = $q->fetch(PDO::FETCH_ASSOC);

		if(isset($result['id'])) {
			return $result['id'];
		} else {
			return false;
		}
	}

	function newTopic($master, $username, $forum, $title, $message) {
		if(!isset($_SESSION['username']) or $_SESSION['username'] == "") {
			header('Location: error.php?e=permissions');
		}

		$username = $_SESSION['username'];

		$sql = "SELECT id FROM users WHERE username = ?";
		$query = $master->db->prepare($sql);
		$query->execute(array($username));	
		$author = $query->fetch(PDO::FETCH_ASSOC);

		$message = htmlentities($message);
		$title = htmlentities($title);
		$t = time();

		$sql = "INSERT INTO posts (forum, poster_id, post_date, title, text, last_updated) VALUES (?, ?, ?, ?, ?, ?)";
		$q = $master->db->prepare($sql);
		$q->execute(array($forum, $author['id'], $t, $title, $message, $t));

		return array("forum" => $forum, "author" => $author, "title" => $title, "message" => $message, "time" => $t);
	}

	function verifyNewTopic($master, $tinfo) {
		$sql = "SELECT * FROM posts WHERE forum = ? AND poster_id = ? AND post_date = ?";
		$q = $master->db->prepare($sql);
		$q->execute(array($tinfo['forum'], $tinfo['author']['id'], $tinfo['time']));
		$result = $q->fetch(PDO::FETCH_ASSOC);

		if(isset($result['id'])) {
			return $result['id'];
		} else {
			return false;
		}
	}

	function editPost($master, $id, $content = null) {
		$post = SELF::getPostInfo($master, $id);

		$u = new account;
		$user = $u->getUserInfoById($master, $post['poster_id']);

		if ($content == null) {
			include('style/edit.post.html');
		} else {
			$t = time();
			$text = htmlentities($content['message']);

			$sql = "UPDATE posts SET text = ?, last_updated = ? WHERE ID = ?";
			$query = $master->db->prepare($sql);
			$query->execute(array($text, $t, $id));

			if ($post['topic_id'] == null) {
				$post['topic_id'] = $post['id'];
			}

			include('style/edit.post.success.html');
		}

	}

}