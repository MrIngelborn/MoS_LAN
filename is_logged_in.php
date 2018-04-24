<?
session_start();

// Time from login until logout
$max_time_since_login = 86400; // 24 h
// Time from last ative until logout
$max_time_since_last_active = 300; // 5 min

function is_logged_in() {
	// Check that a user is instanced
	if (!isset($_SESSION['user'])) return false;
	
	// Check login time
	if (time() - $_SESSION['login_time'] > $max_time_since_login) {
		unset($_SESSION['user']);
		return false;
	}
	
	//Check time since last active
	if (time() - $_SESSION['last_active_time'] > $max_time_since_last_active) {
		unset($_SESSION['user']);
		return false;
	}
	
	// Update login time
	$_SESSION['last_active_time'] = time();
	return true;
}

if (!is_logged_in()) {
	header('Location: /login.php?fw='.urlencode($_SERVER['REQUEST_URI']));
	die();
}
?>