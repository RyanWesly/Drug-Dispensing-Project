<?php
// Include Connection.php to establish a database connection
require('connection.php');
// Assuming you have already established a database connection

// Retrieve the patient number from the URL parameter
$patientNo = $_GET['PatientNo'];

// Fetch prescription history for the patient from the database
$queryPrescription = "SELECT * FROM prescription WHERE PatientNo = '$patientNo'";
$resultPrescription = mysqli_query($conn, $queryPrescription);
?>

<!DOCTYPE html>
<html>
<head>
<div class="header">
        <a class="header-logo" href="DoctorHome.php">Home</a>
    </div>
    <title>Prescription History</title>
    <link rel="stylesheet" href="searchp.css">
</head>
<body>
    <h1>Prescription History for Patient <?php echo $patientNo; ?></h1>

    <?php if (mysqli_num_rows($resultPrescription) > 0): ?>
        <table>
            <tr>
                <th>Patient Number</th>
                <th>Patient Name</th>
                <th>Sickness</th>
                <th>Date</th>
                <th>Drug</th>
                <th>Frequency</th>
            </tr>
            <?php while ($rowPrescription = mysqli_fetch_assoc($resultPrescription)): ?>
                <tr>
                    <td><?php echo $rowPrescription['PatientNo']; ?></td>
                    <td><?php echo $rowPrescription['patientName']; ?></td>
                    <td><?php echo $rowPrescription['sickness']; ?></td>
                    <td><?php echo $rowPrescription['prescriptionDate']; ?></td>
                    <td><?php echo $rowPrescription['drug']; ?></td>
                    <td><?php echo $rowPrescription['frequency']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No prescription history found for Patient <?php echo $patientNo; ?>.</p>
    <?php endif; ?>

</body>
</html>