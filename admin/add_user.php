<?php
require_once('../classes/database.class.php');

if(isset($_POST['username']) && isset($_POST['password'])) {
	$login_table = 'login';
	$values = array(
			':username' => strtolower($_POST['username']),
			':password' => md5($_POST['password']),
			':admin' => isset($_POST['admin'])
		);		
	$sql = "INSERT INTO $login_table (username, password, admin) VALUES (:username, :password, :admin)";
	$stmt = Database::query($sql, $values);
	
	if($stmt->rowCount()) { //insert success
		echo "Successfully added user {$_POST['username']}";
	}
	else {
		echo "Could not add user {$_POST['username']}";
	}
}
	
?>
<h1>Add user</h1>
<form action="" method="post">
	<label for="username">Username</label>
	<input name="username" type="text">
	<br/>
	<label for="username">Password</label>
	<input name="password" type="password">
	<br/>
	<label for="admin">Admin</label>
	<input name="admin" type="checkbox">
	<br/>
	<input type="submit">
</form>