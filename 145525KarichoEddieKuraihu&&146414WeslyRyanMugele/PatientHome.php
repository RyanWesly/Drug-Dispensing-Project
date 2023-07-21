<?php
session_start();

// Check if the user is logged in as a patient
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "patient") {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Homepage</title>
    <link rel="stylesheet" href="PatientHome.css">

</head>
<body>
<div class="header">
        <a href="index.php" class="header-logo">Kugzy&Co</a>
    
        <div class="header-buttons">
            <div class="username"><?php echo $username; ?></div>
            <button onclick="window.location.href='logout.php'">Log Out</button>
        </div>
    </div>
    <div class="content">
        <div class="service-section">
            <h2>Select a Service:</h2>
            <button onclick="window.location.href='patient_ registration.php'">Registration</button>
            <button onclick="window.location.href='view_reg.php'">View Registration Details</button>
            <button onclick="window.location.href='prescP.php'">Past Prescriptions</button>
            <button onclick="window.location.href='p_edit.php'">Edit Registration Details</button>
        </div>
    </div>
</body>
</html>