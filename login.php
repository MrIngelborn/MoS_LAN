<?php
require('classes/user.class.php');

if (isset($_POST['username']) && isset($_POST['password'])) {
	$user = User::Login($_POST['username'], $_POST['password']);
	if ($user) {
		session_start();
		$_SESSION['login_time'] = time();
		$_SESSION['last_active_time'] = time();
		$_SESSION['user'] = $user;
		var_dump($user); echo '<br/>';
		if (isset($_POST['fw'])) {
			//header('Location: '.urldecode($_POST['fw']));
			echo 'FW: '.$_POST['fw'].'<br/>';
			exit();
		}
		//header('Location: localhost');
		echo 'FW not set<br/>';
		exit();
	}
	else echo "Wrong Password";
}
?>
<h2>Login required</h2>
<form action="login.php" method="post">
	<input type="hidden" name="fw" value="<?=$_REQUEST['fw']?>">
	<input name="username" type="text">
	<input name="password" type="password">
	<input type="submit">
</form>