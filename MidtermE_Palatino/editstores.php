<?php require_once 'core/handleForms.php'; ?>
<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Store</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php 
        $getStoreInfoByID = getStoreInfoByID($pdo, $_GET['store_id']); 
    ?>
    <h1>Edit the store!</h1>
    <form action="core/handleForms.php?store_id=<?php echo $_GET['store_id']; ?>" method="POST">
        <p>
            <label for="storeName">Store Name</label> 
            <input type="text" name="store_name" value="<?php echo $getStoreInfoByID['store_name']; ?>">
        </p>
        <p>
            <label for="locations">Location</label> 
            <input type="text" name="locations" value="<?php echo $getStoreInfoByID['locations']; ?>">
        </p>
        <p>
            <label for="contactName">Contact Name</label> 
            <input type="text" name="contact_name" value="<?php echo $getStoreInfoByID['contact_name']; ?>">
        </p>
        <p>
            <input type="submit" name="editStoreBtn" value="Save Changes">
        </p>
    </form>
</body>
</html>