<?php 
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['customer_id'])) {
    $customer_id = $_POST['customer_id'];

    // Attempt to delete the customer
    if (deleteCustomer($pdo, $customer_id)) {
        echo json_encode(['status' => 'success']);
        exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete customer.']);
        exit();
    }
}

$getCustomerByID = getCustomerByID($pdo, $_GET['customer_id']); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Customer</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Are you sure you want to delete this customer?</h1>
    <div class="container" style="border-style: solid; height: 400px;">
        <h2>Customer First Name: <?php echo htmlspecialchars($getCustomerByID['customer_firstname']); ?></h2>
        <h2>Customer Last Name: <?php echo htmlspecialchars($getCustomerByID['customer_lastname']); ?></h2>
        <h2>Email: <?php echo htmlspecialchars($getCustomerByID['email']); ?></h2>
        <h2>Phone Number: <?php echo htmlspecialchars($getCustomerByID['phone_number']); ?></h2>
        <h2>Date Added: <?php echo htmlspecialchars($getCustomerByID['date_added']); ?></h2>
        
        <form id="deleteCustomerForm" method="post">
            <input type="hidden" name="customer_id" value="<?php echo htmlspecialchars($getCustomerByID['customer_id']); ?>">
            <button type="submit">Delete Customer</button>
        </form>
        <div id="responseMessage"></div>
    </div>

    <script>
        $(document).ready(function() {
            $('#deleteCustomerForm').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                $.ajax({
                    type: 'POST',
                    url: 'deletecustomers.php',
                    data: $(this).serialize(), // Serialize form data
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            // Redirect or refresh the customer list after deletion
                            window.location.href = 'viewcustomers.php?store_id=<?php echo $_GET['store_id']; ?>'; 
                        } else {
                            $('#responseMessage').text(response.message);
                        }
                    },
                    error: function() {
                        $('#responseMessage').text('An error occurred while deleting the customer.');
                    }
                });
            });
        });
    </script>
</body>
</html>
