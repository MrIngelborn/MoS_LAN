<?php
	require('is_logged_in.php');
	require_once('classes/database.class.php');
	
	$sql = 'SELECT * FROM `view_print_cards` ORDER BY `barcode` ASC';
	$statement = Database::query($sql);
?>

<!DOCTYPE html>
<html>
	<head>
		<link href="/css/spectre/spectre.min.css" rel="stylesheet">
		<link href="/css/spectre/spectre-icons.min.css" rel="stylesheet">
		<script src="/js/jquery/jquery-3.3.1.min.js" lang="javascript" type="text/javascript"></script>
		<script src="/js/jquery/jquery.textfill.min.js" lang="javascript" type="text/javascript"></script>
		<script>
			$(document).ready(function(){
				console.log("hej");
				$('.textfill').textfill({
					maxFontPixels: 35
				});
			});
		</script>
		<style>
			label.box::before {
				display: inline-block;
				content: " ";
				width: 20px;
				height: 20px;
				border: 1px black solid;
				font-size: 13px;
				vertical-align: middle;
				margin-bottom: 3px;
				border-radius: 3px;
			}
			label.box.checked::before {
				content: "X";
			}
			div.checkincard {
				width: 90mm;
				height: 50mm; 
				border:solid black 1px; 
				text-align: center; 
				display: inline; 
				float: left; 
				page-break-inside: avoid;
			}
			div.checkincard > div {
				width: 100%;
				padding: 5px;
				height: 25%;
			}
		</style>
	</head>
	<body>
		<?php
			$barcodePrefix = "PLAN18_";
			$cardNr = 1;
			$maxcards = 0;
			if (isset($_GET['cards'])) $maxcards = intval($_GET['cards']);
		?>
		<?php while ($row = $statement->fetch(PDO::FETCH_ASSOC)): ?>
		
		<div class="checkincard">
			<div class="textfill" style="padding: 10px;">
				<span><?php echo $row['name'] ?></span>
			</div>
			<div style="height: 50%;">
				<img style="max-height: 100%;" src="http://www.barcode-generator.org/zint/api.php?bc_number=20&bc_data=<?php echo $row['barcode'] ?>" />
			</div>
			<div style="padding: 5px;">
				<label class="box<?php if($row['meal1']) echo " checked"; ?>">Fredag</label>
				<label class="box<?php if($row['meal2']) echo " checked"; ?>">Lördag</label>
				<label class="box<?php if($row['meal3']) echo " checked"; ?>">Söndag</label>
			</div>
		</div>

		<?php $cardNr++; endwhile; ?>
		<?php while ($cardNr <= $maxcards): ?>
		
		<div class="checkincard">
			<div class="textfill" style="width: 100%; height: 25%; padding: 10px;">
				<span> </span>
			</div>
			<div style="width: 100%; height: 50%; padding: 5px;">
				<img style="max-height: 100%;" src="http://www.barcode-generator.org/zint/api.php?bc_number=20&bc_data=<?php echo $barcodePrefix . sprintf('%03d', $cardNr); ?>" />
			</div>
			<div style="width: 100%; height: 25%; padding: 5px;">
				<label class="box">Fredag</label>
				<label class="box">Lördag</label>
				<label class="box">Söndag</label>
			</div>
		</div>

		<?php $cardNr++; endwhile; ?>
	</body>
</html>