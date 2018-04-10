<?php
require_once('../classes/user.class.php');

if(isset($_POST['username']) && isset($_POST['password'])) {
	$success = User::Register($_POST['username'], $_POST['password'], isset($_POST['admin']));
	
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