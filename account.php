<?php
# account.php
# Anything related to the user accounts (creation, log in/out, modification, etc.)

# Including the account class
include('includes/master.inc.php');
include("style/navbar.html");
$account = new account;

include("style/header.html");	

if(isset($_GET['a'])) {
	if($_GET['a'] == "create") {
		echo $account->create($master, $_POST['username'], $_POST['password'], $_POST['verifyPassword'], $_POST['email'], $_POST['verifyEmail']);
	} else if ($_GET['a'] == "newform") {
		include("style/form.create.html");
		session_destroy();
	} else if ($_GET['a'] == "login") {
		include("style/form.login.html");
	} else if($_GET['a'] == "loggingin") {
		$login = $account->login($master, $_POST['username'], $_POST['password']);
		if($login == "true") {
			include("style/login.good.html");
		} else {
			$_SESSION['message'] = $login;
			header('Location: ' . $config['base'] . 'account.php?a=login');
		}
	} else if($_GET['a'] == "logout") {
		$username = $_SESSION['username'];
		$message = $account->logout($master, $_SESSION['username']);
		include("style/logout.html");
	} else if ($_GET['a'] == "info") {
		print_r($_SESSION);
	} else {
		echo "Nothing happened yet!";
	}	
} else {
	echo "Nothing happened!";
}

include('style/footer.html');
?>