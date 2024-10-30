<?php  
session_start(); // Start session management at the top

require_once 'models.php';
require_once 'dbConfig.php';
require_once 'validate.php';

// User registration with validation
if (isset($_POST['registerUserBtn'])) {
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];

    // Initialize an array to hold missing fields
    $missingFields = [];

    if (empty($username)) {
        $missingFields[] = "Username";
    }
    
    if (empty($password)) {
        $missingFields[] = "Password";
    }
    
    // Check if any fields are missing
    if (count($missingFields) > 0) {
        $_SESSION['message'] = "Please make sure the following fields are not empty: " . implode(", ", $missingFields) . ".";
        header("Location: ../register.php");
        exit();
    }

     // Check if the password is valid
    if (validatePassword($password)) {
        // Call the insertNewUser function with the three required arguments
        $insertQuery = insertNewUser($pdo, $username, sha1($password)); // Adjusted to match your data.sql
        if ($insertQuery) {
            header("Location: ../login.php");
            exit();
        } else {
            header("Location: ../register.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Password should be more than 8 characters and contain both uppercase, lowercase, and numbers";
        header("Location: ../register.php");
        exit();
    }
}


// User login with redirection
if (isset($_POST['loginUserBtn'])) {
    $username = sanitizeInput($_POST['username']);
    $password = sha1($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $loginQuery = loginUser($pdo, $username, $password);
        if ($loginQuery) {
            header("Location: ../index.php");
            exit();
        } else {
            header("Location: ../login.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Please make sure the input fields are not empty for the login!";
        header("Location: ../login.php");
        exit();
    }
}

// User logout
if (isset($_GET['logoutAUser'])) {
    unset($_SESSION['username']);
    unset($_SESSION['user_id']);
    session_destroy();
    header("Location: ../login.php");
    exit();
}


// Inserting a new store
if (isset($_POST['insertStoreBtn'])) {
	$query = insertStore($pdo, $_POST['store_name'], $_POST['locations'], 
		$_POST['contact_name']);

	if ($query) {
		header("Location: ../index.php");
	} else {
		echo "Insertion failed";
	}
}

// Edit an existing store
if (isset($_POST['editStoreBtn'])) {
    $query = updateStore($pdo, $_POST['store_name'], $_POST['locations'], $_POST['contact_name'], $_GET['store_id']);
    if ($query) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Edit failed";
    }
}

// Delete a store
if (isset($_POST['deleteStoreBtn'])) {
    $query = deleteStore($pdo, $_GET['store_id']);
    if ($query) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Deletion failed";
    }
}

// Insert a new customer
if (isset($_POST['insertCustomerBtn'])) {
    $query = insertCustomer($pdo, $_POST['customer_firstname'], $_POST['customer_lastname'], $_POST['email'], $_POST['phone_number'], $_GET['store_id']);
    if ($query) {
        header("Location: ../viewcustomers.php?store_id=" . $_GET['store_id']);
        exit();
    } else {
        echo "Insertion failed";
    }
}

// Edit an existing customer
if (isset($_POST['editCustomerBtn'])) {
    $query = updateCustomer($pdo, $_POST['customer_firstname'], $_POST['customer_lastname'], $_POST['email'], $_POST['phone_number'], $_GET['store_id'], $_GET['customer_id']); 
    if ($query) {
        header("Location: ../viewcustomers.php?store_id=" . $_GET['store_id']);
        exit();
    } else {
        echo "Update failed";
    }
}

// Delete a customer
if (isset($_POST['deleteCustomerBtn'])) {
    $query = deleteCustomer($pdo, $_GET['customer_id']);
    if ($query) {
        header("Location: ../viewcustomers.php?store_id=" . $_GET['store_id']);
        exit();
    } else {
        echo "Deletion failed";
    }
}
?>
