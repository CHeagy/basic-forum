<?php
#view.php
#This file displays categories and individual posts.

include('includes/master.inc.php');
include('includes/view.class.php');
include("style/header.html");
include("style/navbar.html");



$view = new view;

if(isset($_GET['f'])) {
	$view->displayParent($master, $_GET['f']);
	$view->displayCategories($master, $_GET['f']);
	include("style/catfoot.html");
	
	if($_GET['f'] != 1) {
		include("style/posthead.html");
		$view->displayPosts($master, $_GET['f']);
		include("style/postfoot.html");
	}


} else if(isset($_GET['t'])) {
	$view->displayTopicInfo($master, $_GET['t']);
	$view->displayComments($master, $_GET['t']);
} else {
	$view->displayParent($master, 1);
	$view->displayCategories($master, 1);
	include("style/catfoot.html");
}

include("style/footer.html");
?>