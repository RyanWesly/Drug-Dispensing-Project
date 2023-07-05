<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "drug_dispensing";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];

// Check if the form is submitted for user information deletion
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete"])) {
    // Delete user information from the database
    $stmt = $conn->prepare("DELETE FROM sysuser WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->close();

    // Destroy session and redirect to login page after successful deletion
    session_destroy();
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Information</title>
</head>
<body>
    <h1>Welcome, <?php echo $username; ?>!</h1>
    <h2>Delete Information</h2>
    <p>Are you sure you want to delete your information?</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <input type="submit" name="delete" value="Delete">
    </form>
</body>
</html>
