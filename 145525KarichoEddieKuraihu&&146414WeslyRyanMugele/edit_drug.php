<?php


// Include Connection.php to establish a database connection
require "connection.php";

// Check if the ID parameter is present in the URL
if (isset($_GET["id"])) {
    $drugID = $_GET["id"];

    // Fetch the current details of the drug from the database
    $query = "SELECT * FROM dispensed_drugs WHERE drugID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $drugID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // Initialize variables with the current details
        $date = $row["date"];
        $drugName = $row["drugName"];
        $quantity = $row["quantity"];
        $price = $row["price"];
    } else {
        // Redirect to an error page if the drug with the specified ID is not found
        header("Location: error.php");
        exit();
    }

    mysqli_stmt_close($stmt);
} else {
    // Redirect to an error page if the ID parameter is not present
    header("Location: error.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the updated form data
    $drugName = $_POST["drugName"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];

    // Update the drug details in the database
    $query = "UPDATE dispensed_drugs SET drugName = ?, quantity = ?, price = ? WHERE drugID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $drugName, $quantity, $price, $drugID);
    mysqli_stmt_execute($stmt);

    // Redirect to the drug list page after the update
    header("Location: drug_list.php");
    exit();
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
    <header>Edit Drug Details</header>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $drugID; ?>" method="POST">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo $date; ?>" disabled>
        <br><br>
        <label for="drugName">Drug Name:</label>
        <input type="text" id="drugName" name="drugName" value="<?php echo $drugName; ?>" required>
        <br><br>
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" value="<?php echo $quantity; ?>" required>
        <br><br>
        <label for="price">Price (In $):</label>
        <input type="text" id="price" name="price" value="<?php echo $price; ?>" required>
        <br><br>
        <input type="submit" value="Save Changes">
    </form>
</body>
</html>
