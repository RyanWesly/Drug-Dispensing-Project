<?php
session_start();

// Check if the user is logged in as a patient
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "patient") {
    header("Location: login_patient.php");
    exit();
}

$username = $_SESSION["username"];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome, <?php echo $username; ?>!</title>
</head>
<body>
    <h1>Welcome, <?php echo $username; ?>!</h1>
    <h2>Patient Homepage</h2>
    <p>We are at your service!!</p>
    <p>What would you like to do?</p>
    <ul>
        <li><a href="get_users.php">Display Information</a></li>
        <li><a href="edit_users.php">Edit Information</a></li>
        <li><a href="delete_user.php">Delete Information</a></li>
    </ul>
</body>
</html>
