<?php
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the submitted form data
    $PatientName = $_POST["patient_name"];
    $PhoneNumber = $_POST["phone"];
    $PatientSSN = $_POST["patient_ssn"];
    $PatientDOB = $_POST["date"];
    $PatientEmergencyContact = $_POST["emergency_contact"];
    $PatientAddress = $_POST["address"];
    $PatientPreExistingCondition = $_POST["preexisting_condition"];
    $PatientDoctorSSN = $_POST["doctor_ssn"];

    // Prepare the SQL statement
    $sql = "INSERT INTO patients (PatientName, PhoneNumber, PatientSSN, PatientDOB, PatientEmergencyContact, PatientAddress, PatientPreExistingCondition, PatientDoctorSSN) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind the parameters and execute the statement
    $stmt->bind_param("ssssssss", $PatientName, $PhoneNumber, $PatientSSN, $PatientDOB, $PatientEmergencyContact, $PatientAddress, $PatientPreExistingCondition, $PatientDoctorSSN);
    $stmt->execute();

    // Check for errors during the insert operation
    if ($stmt->errno) {
        echo "Error: " . $stmt->error;
    } else {
        // Check if the insert was successful
        if ($stmt->affected_rows > 0) {
            echo "<br>Patient information updated successfully.";
        } else {
            echo "<br>Failed to update patient information.<br>Please try again.<br>If not successful, please contact the support system.";
        }
    }
    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Registration Form</title>
</head>
<body>
    <h1>Patient Registration</h1>
    <h2>Welcome to the Patient Registration Form</h2>
    <h3>Please enter your details below</h3>
  
    <form action="Patients.php" method="POST">
        <label for="patient_name">Patient Name:</label>
        <input type="text" id="patient_name" name="patient_name" required><br><br>

        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" required><br><br>

        <label for="patient_ssn">Patient SSN:</label>
        <input type="text" id="patient_ssn" name="patient_ssn" required><br><br>

        <label for="date">Patient DOB:</label>
        <input type="text" id="date" name="date" required><br><br>

        <label for="emergency_contact">Patient Emergency Contact:</label>
        <input type="text" id="emergency_contact" name="emergency_contact" required><br><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br><br>

        <label for="preexisting_condition">Patient Pre-existing Condition:</label>
        <input type="text" id="preexisting_condition" name="preexisting_condition" required><br><br>

        <label for="doctor_ssn">Patient Doctor SSN:</label>
        <input type="text" id="doctor_ssn" name="doctor_ssn" required><br><br>
    
        <input type="submit" value="Register">
    </form>
</body>
</html>
