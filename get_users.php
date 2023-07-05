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

// Retrieve user information from the database
$stmt = $conn->prepare("SELECT * FROM sysuser WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Display Information</title>
</head>
<body>
    <h1>Welcome, <?php echo $username; ?>!</h1>
    <h2>User Information</h2>
    <p>Username: <?php echo $user["username"]; ?></p>
    <p>Email: <?php echo $user["email"]; ?></p>
    <p>Role: <?php echo $user["role"]; ?></p>
</body>
</html>