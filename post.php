<?php
#post.php
#This file posts stuff.

include('includes/master.inc.php');
include('includes/post.class.php');
include("style/header.html");
include("style/navbar.html");

$post = new post;

if(isset($_GET['a'])) {
	if($_GET['a'] == "np") {
		$info = $post->getPostInfo($master, $_GET['t']);
		include("style/new.post.html");
	} else if ($_GET['a'] == "nt") {
		$f = $_GET['f'];
		include("style/new.topic.html");
	} else if ($_GET['a'] == "cp") {
		$pinfo = $post->newPost($master, $_SESSION['username'], $_POST['t'], $_POST['message']);
		$status = $post->verifyNewPost($master, $pinfo);
		if ($status != false) {
			include("style/new.post.success.html");
		} else {
			header("Location: error.php?e=unknownError");
		}
	} else if ($_GET['a'] == "ct") {
		$t = $post->newTopic($master, $_SESSION['username'], $_POST['f'], $_POST['title'], $_POST['message']);
		$pinfo = $post->verifyNewTopic($master, $t);

		if ($pinfo != false) {
			include("style/new.topic.success.html");
		} else {
			header("Location: error.php?e=unknownError");
		}
	} else if ($_GET['a'] == "e") {
		$post->editPost($master, $_GET['p']);
	} else if ($_GET['a'] == "ep") {
		$post->editPost($master, $_POST['p'], $_POST);
	} else {
		header('Location: error.php?e=unknownError');
	}
} else {
	header('Location: view.php');
}

include("style/footer.html");
?>