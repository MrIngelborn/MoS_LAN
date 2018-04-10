<?php

if (isset($_POST['table']) && isset($_POST['id'])) {
	$table = $_POST['table'];
	$id = $_POST['id'];
	
	require_once('../classes/database.class.php');
	$pdo = Database::getConnection();
	
	$sql = "DELETE FROM $table WHERE id=:id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$result = $stmt->execute();
	
	echo $result;
}

?>
