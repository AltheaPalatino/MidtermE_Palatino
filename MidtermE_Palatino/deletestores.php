<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<h1>Are you sure you want to delete this store?</h1>
	<?php $getStoreInfoByID = getStoreInfoByID($pdo, $_GET['store_id']); ?>
	<div class="container" style="border-style: solid; height: 250px;">
		<h2>Store Name: <?php echo $getStoreInfoByID['store_name']; ?></h2>
		<h2>Location: <?php echo $getStoreInfoByID['locations']; ?></h2>
		<h2>Contact Name: <?php echo $getStoreInfoByID['contact_name']; ?></h2>
		<h2>Date Added: <?php echo $getStoreInfoByID['date_added']; ?></h2>

		<div class="deleteBtn" style="float: right; margin-right: 10px;">
			<form action="core/handleForms.php?store_id=<?php echo $_GET['store_id']; ?>" method="POST">
				<input type="submit" name="deleteStoreBtn" value="Delete">
			</form>			
		</div>	

	</div>
</body>
</html>