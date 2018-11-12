<?php
# master.inc.php
# This file is the master includes file - includes all configuration related files.

include('config.php');
include('database.php');
include('messages.class.php');
include('account.class.php');

class master {
	public $db;
	public $messages;
	public $config;

	function addDB($database) {
		$this->db = $database;
	}

	function addMessages($mess) {
		$this->messages = $mess;
	}

	function addConfig($configData) {
		$this->config = $configData;
	}

	function addUser($user) {
		$this->user = $user;
	}
}

$master = new master;
$master->addConfig($config);
$master->addDB(createDBConnection($master->config));
$master->addMessages($messages);


session_start();
$u = new account;
if(isset($_SESSION['username'])) {
	$master->addUser($u->getUserInfo($master, $_SESSION['username']));
} else {
	$_SESSION['username'] = "";
}

?>