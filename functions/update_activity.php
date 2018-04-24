<?php
session_start();

$time = $_SERVER['REQUEST_TIME'];

// Set timeout to 30 min
$session_timeout_duration = 1800;

// See if time has exceeded the timeout period
if (isset($_SESSION['LAST_ACTIVITY']) && 
   ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    session_start();
}

// Update last activity time
$_SESSION['LAST_ACTIVITY'] = $time;
	
?>