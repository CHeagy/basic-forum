<?php
#error.php
#This file shows error stuff.

include('includes/master.inc.php');
include("style/header.html");
include("style/navbar.html");

if(isset($_GET['e'])) {
	$e = $_GET['e'];
	if (isset($master->messages->$e)) {
		$error = $master->messages->$e;
	} else {
		$error = $master->messages->unknownError;
	}
} else {
	$error = $master->messages->unknownError;
}

include("style/error.html");

include("style/footer.html");
?>