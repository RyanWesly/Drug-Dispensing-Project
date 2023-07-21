<?php
// Include Connection.php to establish a database connection
require "connection.php";

// Assuming you have already established a database connection

// Fetch all prescriptions from the database
$query = "SELECT * FROM prescription";
$result = mysqli_query($conn, $query);
$pharmacistUsername = $_SESSION["username"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Prescriptions</title>
    <link rel="stylesheet" href="prescriptions.css">

</head>
<body>
<div class="pharmacy-home-button">
        <a href="PharmacyHome.php">Pharmacy Home</a>
    </div>
    <header>All Prescriptions</header>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="header-buttons">
            <span class="username">Welcome, <?php echo $pharmacistUsername; ?></span>
            <button class="logout-button" onclick="window.location.href='logout.php'">Logout</button>
        </div>
    </div>
        <table>
            <tr>
                <th>Patient Number</th>
                <th>Patient Name</th>
                <th>Sickness</th>
                <th>Date</th>
                <th>Drug</th>
                <th>Frequency</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['PatientNo']; ?></td>
                    <td><?php echo $row['patientName']; ?></td>
                    <td><?php echo $row['sickness']; ?></td>
                    <td><?php echo $row['prescriptionDate']; ?></td>
                    <td><?php echo $row['drug']; ?></td>
                    <td><?php echo $row['frequency']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No prescriptions found.</p>
    <?php endif; ?>
</body>
</html>