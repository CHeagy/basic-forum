<?php
# database.php
# This file connects to the database.

function createDBConnection ($config) {
	$dsn = 'mysql:host=' . $config['dbhost'] .';dbname=' . $config['dbname'];
	$db = new PDO($dsn, $config['dbusername'], $config['dbpassword']);
	return $db;
}
?>