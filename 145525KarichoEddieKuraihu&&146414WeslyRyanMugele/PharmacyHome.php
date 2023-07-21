<?php
session_start();

// Check if the user is logged in as a pharmacist
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "pharmacist") {
    header("Location: login.php");
    exit();
}

// Get the pharmacist username from the session
$pharmacistUsername = $_SESSION["username"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pharmacist Homepage</title>
    <link rel="stylesheet" href="phHome.css">
</head>
<body>
    <div class="header">
        <h1 class="header-logo">Pharmacist Homepage</h1>
        <div class="header-buttons">
            <span class="username">Welcome, <?php echo $pharmacistUsername; ?></span>
            <button class="logout-button" onclick="window.location.href='logout.php'">Logout</button>
        </div>
    </div>
    <div class="content">
        <div class="welcome-text">Please select an option:</div>
        <div class="options-container">
            <button class="option-button" onclick="window.location.href='view_prescriptions.php'">View All Prescriptions</button>
            <button class="option-button" onclick="window.location.href='prescP.php'">Specific Patient Prescription</button>
            <button class="option-button" onclick="window.location.href='history.php'">History of Dispensed Drugs</button>
            <button class="option-button" onclick="window.location.href='dispensedrugs.php'">Dispense Drugs</button>
            <button class="option-button" onclick="window.location.href='edit_drug2.php'">Edit Drugs Dispensed</button>
        </div>
    </div>
</body>
</html>