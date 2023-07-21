<?php
session_start();

// Check if the user is logged in as a doctor
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "doctor") {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Homepage</title>
    <button class="logout-button" onclick="window.location.href='logout.php'">Logout</button>
    <link rel="stylesheet" href="DoctorHome.css">

</head>
<body>
<div class="header">
        <a href="index.php" class="header-logo">Kugzy&Co</a>
    </div>
    <h1>Welcome, Doctor!</h1>
    <button onclick="window.location.href='patientNo.php'">Search Patient</button>
    <button onclick="window.location.href='patientprescription.php'">Prescribe Patient</button>
</body>
</html>