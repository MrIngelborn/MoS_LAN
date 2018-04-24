<?
session_start();

$time = $_SERVER['REQUEST_TIME'];

// Time from login until logout
$login_timeout_duration = 86400; // 24 h

function is_logged_in() {
	// Check that a user is instanced
	if (!isset($_SESSION['user'])) return false;
	
	// Check login time
	if ($time - $_SESSION['LAST_LOGIN'] > $max_time_since_login) {
		unset($_SESSION['user']);
		return false;
	}
	
	/**
	* All tests has been passed
	* User is still logged in
	*/
	return true;
}

if (!is_logged_in()) {
	header('Location: /login.php?fw='.urlencode($_SERVER['REQUEST_URI']));
	die();
}
?>