<?php
if (isset($_POST['username']) && isset($_POST['password'])&& isset($_POST['fw'])) {
	if ($_POST['username'] == 'admin' && $_POST['password'] == 'plan18') {
		session_start();
		$_SESSION['login_time'] = time();
		header('Location: '.urldecode($_POST['fw']));
		die();
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