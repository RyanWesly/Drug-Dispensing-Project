<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require('connection.php');

// Check if the user is logged in as a patient
$patientNo = $_GET['PatientNo'];

// Fetch prescription history for the patient from the database
$queryPatients = "SELECT * FROM Patients WHERE PatientNo = '$patientNo'";
$resultPatients = mysqli_query($conn, $queryPatients);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Registration Details</title>
    <link rel="stylesheet" href="patientSSN.css">

</head>
<body>
    <h1>Registration Details for Patient <?php echo $patientNo; ?></h1>
    <?php if (mysqli_num_rows($resultPatients) > 0): ?>
    <table>
        <tr>
            <th>Full Name</th>
            <th>Patient Number</th>
            <th>Patient SSN</th>
            <th>Contacts</th>
            <th>Email</th>
            <th>Date of Birth</th>
            <th>Emergency Contact</th>
            <th>Address</th>
            <th>PreExisting Conditions</th>
            <th>Doctor Name</th>
            <th>Doctor Number</th>
        </tr>
        <?php while ($rowPatients = mysqli_fetch_assoc($resultPatients)): ?>
        <tr>
            <td><?php echo $rowPatients["FullName"]; ?></td>
            <td><?php echo $rowPatients["PatientNo"]; ?></td>
            <td><?php echo $rowPatients["PatientSSN"]; ?></td>
            <td><?php echo $rowPatients["Contacts"]; ?></td>
            <td><?php echo $rowPatients["Email"]; ?></td>
            <td><?php echo $rowPatients["DateOfBirth"]; ?></td>
            <td><?php echo $rowPatients["EmergencyContact"]; ?></td>
            <td><?php echo $rowPatients["Address"]; ?></td>
            <td><?php echo $rowPatients["PreExistingConditions"]; ?></td>
            <td><?php echo $rowPatients["DoctorName"]; ?></td>
            <td><?php echo $rowPatients["DoctorNo"]; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <p>No Registration details found for Patient <?php echo $patientNo; ?>.</p>
    <?php endif; ?>
    <a href="PatientHome.php">Back to Patient Home</a>

</body>
</html>