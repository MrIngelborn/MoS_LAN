<?php
require_once('../classes/database.class.php');

if(isset($_POST['username']) && isset($_POST['password'])) {
	$login_table = 'login';
	$values = array(
			':username' => strtolower($_POST['username']),
			':password' => md5($_POST['password'])
		);		
	$sql = "INSERT INTO $login_table (username, password) VALUES (:username, :password)";
	$res = $pdo = Database::query($sql, $values);
	
	echo "User added: {$_POST['username']}";
}
	
?>
<h1>Add user</h1>
<form action="" method="post">
	<label for="username">Username</label>
	<input name="username" type="text">
	<br/>
	<label for="username">Password</label>
	<input name="password" type="password">
	<input type="submit">
</form>