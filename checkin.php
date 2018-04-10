<?php
abstract class AppState {
	const Error = -1; // The barcode specified was not found
	const NoBarcode = 0; // No barcode specified
	const FirstTime = 1; // The participant was checked in for the first time
	const CheckedIn = 2; // The participant checked in, but not for the first time
	const CheckedOut = 3; // The participant checked out
}

$appState = AppState::NoBarcode;
$errorMsg;

if (isset($_POST['barcode'])) {
	// Get databade connection
	require_once('classes/database.class.php');
	$pdo = Database::getConnection();
	// Save variable
	$barcode = $_POST['barcode'];
	$barcode = str_replace('?','_',$barcode);
	
	// Get check-in status from database
	$query = 'SELECT `id`, `name`, `status`, `debt` FROM `view_checkin` WHERE barcode=:barcode';
	$statement = $pdo->prepare($query);
	$statement->bindParam(':barcode', $barcode, PDO::PARAM_STR);
	$statement->execute();
	$row = $statement->fetch(PDO::FETCH_ASSOC);
	//var_dump($row);
	unset($statement); // unset statement so it does not interfere with other fetches from the database
	
	// If the result contains more then one parameteter we have a match in the database
	if (count($row) > 1) {
		// Save variables
		$id = $row['id'];
		$name = $row['name'];
		$status = $row['status'];
		$debt = $row['debt'];
		
		if ($status == null) {
			// Participant has not checked in yet
			// Create a new entry in the database
			$query = "INSERT INTO `checkin` (`participant_id`) VALUES (:id)";
			$statement = $pdo->prepare($query);
			$statement->bindParam(':id', $id, PDO::PARAM_INT);
			$statement->execute();
			
			$appState = AppState::FirstTime;
		}
		else {
			// Participant has checked in before
			// Set the new status to be the opposite of what it was
			$status = intval($status) ? 0 : 1; 
			
			// Set the new status in the database
			$query = 'UPDATE `checkin` SET `status` = :status WHERE `participant_id` = :id';
			$statement = $pdo->prepare($query);
			$statement->bindParam(':id', $id, PDO::PARAM_INT);
			$statement->bindParam(':status', $status, PDO::PARAM_INT);
			$statement->execute();
			
			// Set the app state to match the current check-in status of the participant
			if ($status) $appState = AppState::CheckedIn;
			else $appState = AppState::CheckedOut;
		}
	}
	else {
		// No match in the database with the current barcode
		$appState = AppState::Error;
		$errorMsg = "No such barcode: \"$barcode\"";
	}
}
?>

<!doctype html>
<html>
	<head>
		<title>MoS - Incheckning</title>
	</head>
	<script src="js/jquery/jquery-3.3.1.min.js"></script>
	<script>
		$(document).ready(function(){
			$("#overlay").fadeOut(5000, "swing", function(){});
		});
	</script>
	<style>
		* {
			text-align: center;s
		}
		.center {
			position: absolute;
			left: 50%;
			top: 50%;
			transform: translate(-50%, -50%);
		}
		#overlay .center {
			top: 25%;
		}
		form {
			text-align: center;
		}
		form input[type=text] {
			font-size: 25px;
			text-align: center;
		}
		form input[type=submit] {
			font-size: 1em;
			width: 100%;
		}
		#overlay {
			position: absolute;
			z-index: 100;
			width: 100%;
			height: 100%;
			margin: 0;
			top:0;
			left:0;
			vertical-align: middle;
			font-family: sans-serif;
		}
	</style>
	<body>
		
<?php switch ($appState): ?>
<?php case AppState::Error: ?>
		    <h1 style="color:red">Error!</h1>
		    <h2><?php echo $errorMsg ?></h2>
<?php break; case AppState::FirstTime: ?>
			<div id="overlay" style="background-color: green">
		    	<div class="center">
				    <h1><?php echo $name; ?></h1>
				    <h2>Välkommen till PLAN 2018!</h2>
			    	<h2><?php echo "Aktuell skuld: $debt kr"; ?></h2>
		    	</div>
			</div>
<?php break; case AppState::CheckedOut: ?>
			<div id="overlay" style="background-color: red">
		    	<div class="center">
			    	<h1><?php echo $name; ?></h1>
			    	<h2>Checkade ut!</h2>
			    	<h2><?php echo "Aktuell skuld: $debt kr"; ?></h2>
		    	</div>
			</div>
<?php break; case AppState::CheckedIn: ?>
			<div id="overlay" style="background-color: green">
		    	<div class="center">
			    	<h1><?php echo $name; ?></h1>
			    	<h2>Checkade in!</h2>
			    	<h2><?php echo "Aktuell skuld: $debt kr"; ?></h2>
		    	</div>
			</div>
<?php endswitch; ?>

		<div class="center">
			<form action="" method="post">
				<input type="text" name="barcode" autofocus><br/>
				<input type="submit">
			</form>
		</div>
	</body>
</html>












