<?php
// Include Connection.php to establish a database connection
require "Connection.php";

// Define variables to store form inputs
$drugID = $date = $drugName = $quantity = $price = "";
$error = "";
$successMessage = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate the drugID
    $drugID = $_POST["drugID"];
    if (!preg_match("/^[a-zA-Z0-9]+$/", $drugID)) {
        $error = "Please enter a valid drugID (alphanumeric characters only).";
    }

    // Validate the date
    $date = $_POST["date"];
    
    // Validate the drug name
    $drugName = $_POST["drugName"];

    // Validate the quantity
    $quantity = $_POST["quantity"];
    if (!is_numeric($quantity) || $quantity <= 0) {
        $error = "Please enter a valid quantity.";
    }

    // Validate the price
    $price = $_POST["price"];
    if (!is_numeric($price) || $price <= 0) {
        $error = "Please enter a valid price.";
    }

    // If there are no errors, update the dispensed_drugs table
    if (empty($error)) {
        // Prepare and execute the SQL query
        $query = "INSERT INTO dispensed_drugs (drugID, date, drugName, quantity, price) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssss", $drugID, $date, $drugName, $quantity, $price);
        mysqli_stmt_execute($stmt);

        // Check if the query was successful
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            // Dispensing successful
            $successMessage = "Drugs dispensed successfully.";
            // Clear the form inputs
            $drugID = $date = $drugName = $quantity = $price = "";
        } else {
            $error = "Failed to dispense drugs. Please try again.";
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dispense Drugs</title>
    <link rel="stylesheet" href="dispensedrugs.css">
</head>
<body>
<div class="pharmacy-home-button">
        <a href="PharmacyHome.php">Pharmacy Home</a>
    </div>
    <header>Dispense Drugs</header>

    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (isset($successMessage)): ?>
        <p class="success"><?php echo $successMessage; ?></p>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="drugID">Drug ID:</label>
        <input type="text" id="drugID" name="drugID" required>
        <br><br>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>
        <br><br>
        <label for="drugName">Drug Name:</label>
        <input type="text" id="drugName" name="drugName" required>
        <br><br>
        <label for="quantity">Quantity:</label>
        <input type="text" id="quantity" name="quantity" required>
        <br><br>
        <label for="price">Price (In $):</label>
        <input type="text" id="price" name="price" required>
        <br><br>
        <input type="submit" value="Add">
    </form>
</body>
</html>
