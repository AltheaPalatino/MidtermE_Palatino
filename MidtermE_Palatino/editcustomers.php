<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <a href="viewcustomers.php?store_id=<?php echo ($_GET['store_id']); ?>">View Customers</a>
    <h1>Edit the customer!</h1>

    <?php 
    if (isset($_GET['customer_id'])) {
        $getCustomerByID = getCustomerByID($pdo, $_GET['customer_id']);
        if ($getCustomerByID) {
    ?>
        <form action="core/handleForms.php?customer_id=<?php echo ($_GET['customer_id']); ?>&store_id=<?php echo ($_GET['store_id']); ?>" method="POST">

            <p>
                <label for="customerFirstName">Customer First Name</label> 
                <input type="text" name="customer_firstname" value="<?php echo ($getCustomerByID['customer_firstname']); ?>" required>
            </p>
            <p>
                <label for="customerLastName">Customer Last Name</label> 
                <input type="text" name="customer_lastname" value="<?php echo ($getCustomerByID['customer_lastname']); ?>" required>
            </p>
            <p>
                <label for="email">Email</label> 
                <input type="email" name="email" value="<?php echo ($getCustomerByID['email']); ?>" required>
            </p>
            <p>
                <label for="phoneNumber">Phone Number</label> 
                <input type="text" name="phone_number" value="<?php echo ($getCustomerByID['phone_number']); ?>">  
            </p>
             <input type="submit" name="editCustomerBtn" value="Edit Customer">
        </form>
    <?php 
        } else {
            echo "<p>Customer not found.</p>";
        }
    } else {
        echo "<p>Customer ID not provided.</p>";
    }
    ?>
</body>
</html>
