<?php

class User {
	var $id;
	var $barcode;
	var $admin;
	
	function __construct($id, $barcode, $admin) {
		$this->id = $id;
		$this->barcode = $barcode;
		$this->admin = $admin;
	}
	
	function login($username, $password) {
		require_once('database.class.php');
		Database::query('SELECT FROM user_passwords WHERE ');
	}
}

?>