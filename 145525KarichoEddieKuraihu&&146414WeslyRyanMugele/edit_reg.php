<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require('connection.php');

// Check if the user is logged in as a patient
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "patient") {
    header("Location: login.php");
    exit();
}

// Include Connection.php to establish a database connection
require "connection.php";

// Check if the PatientSSN is set and not empty
if (isset($_GET['PatientSSN']) && !empty($_GET['PatientSSN'])) {
    $PatientSSN = $_GET['PatientSSN'];

    // Retrieve patient details from the database
    $query = "SELECT * FROM Patients WHERE PatientSSN = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $PatientSSN);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $patientData = $result->fetch_assoc();
    } else {
        echo "Patient not found. Please try again.";
        exit();
    }

    // Process form submission
    if (isset($_POST["update"])) {
        // Retrieve form data
        $contacts = $_POST["Contacts"];
        $email = $_POST["Email"];
        $patientAddress = $_POST["PatientAddress"];

        // Update patient details in the 'Patients' table
        $queryUpdate = "UPDATE Patients SET Contacts=?, Email=?, Address=? WHERE PatientSSN=?";
        $stmtUpdate = $conn->prepare($queryUpdate);
        $stmtUpdate->bind_param("ssss", $contacts, $email, $patientAddress, $PatientSSN);

        if ($stmtUpdate->execute()) {
            // Redirect to the homepage with the update success flag in the URL
            header("Location: PatientHome.php?update_success=true");
            exit();
        } else {
            echo "Error: " . $stmtUpdate->error;
        }

        $stmtUpdate->close();
    }

    $stmt->close();
} else {
    echo "Patient SSN not provided. Please try again.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Registration Details</title>
    <link rel="stylesheet" href="edit_registration.css">
    <script>
        function showUpdateSuccess() {
            alert("Update Successful");
        }
    </script>
</head>
<body>
    <h1>Edit Registration Details</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <!-- Include the Patient SSN as a hidden input field -->
        <input type="hidden" name="PatientSSN" value="<?php echo $PatientSSN; ?>">

        <label for="Contacts">Contacts:</label>
        <input type="text" id="Contacts" name="Contacts" value="<?php echo $patientData['Contacts']; ?>" required><br><br>

        <label for="Email">Email:</label>
        <input type="email" id="Email" name="Email" value="<?php echo $patientData['Email']; ?>" required><br><br>

        <label for="PatientAddress">Patient Address:</label>
        <input type="text" id="PatientAddress" name="PatientAddress" value="<?php echo $patientData['Address']; ?>" required><br><br>

        <input type="submit" name="update" value="Update">
    </form>
    <a href="PatientHome.php">Back to Patient Home</a> <!-- Back button -->
    <a href="PEdit.php">Back to Search</a>
    <script>
        // Check if the URL parameter 'update_success' is set to true
        const urlParams = new URLSearchParams(window.location.search);
        const updateSuccess = urlParams.get('update_success');

        if (updateSuccess) {
            showUpdateSuccess();
        }
    </script>
</body>
</html>
