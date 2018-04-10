<?php

if (isset($_POST['table'])) {
	$table = htmlspecialchars($_POST['table']);
	
	require_once('../database.class.php');
	$pdo = Database::getConnection();
	
	$sql = "SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_NAME = '$table'";
	$stmt = Database::query($sql, null);
	
	$table_headers = array();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$table_headers[] = $row['COLUMN_NAME'];
	}
	if (sizeof($table_headers) == 0) return; // No columns in the specified table
	
	$insert = array();
	foreach ($table_headers as $key => $value) {
		if (array_key_exists($value, $_POST)){
			$insert[$value] = htmlspecialchars($_POST[$value]);
		}
	}
	$columns = '(`'.join(array_keys($insert), '`,`').'`)';
	$values = '("'.join($insert, '","').'")';
	
	$sql = "INSERT INTO $table$columns VALUES $values";
	$stmt = $pdo->prepare($sql);
	$result = $stmt->execute();
	echo $result;
}

?>