<?php
require_once('database.class.php');

class User {
	private const LOGIN_TABLE = 'login';
	private const USER_TABLE = 'user_info';
	var $id;
	var $admin;
	var $name;
	
	private function __construct($id, $name, $admin) {
		$this->id = $id;
		$this->name = $name;
		$this->admin = $admin;
	}
	
	/**
		Checks the database for the user cedentials 
		If it matches a user it creates and return a new user object (with its information)
		If unsuccessfull, returns false
		
		Returns: Logged in user or false if unsuccessfull
	**/
	static function Login(string $username, string $password) {
		$table = Self::LOGIN_TABLE;
		$values = array(
				':username' => strtolower($username),
				':password' => md5($password)
			);
		
		$sql = "SELECT user_id, admin FROM $table WHERE username = :username AND password = :password";
		$stmt = Database::query($sql, $values);
		
		if ($stmt->rowCount()) { // Login successful
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			
			// Set user vaiables
			$admin = $row['admin'];
			$id = $row['user_id'];
			$name = $username;
			$user = new User($id, $name, $admin);
			
			// Try to get some more user info, if available
			$table = Self::USER_TABLE;
			$sql = "SELECT name FROM $table WHERE user_id = :id";
			$values = array(
				':id' => strtolower($id)
			);
			$stmt = Database::query($sql, $values);
			// If user info exists
			if ($stmt->rowCount()) {
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$user->name = $row['name'];
			}
			return $user;
		} 
		return false; // Login unsuccessful
	}
	
	static function Register(string $username, string $password, bool $admin) {
		$table = Self::login_table;
		
		$values = array(
				':username' => strtolower($username),
				':password' => md5($password),
				':admin' => $admin
			);		
		$sql = "INSERT INTO $table (username, password, admin) VALUES (:username, :password, :admin)";
		$stmt = Database::query($sql, $values);
		
		return $stmt->rowCount(); // If succcess 1, else 0
	}
}

?>