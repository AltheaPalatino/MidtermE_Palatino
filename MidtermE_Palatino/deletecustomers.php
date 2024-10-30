<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Customer</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php $getCustomerByID = getCustomerByID($pdo, $_GET['customer_id']); ?>
    <h1>Are you sure you want to delete this customer?</h1>
    <div class="container" style="border-style: solid; height: 400px;">
        <h2>Customer First Name: <?php echo $getCustomerByID['customer_firstname'] ?></h2>
        <h2>Customer Last Name: <?php echo $getCustomerByID['customer_lastname'] ?></h2>
        <h2>Email: <?php echo $getCustomerByID['email'] ?></h2>
        <h2>Phone Number: <?php echo $getCustomerByID['phone_number'] ?></h2>
        <h2>Date Added: <?php echo $getCustomerByID['date_added'] ?></h2>

        <div class="deleteBtn" style="float: right; margin-right: 10px;">
            <form action="core/handleForms.php?customer_id=<?php echo $_GET['customer_id']; ?>" method="POST">
                <input type="submit" name="deleteCustomerBtn" value="Delete">
            </form>         
        </div>  
    </div>
</body>
</html>