<?php
# account.class.php
# This is the class file for account.php

class account {


	function create($master, $username, $password, $verifyPassword, $email, $verifyEmail) {
		# Create a new account

		# Clean yourself up!
		$username = htmlentities($username);
		$email = htmlentities($email);
		$verifyEmail = htmlentities($verifyEmail);

		# Verify everything is good to go
		$newResult = $this->verifyNew($master, $username, $password, $verifyPassword, $email, $verifyEmail);
		if ($newResult != "true") {
			$_SESSION['username'] = $username;
			$_SESSION['email'] = $email;
			$_SESSION['verifyEmail'] = $verifyEmail;
			$_SESSION['message'] = $newResult;	
			header('Location: ' . $config['base'] . 'account.php?a=newform');
				return;
		} else {

			# Getting salty
			$salt = $master->config['psalt'];
			$salted = hash("md5", $salt);
			$newSalt = $username . $password . $email;
			$newSalted = hash("md5", $newSalt);
			$bigSalt = hash("sha256", $salted . $newSalted);

			# Create that thing!
			$sql = "INSERT INTO users (username, password, email, rank) VALUES (?, ?, ?, ?)";
			$query = $master->db->prepare($sql);
			$query->execute(array($username, $bigSalt, $email, "2"));

			# Everything good to go?
			$sql = "SELECT * FROM users WHERE username = ?";
			$query = $master->db->prepare($sql);
			$query->execute(array($username));
			$result = $query->fetch(PDO::FETCH_ASSOC);

			if ($result['username'] == $username) {
				return $master->messages->accountCreated;
			} else {
				return $master->messages->accountCreateFailed;
			}
		}


	}

	function verifyNew($master, $username, $password, $verifyPassword, $email, $verifyEmail) {
		# Verify the new account
		### One account per email
		### Passwords must match
		### Emails must match
		### Username must not already be taken

		# Setup initial query
		$sql = "SELECT * FROM users WHERE username = ?";
		$query = $master->db->prepare($sql);
		$query->execute(array($username));
		$result = $query->fetch(PDO::FETCH_ASSOC);

		# Blank password/email?
		if($password == "") {
			return $master->messages->blankPassword;
		}
		if($email == "") {
			return $master->messages->blankEmail;
		}

		# Unique username?
		if ($result['username'] == $username) {
			return $master->messages->usernameTaken;
		}
		# Do the passwords match?
		if($password != $verifyPassword) {
			return $master->messages->mismatchPasswords;
		}
		# Do the emails match?
		if($email != $verifyEmail) {
			return $master->messages->mismatchEmails;
		}
		# Is the email valid?
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    		return $master->messages->invalidEmail;
		}

		# Is the username too long? 30 characters max.
		if (strlen($username) > 30) {
			return $master->messages->longUsername;
		}

		# Setup second query
		$sql = "SELECT * FROM users WHERE email = ?";
		$query = $master->db->prepare($sql);
		$query->execute(array($email));
		$result = $query->fetch(PDO::FETCH_ASSOC);

		# Unique email?
		if($result['email'] == $email) {
			return $master->messages->uniqueEmail;
		}

		return "true";

	}

	function login($master, $username, $password) {
		# Log in to the account

		# Clean yourself up!
		$username = htmlentities($username);

		#Setup initial query
		$sql = "SELECT * FROM users WHERE username = ?";
		$query = $master->db->prepare($sql);
		$query->execute(array($username));
		$result = $query->fetch(PDO::FETCH_ASSOC);

		# Getting salty
		$salt = $master->config['psalt'];
		$salted = hash("md5", $salt);
		$newSalt = $result['username'] . $password . $result['email'];
		$newSalted = hash("md5", $newSalt);
		$bigSalt = hash("sha256", $salted . $newSalted);

		$_SESSION['username'] = $username;

		# Everything good to go?
		if($username != $result['username']) {
			return $master->messages->loginNameBad;
		} else if ($bigSalt == $result['password']) {
			$_SESSION['loggedin'] = true;
			return "true";
		} else {
			return $master->messages->loginPasswordBad;
		}


	}

	function logout($master, $username) {
		# Log out of the account
		if($_SESSION['username'] == "" OR $_SESSION['loggedin'] == "") {
			$_SESSION['username'] = "";
			$_SESSION['loggedin'] = "";
			return "logInToLogOut";
		}

		$_SESSION['username'] = "";
		$_SESSION['loggedin'] = "";

		if($_SESSION['loggedin'] != "") {
			return "logoutFailed";
		} else {
			return "logoutGood";
		}
	}

	function getUserInfo($master, $username) {
		$sql = "SELECT * FROM users WHERE username = ?";
		$q = $master->db->prepare($sql);
		$q->execute(array($username));
		$u = $q->fetch(PDO::FETCH_ASSOC);

		$sql = "SELECT * FROM ranks WHERE id = ?";
		$q = $master->db->prepare($sql);
		$q->execute(array($u['rank']));
		$rank = $q->fetch(PDO::FETCH_ASSOC);

		$u['rank'] = $rank['level'];
		$u['rankName'] = $rank['name'];
		$u['rankColor'] = $rank['color'];

		return $u;
	}

	function getUserInfoById($master, $id) {
		$sql = "SELECT * FROM users WHERE id = ?";
		$q = $master->db->prepare($sql);
		$q->execute(array($id));
		$u = $q->fetch(PDO::FETCH_ASSOC);

		$sql = "SELECT * FROM ranks WHERE id = ?";
		$q = $master->db->prepare($sql);
		$q->execute(array($u['rank']));
		$rank = $q->fetch(PDO::FETCH_ASSOC);

		$u['rank'] = $rank['level'];
		$u['rankName'] = $rank['name'];
		$u['rankColor'] = $rank['color'];

		return $u;
	}

}

?>