<?php
session_start();

// Check if the user is logged in as a patient
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "patient") {
    header("Location: login.php");
    exit();
}

// Get the username of the logged-in user
$username = $_SESSION["username"];

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DrugDispensingTool";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the form data
    $patientName = $_POST["FullName"];
    $patientNo = $_POST["PatientNo"];
    $patientSSN = $_POST["PatientSSN"];
    $contacts = $_POST["Contacts"];
    $email = $_POST["Email"];
    $password = $_POST["Password"];
    $patientDOB = $_POST["DateOfBirth"];
    $patientEmergencyContact = $_POST["EmergencyContact"];
    $patientAddress = $_POST["Address"];
    $patientPreExistingCondition = $_POST["PreExistingConditions"];
    $pdocName = $_POST["DoctorName"];
    $patientDoctorSSN = $_POST["DoctorSSN"];

    // Create a new database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement to insert the data into the database
    $sql = "INSERT INTO  Patients(FullName, PatientNo, PatientSSN, Contacts, Email, Password, DateOfBirth, EmergencyContact, Address, PreExistingConditions, DoctorName, DoctorSSN)
            VALUES ('$patientName', '$patientNo', '$patientSSN','$Contacts','$email,'$password', '$patientDOB', '$patientEmergencyContact', '$patientAddress', '$patientPreExistingCondition','$pdocName', '$patientDoctorSSN')";

    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        // Redirect to the registration success page
        header("Location: patient_registration.php?registration_success=true");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>