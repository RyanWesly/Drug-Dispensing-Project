<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in as a doctor
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "doctor") {
    header("Location: login.php");
    exit();
}

// Include Connection.php to establish a database connection
require "connection.php";

// Process form submission
if (isset($_POST["register"])) {
    // Retrieve form data
    $DoctorName = $_POST["DoctorName"];
    $DoctorNo = $_POST["DoctorNo"];
    $Email = $_POST["Email"];
    $DoctorSSN = $_POST["DoctorSSN"];
    $Speciality = $_POST["Speciality"];
    $Experience = $_POST["Experience"];
    $PharmacyNo = $_POST["PharmacyNo"];

    // Insert doctor details into the 'Doctors' table
    $query = "INSERT INTO `Doctors`(`DoctorName`, `DoctorNo`, `Email`, `DoctorSSN`, `Speciality`, `Experience`, `PharmacyNo`)
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssss", $DoctorName, $DoctorNo, $Email, $DoctorSSN, $Speciality, $Experience, $PharmacyNo);

    if ($stmt->execute()) {
        // Redirect to the homepage with the registration success flag in the URL
        header("Location: DoctorHome2.php?registration_success=true");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Registration</title>
    <link rel="stylesheet" href="patient_reg.css">
    <script>
        function showRegistrationSuccess() {
            alert("Registration Successful");
        }
    </script>
</head>
<body>
    <div style="text-align: right; padding: 10px;">
        Welcome, <?php echo $username; ?>!
    </div>
    <h2>Doctor Registration</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="DoctorName">Doctor Name:</label>
        <input type="text" id="DoctorName" name="DoctorName" required><br><br>

        <label for="DoctorNo">Doctor Number:</label>
        <input type="text" id="DoctorNo" name="DoctorNo" required><br><br>

        <label for="Email">Email:</label>
        <input type="email" id="Email" name="Email" required><br><br>

        <label for="DoctorSSN">Doctor SSN:</label>
        <input type="text" id="DoctorSSN" name="DoctorSSN" required><br><br>

        <label for="Speciality">Speciality:</label>
        <input type="text" id="Speciality" name="Speciality" required><br><br>

        <label for="Experience">Experience:</label>
        <input type="text" id="Experience" name="Experience" required><br><br>

        <label for="PharmacyNo">Pharmacy No:</label>
        <input type="text" id="PharmacyNo" name="PharmacyNo" required><br><br>

        <input type="submit" name="register" value="Register">
    </form>
    <script>
        // Check if the URL parameter 'registration_success' is set to true
        const urlParams = new URLSearchParams(window.location.search);
        const registrationSuccess = urlParams.get('registration_success');

        if (registrationSuccess) {
            showRegistrationSuccess();
        }
    </script>
</body>
</html>
