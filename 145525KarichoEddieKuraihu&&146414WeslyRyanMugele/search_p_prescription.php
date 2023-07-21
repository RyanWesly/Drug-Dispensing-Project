<?php
// Include Connection.php to establish a database connection
require('connection.php');
// Assuming you have already established a database connection

// Retrieve the patient number from the URL parameter
$patientNo = $_GET['PatientNo'];

//Fetch Prescription history for patient from database
$queryPrescription = "SELECT * FROM prescription WHERE PatientNo = '$patientNo'";
$resultPrescription = mysqli_query($conn,$queryPrescription);

// Fetch the patient's name from the database
$queryPatient = "SELECT patientName FROM prescription WHERE PatientNo = '$patientNo'";
$resultPatient = mysqli_query($conn, $queryPatient);

// Check if the patient record exists
if (mysqli_num_rows($resultPatient) > 0) {
    $rowPatient = mysqli_fetch_assoc($resultPatient);
    $patientName = $rowPatient['patientName'];
} else {
    $patientName = 'Unknown';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Prescription History - <?php echo $patientName; ?></title>
    <link rel="stylesheet" href="search_p_prescription.css">

</head>
<body>
    <header>Prescription History for Patient <?php echo $patientNo; ?> - <?php echo $patientName; ?></header>

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
    <a href="PatientHome.php">Back to Patient Home</a>
</body>
</html>