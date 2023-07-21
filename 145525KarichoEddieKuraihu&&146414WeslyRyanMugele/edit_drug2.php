<?php
session_start();

// Check if the user is logged in as a pharmacist
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "pharmacist") {
    header("Location: login.php");
    exit();
}

// Include Connection.php to establish a database connection
require "Connection.php";

// Initialize variables
$drugID = $drugName = $quantity = $price = "";
$editSuccess = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $drugID = intval($_POST["drugID"]);
    $drugName = $_POST["drugName"];
    $quantity = intval($_POST["quantity"]);
    $price = floatval($_POST["price"]);

    // Perform input validation (add more validation as needed)
    if ($drugID <= 0 || empty($drugName) || $quantity <= 0 || $price <= 0) {
        $error = "Please fill all required fields with valid values.";
    } else {
        // Update drug details in the 'dispensed_drugs' table
        $query = "UPDATE dispensed_drugs SET drugName = ?, quantity = ?, price = ? WHERE drugID = ?";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sddi", $drugName, $quantity, $price, $drugID);
            if (mysqli_stmt_execute($stmt)) {
                $editSuccess = true;
            } else {
                $error = "Failed to update drug details. Please try again.";
            }
            mysqli_stmt_close($stmt);
        } else {
            $error = "Error in the database query. Please try again later.";
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Drug Details</title>
    <link rel="stylesheet" href="edit_drug.css">
</head>
<body>
<div class="pharmacy-home-button">
        <a href="PharmacyHome.php">Pharmacy Home</a>
    </div>
    <header>Edit Drug Details</header>

    <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php elseif ($editSuccess): ?>
        <p class="success">Drug details updated successfully.</p>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="drugID">Drug ID:</label>
        <input type="text" name="drugID" name="drugID" value="<?php echo $drugID; ?>">

        <label for="drugName">Drug Name:</label>
        <input type="text" id="drugName" name="drugName" value="<?php echo $drugName; ?>" required><br><br>

        <label for="quantity">Quantity:</label>
        <input type="text" id="quantity" name="quantity" value="<?php echo $quantity; ?>" required><br><br>

        <label for="price">Price (In $):</label>
        <input type="text" id="price" name="price" value="<?php echo $price; ?>" required><br><br>

        <input type="submit" value="Save Changes">
    </form>
</body>
</html>
