<?php  

// Store and Customer Management Functions

function insertStore($pdo, $store_name, $locations, $contact_name) {

	$sql = "INSERT INTO stores (store_name, locations, contact_name) 
			VALUES(?,?,?)";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$store_name, $locations, $contact_name]);

	if ($executeQuery) {
		return true;
	}
}

function updateStore($pdo, $store_name, $locations, $contact_name, $updated_by, $store_id) {

	$sql = "UPDATE stores
				SET store_name = ?,
					locations = ?,
					contact_name = ?,
					updated_by = ?
				WHERE store_id = ?
			";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$store_name, $locations, $contact_name, $updated_by, $store_id]);
	
	if ($executeQuery) {
		return true;
	}
}

function deleteStore($pdo, $store_id) {
	$sql = "DELETE FROM stores WHERE store_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$store_id]);

	if ($executeQuery) {
		return true;
	}
}

function getAllStore($pdo) {
	$sql = "SELECT * FROM stores";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function getAllCustomersByStoreID($pdo, $store_id) {
    $sql = "SELECT * FROM customers WHERE store_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$store_id]);

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
    return []; 
}

function getStoreInfoByID($pdo, $store_id) {
    $sql = "SELECT * FROM stores WHERE store_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$store_id]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}

function getCustomersByStore($pdo, $store_id) {
    $stmt = $pdo->prepare("SELECT * FROM customers WHERE store_id = :store_id");
    $stmt->bindParam(':store_id', $store_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertCustomer($pdo, $customer_firstname, $customer_lastname, $email, $phone_number, $store_id) {
	$sql = "INSERT INTO customers (customer_firstname, customer_lastname, email, phone_number, store_id) 
			VALUES (?,?,?,?,?)";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$customer_firstname, $customer_lastname, $email, $phone_number, $store_id]);

	if ($executeQuery) {
		return true;
	}
}

function updateCustomer($pdo, $customer_firstname, $customer_lastname, $email, $phone_number, $store_id, $customer_id, $updated_by) {
    $sql = "UPDATE customers
            SET customer_firstname = ?,
                customer_lastname = ?,
                email = ?,
                phone_number = ?,
                store_id = ?,
                updated_by = ?
            WHERE customer_id = ?";
    $stmt = $pdo->prepare($sql);
    if (!$stmt->execute([$customer_firstname, $customer_lastname, $email, $phone_number, $store_id, $updated_by, $customer_id])) {
        $errorInfo = $stmt->errorInfo();
        echo "SQL Error: " . $errorInfo[2]; 
        return false;
    }
    return true;
}


function deleteCustomer($pdo, $customer_id) {
    $sql = "DELETE FROM customers WHERE customer_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$customer_id]);

    if ($executeQuery) {
        return true; 
    }
    return false;
}



function getAllCustomers($pdo) {
	$sql = "SELECT * FROM customers";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function getCustomerByID($pdo, $customer_id) {
	$sql = "SELECT * FROM customers WHERE customer_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$customer_id]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
}

// New User Management Code
require_once 'dbConfig.php';

function insertNewUserfunction($pdo, $username, $password)
 {

	$checkUserSql = "SELECT * FROM user_accounts WHERE username = ?";
	$checkUserSqlStmt = $pdo->prepare($checkUserSql);
	$checkUserSqlStmt->execute([$username]);

	if ($checkUserSqlStmt->rowCount() == 0) {

		$sql = "INSERT INTO user_accounts (username, password) VALUES(?,?,?,?)";
		$stmt = $pdo->prepare($sql);
		$executeQuery = $stmt->execute([$username, $password]);

		if ($executeQuery) {
			$_SESSION['message'] = "User successfully inserted";
			return true;
		}

		else {
			$_SESSION['message'] = "An error occured from the query";
		}
	}
	else {
		$_SESSION['message'] = "User already exists";
	}
}

function loginUser($pdo, $username, $password) {
	$sql = "SELECT * FROM user_accounts WHERE username=?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$username]); 

	if ($stmt->rowCount() == 1) {
		$userInfoRow = $stmt->fetch();
		$userIDFromDB = $userInfoRow['user_id']; 
		$usernameFromDB = $userInfoRow['username']; 
		$passwordFromDB = $userInfoRow['password'];

		if ($password == $passwordFromDB) {
			$_SESSION['user_id'] = $userIDFromDB;
			$_SESSION['username'] = $usernameFromDB;
			$_SESSION['message'] = "Login successful!";
			return true;
		}

		else {
			$_SESSION['message'] = "Password is invalid, but user exists";
		}
	}

	if ($stmt->rowCount() == 0) {
		$_SESSION['message'] = "Username doesn't exist from the database. You may consider registration first";
	}
}

function insertNewUser($pdo, $username, $password) {
    try {
        $stmt = $pdo->prepare("INSERT INTO user_accounts (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        return $stmt->execute();
    } catch (PDOException $e) {
        return false;
    }
}

function getAllUsers($pdo) {
    $sql = "SELECT * FROM user_accounts";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Use associative array for easier access
    }
    return [];  // Return an empty array if there are no users
}

function getUserByID($pdo, $user_id) {
	$sql = "SELECT * FROM user_accounts WHERE user_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$user_id]);
	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function getUserIDByUsername($pdo, $username) {
	$sql = "SELECT  user_id FROM user_accounts WHERE username = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$username]);
	$row = $stmt->fetch();
	return $row ? $row['user_id'] : null;
}

?>
