<?php

abstract class AppState {
	const Error = -1; // The barcode specified was not found
	const NoBarcode = 0; // No barcode specified
	const AddedProduct = 1; // Added a product to the cart
	const RemovedProduct = 2; // Removed a product from the cart
	const CleardCart = 3; // Removed all products from the cart
	const CheckOut = 4; // Checked out
}

$appState = AppState::NoBarcode;
$errorMsg;

session_start();

//init session variables
if(!isset($_SESSION['cart'])) $_SESSION['cart'] = array();

// Get databade connection
require_once('classes/database.class.php');
$pdo = Database::getConnection();

$products = array();
$participants = array();


// Get products
require_once('product.class.php');
$sql = 'SELECT * FROM `products`';
$statement = Database::query($sql, null);
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
	//var_dump($row);
	$products[$row['barcode']] = new Product($row['id'], $row['barcode'], $row['name'], $row['price']);
}

// Get participants barcodes
$sql = 'SELECT `id`,`barcode` FROM `view_print_cards`';
$statement = Database::query($sql, null);
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
	$participants[$row['barcode']] = $row['id'];
}

if(isset($_POST['code'])) {
	$code = $_POST['code'];
	$code = str_replace('?','_',$code);
	
	// IF code = 0, clear the cart
	if ($code === '0'){
		$appState = AppState::CleardCart;
		
		$_SESSION['cart'] = array();
	}
	
	// See of code is a product
	else if (isset($products[$code])) {
		$appState = AppState::AddedProduct;
		
		if (!isset($_SESSION['cart'][$code])) $_SESSION['cart'][$code] = 1;
		else $_SESSION['cart'][$code] += 1;
	}
	
	// Else see if code is a participant
	else if (isset($participants[$code])) {
		$appState = AppState::CheckOut;
		
		$participant_id = $participants[$code];
		// Create a new purchase
		$sql = "INSERT INTO `purchase` (`participant_id`) VALUES (:id); SELECT LAST_INSERT_ID();";
		$statement = $pdo->prepare($sql);
		$statement->bindParam(':id', $participant_id, PDO::PARAM_STR);
		$statement->execute();
		
		// Get the id for the newly created purchase
		$purchase_id = $pdo->lastInsertId();
		// Insert each product for the purchase
		foreach($_SESSION['cart'] as $procuct_barcode => $amount) {
			$product_id = $products[$procuct_barcode]->id;
			//echo "$product_id : $amount<br/>";
			$sql = 'INSERT INTO `purchase_products`(`purchase_id`, `product_id`, `amount`) VALUES (:purchase_id, :product_id, :amount)';
			$statement = $pdo->prepare($sql);
			$statement->bindParam(':purchase_id', $purchase_id, PDO::PARAM_STR);
			$statement->bindParam(':product_id', $product_id, PDO::PARAM_STR);
			$statement->bindParam(':amount', $amount, PDO::PARAM_STR);
			$statement->execute();
		}
		// Clear cart
		$_SESSION['cart'] = array();
	}
	
	else {
		$appState = AppState::Error;
		$errorMsg = 'No product or participant found with the specified barcode: '.$_POST['code'];
	}
}

?>

<html>
	<head>
		<title>MoS PLAN18 Shop</title>
		<link rel="stylesheet" href="css/spectre/spectre.min.css" />
		<style>
			tr:nth-last-child(2) td {
				border-bottom-color: #d3d7de;
				border-bottom-width: .1rem;
			}
			tr:last-child td {
				font-weight: bold;
			}
		</style>
	</head>
	<body>
		<form action="" method="post">
			<input type="text" name="code" autofocus/>
			<input type="submit" />
			<?php switch($appState): case (AppState::Error):?>
			<span class="text-error">Error: <?php echo $errorMsg ?></span>
			<?php break; case (AppState::AddedProduct):?>
			<span class="text-primary">Added product: <?php echo $products[$_POST['code']]->name; ?></span>
			<?php break; case (AppState::CleardCart):?>
			<span class="text-primary">Cleared cart</span>
			<?php break; case (AppState::CheckOut):?>
			<span class="text-primary">Checked out with participant code: <?php echo $_POST['code']; ?></span>
			<?php endswitch; ?>
		</form>
		<table class="table">
			<tr>
				<th>Name</th>
				<th>Amount</th>
				<th>Price</th>
				<th>Total Amount</th>
			</tr>
			<?php
				$total = 0;
				foreach($_SESSION['cart'] as $procuct_barcode => $amount):
					$total += $amount * $products[$procuct_barcode]->price;
			?>
			<tr>
				<td><?php echo $products[$procuct_barcode]->name; ?></td>
				<td><?php echo $amount; ?></td>
				<td><?php echo $products[$procuct_barcode]->price; ?></td>
				<td><?php echo $products[$procuct_barcode]->price * $amount; ?></td>
			</tr>
			<?php endforeach; ?>
			<?php if ($total > 0): ?>
			<tr class="active">
				<td>SUM</td>
				<td />
				<td />
				<td><?php echo $total ?></td>
			</tr>
			<?php endif; ?>
		</table>
	</body>
</html>