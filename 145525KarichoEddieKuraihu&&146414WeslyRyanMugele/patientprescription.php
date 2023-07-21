<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
// Include Connection.php to establish a database connection
include 'connection.php';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $patientNo = $_POST['PatientNo'];
    $patientName = $_POST['PatientName'];
    $sickness = $_POST['Sickness'];
    $prescriptionDate = $_POST['PrescriptionDate'];
    $drug = $_POST['Drug'];
    $frequency = $_POST['Frequency'];

    // Insert prescription details into the database
    $query = "INSERT INTO prescription (PatientNo, PatientName, Sickness, PrescriptionDate, Drug, Frequency)
              VALUES ('$patientNo', '$patientName', '$sickness', '$prescriptionDate', '$drug', '$frequency')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Prescription saved successfully
        echo "Prescription saved successfully.";
    } else {
        // Error occurred while saving prescription
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Prescription</title>
    <link rel="stylesheet" href="patientprescription.css">
</head>
<body>
    <div class="header">
        <a class="header-logo" href="DoctorHome2.php">Home</a>
    </div>
    <h1>Patient Prescription</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="PatientNo">Patient No:</label>
        <input type="text" id="PatientNo" name="PatientNo" required><br><br>

        <label for="PatientName">Patient Name:</label>
        <input type="text" id="PatientName" name="PatientName" required><br><br>

        <label for="Sickness">Sickness:</label>
        <input type="text" id="Sickness" name="Sickness" required><br><br>

        <label for="PrescriptionDate">Prescription Date:</label>
        <input type="text" id="PrescriptionDate" name="PrescriptionDate" required><br><br>

        <label for="Drug">Drug:</label>
        <input type="text" id="Drug" name="Drug" required><br><br>

        <label for="Frequency">Frequency:</label>
        <input type="text" id="Frequency" name="Frequency" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
