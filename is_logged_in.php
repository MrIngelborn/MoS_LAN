<?
session_start();

function is_logged_in() {
	if (!isset($_SESSION['login_time'])) return false;
	if (time() - $_SESSION['login_time'] > 300) {
		unset($_SESSION['login_time']);
		return false;
	}
	// Update login time
	$_SESSION['login_time'] = time();
	return true;
}

if (!is_logged_in()) {
	header('Location: /login.php?fw='.urlencode($_SERVER['REQUEST_URI']));
	die();
}
?>