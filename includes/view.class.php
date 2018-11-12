	<?php
# view.class.php
# This is the class file for view.php

class view {

	

	public $forum;

	function displayCategories($master, $forum) {

		$sql = "SELECT * FROM forums WHERE parent = ?";
		$query = $master->db->prepare($sql);
		$query->execute(array($forum));
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		foreach ($result as $view) {
		    include("style/categories.html");
		}

		//echo "<pre>"; var_dump($result); echo 	"</pre>";

	}

	function displayPosts($master, $forum) {
		$u = new account;

		$sql = "SELECT * FROM posts WHERE forum = ? ORDER BY last_updated DESC LIMIT 25";
		$query = $master->db->prepare($sql);
		$query->execute(array($forum));
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		foreach ($result as $view) {
			$sql = "SELECT * FROM users WHERE id = ? ";
			$query = $master->db->prepare($sql);
			$query->execute(array($view['poster_id']));
			$poster = $query->fetch(PDO::FETCH_ASSOC);

			$user = $u->getUserInfo($master, $poster['username']);

		    include("style/posts.html");
		}

	}

	function displayParent($master, $forum) {
		$sql = "SELECT * FROM forums WHERE id = ?";
		$query = $master->db->prepare($sql);
		$query->execute(array($forum));
		$result = $query->fetch(PDO::FETCH_ASSOC);

		$sql = "SELECT * FROM forums WHERE id = ?";
		$query = $master->db->prepare($sql);
		$query->execute(array($result['parent']));
		$view = $query->fetch(PDO::FETCH_ASSOC);

		include("style/catparent.html");
	}

	function displayTopicInfo($master, $topic) {

		$sql = "SELECT * FROM posts WHERE id = ?";
		$query = $master->db->prepare($sql);
		$query->execute(array($topic));
		$post = $query->fetch(PDO::FETCH_ASSOC);

		$sql = "SELECT * FROM forums WHERE id = ?";
		$query = $master->db->prepare($sql);
		$query->execute(array($post['forum']));
		$view = $query->fetch(PDO::FETCH_ASSOC);

		include("style/posthead.html");

	}

	function displayComments($master, $topic) {
		$u = new account;
		$currUser = $u->getUserInfo($master, $_SESSION['username']);

		$sql = "SELECT * FROM posts WHERE id = ?";
		$query = $master->db->prepare($sql);
		$query->execute(array($topic));
		$view = $query->fetch(PDO::FETCH_ASSOC);

		$sql = "SELECT * FROM users WHERE id = ? ";
		$query = $master->db->prepare($sql);
		$query->execute(array($view['poster_id']));
		$author = $query->fetch(PDO::FETCH_ASSOC);
		$user = $u->getUserInfo($master, $author['username']);
		include("style/post.html");

		$sql = "SELECT * FROM posts WHERE topic_id = ? ORDER BY post_date";
		$query = $master->db->prepare($sql);
		$query->execute(array($topic));
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		foreach ($result as $view) {
			$sql = "SELECT * FROM users WHERE id = ? ";
			$query = $master->db->prepare($sql);
			$query->execute(array($view['poster_id']));
			$author = $query->fetch(PDO::FETCH_ASSOC);

			$user = $u->getUserInfo($master, $author['username']);
		    include("style/post.html");
		    
		}
		include ("style/postfoot.html");
	}
}
?>