<?php 
	require('is_logged_in.php');
$msg = "";


if (isset($_POST['amount']) && isset($_POST['barcode'])) {
	$amount = htmlspecialchars($_POST['amount']);
	$barcode = htmlspecialchars($_POST['barcode']);
	
	require_once('database.class.php');
	$pdo = Database::getConnection();
	$sql = 'UPDATE `view_debt` SET `payed`=`payed`+:amount WHERE `barcode`=:barcode;';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':barcode', $barcode, PDO::PARAM_STR);
	$stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	
	$sql = 'SELECT `name`,`debt` FROM `view_debt` WHERE `barcode`=:barcode';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':barcode', $barcode, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	
	$msg = "{$result['name']} payed $amount kr. Current debt: {$result['debt']}";
}	

?>
<html>
	<head>
		<title>MoS PLAN18 Pay Debts</title>
		<link rel="stylesheet" href="css/spectre/spectre.min.css" />
	</head>
	<body>
		<form action="" method="post" >
			<div class="form-group">
				<label class="form-label" for="amount">Amount</label>
				<input class="form-input" type="text" name="amount" placeholder="Amount" autofocus>
			</div>
			<div class="form-group">
				<label class="form-label" for="barcode">Barcode</label>
				<input class="form-input" name="barcode" type="text" placeholder="PLAN18_???">
			</div>
			<input type="submit" />
		</form>
		<div>
			<?php echo $msg ?>
		</div>
	</body>
</html>