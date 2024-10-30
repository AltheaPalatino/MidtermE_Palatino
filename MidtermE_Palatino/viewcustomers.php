<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Store Management</title>
	<link rel="stylesheet" href="styles.css">
</head>
<style>
	table, th, td {
			border:1px solid black;
		}
</style>
<body>
	<a href="index.php">Return to home</a>
	<a href="login.php"> Back to login</a>

	<?php 
	$getStoreInfoByID = getStoreInfoByID($pdo, $_GET['store_id']); 
	if ($getStoreInfoByID !== false) { 
	?>
		<h1>Store Name: <?php echo $getStoreInfoByID['store_name']; ?></h1>
	<?php 
	} 
	?>
	
	<h1>Add New Customer</h1>
	<form action="core/handleForms.php?store_id=<?php echo $_GET['store_id']; ?>" method="POST">
		<p>
			<label for="firstName">First Name</label> 
			<input type="text" name="customer_firstname">
		</p>
		<p>
			<label for="lastName">Last Name</label> 
			<input type="text" name="customer_lastname">
		</p>
		<p>
			<label for="email">Email</label> 
			<input type="email" name="email">
		</p>
		<p>
			<label for="phone">Phone Number</label> 
			<input type="text" name="phone_number">
			<input type="submit" name="insertCustomerBtn">
		</p>
	</form>

	<table style="width:100%; margin-top: 50px;">
	  <tr>
	    <th>Customer ID</th>
	    <th>First Name</th>
	    <th>Last Name</th>
	    <th>Email</th>
	    <th>Phone Number</th>
	    <th>Date Added</th>
	    <th>Action</th>
	  </tr>

	  <?php 
	  $getCustomersByStore = getCustomersByStore($pdo, $_GET['store_id']); 
	  if ($getCustomersByStore !== false) { 
		  foreach ($getCustomersByStore as $row) { 
	  ?>
	  <tr>
	  	<td><?php echo $row['customer_id']; ?></td>	  	
	  	<td><?php echo $row['customer_firstname']; ?></td>	  	
	  	<td><?php echo $row['customer_lastname']; ?></td>	  	
	  	<td><?php echo $row['email']; ?></td>	  	
	  	<td><?php echo $row['phone_number']; ?></td>
	  	<td><?php echo $row['date_added']; ?></td>
	  	<td>
	  		<a href="editcustomers.php?customer_id=<?php echo $row['customer_id']; ?>&store_id=<?php echo $_GET['store_id']; ?>">Edit</a>

	  		<a href="deletecustomers.php?customer_id=<?php echo $row['customer_id']; ?>&store_id=<?php echo $_GET['store_id']; ?>">Delete</a>
	  	</td>	  	
	  </tr>
	  <?php 
	  	  } // End foreach
	  } else {
	  	  echo "<tr><td colspan='7'>No customers found for this store.</td></tr>";
	  } 
	  ?>
	</table>

</body>
</html>
