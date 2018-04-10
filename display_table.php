<?php
	require('is_logged_in.php');
	if (isset($_GET['table'])):
		require_once('classes/database.class.php');
		$pdo = Database::getConnection();
		
		$table = htmlspecialchars($_GET['table']);
		$columns = isset($_GET['columns']) ? htmlspecialchars($_GET['columns']) : '*';
		
		$sql = "SELECT $columns FROM $table";
		$stmt = Database::query($sql, array());
		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if (gettype($row) == 'boolean'){
			$sql = "SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_NAME = '$table'";
			$stmt = Database::query($sql, null);
			
			$table_headers = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$table_headers[] = $row['COLUMN_NAME'];
			}
		}
		else {
			$table_headers = array_keys($row);
		}
?>

<!doctype html>
<html>
	<head>
		<title>MoS PLAN18 Table</title>
		<link rel="stylesheet" href="css/spectre/spectre.min.css" />
		<link rel="stylesheet" href="css/spectre/spectre-icons.min.css" />
		<script src="js/jquery/jquery-3.3.1.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('.delete-btn').click(function(){
					console.log('hej');
					var id = $(this).attr('id');
					$.post( "functions/delete.php", { id: id, table: '<?php echo $table ?>' })
						.done(function( data ) {
							//alert( data );
						});
					$(this).parent().parent().remove();
				});
				$('form').submit(function(event){
					$.post( "functions/insert.php", $(this).serialize())
						.done(function( data ) {
							//alert( data );
						});
					
					location.reload();
					event.preventDefault();
				});
			});
		</script>
	</head>
	<body>
		<table class="table">
			<tr>
			<?php foreach ($table_headers as $th): ?>
				<th><?php echo $th ?></th>
			<?php endforeach; ?>
			<?php if (isset($_GET['delete']) && isset($row['id'])): ?>
				<th>Delete</th>
			<?php endif; ?>
			</tr>
			<?php while ($row): ?>
			<tr>
			<?php foreach ($table_headers as $th): ?>
				<td><?php echo $row[$th] ?></td>
			<?php endforeach; ?>
			<?php if (isset($_GET['delete']) && isset($row['id'])): ?>
				<td>
					<button id="<?php echo $row['id'] ?>" class="btn btn-error btn-action btn-lg delete-btn">
						<i class="icon icon-cross"></i>
					</button>
				</td>
			<?php endif; ?>
			</tr>
			<?php $row = $stmt->fetch(PDO::FETCH_ASSOC); endwhile; ?>
			<?php if (isset($_GET['insert'])) : ?>
			<form action="functions/insert.php" method="post">
				<tr>
					<input type="hidden" name="table" value="<?php echo $table ?>" />
				<?php foreach ($table_headers as $th): ?>
					<td><input style="width:100%" type="text" placeholder="<?=$th?>" name="<?=$th?>" <? if ($th=='id') echo 'disabled' ?> /></td>
				<?php endforeach; ?>
					<td><input type="submit" value="Add" /></td>
				</tr>
			</form>
			<?php endif; ?>
		</table>
	</body>
</html>
<?php endif; ?>