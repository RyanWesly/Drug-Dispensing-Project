
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in as a patient
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "patient") {
    header("Location: login.php");
    exit();
}

// Include Connection.php to establish a database connection
require "connection.php";

// Process form submission
if (isset($_POST["register"])) {
    // Retrieve form data
    $FullName = $_POST["FullName"];
    $patientNo = $_POST["PatientNo"];
    $patientSSN = $_POST["PatientSSN"];
    $contacts = $_POST["Contacts"];
    $email = $_POST["Email"];
    $patientDOB = $_POST["PatientDOB"];
    $patientEmergencyContact = $_POST["PatientEmergencyContact"];
    $patientAddress = $_POST["PatientAddress"];
    $patientPreExistingCondition = $_POST["PatientPreExistingCondition"];
    $doctorName = $_POST["DoctorName"];

// Insert patient details into the 'Patients' table
$query = "INSERT INTO `Patients`(`FullName`, `PatientNo`, `PatientSSN`, `Contacts`, `Email`, `DateOfBirth`, `EmergencyContact`, `Address`, `PreExistingConditions`, `DoctorName`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssssssss", $FullName, $patientNo, $patientSSN, $contacts, $email, $patientDOB, $patientEmergencyContact, $patientAddress, $patientPreExistingCondition, $doctorName);



    if ($stmt->execute()) {
        // Redirect to the homepage with the registration success flag in the URL
        header("Location: PatientHome.php?registration_success=true");
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
    <title>Patient Registration</title>
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
    <h2>Patient Registration</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="FullName">Full Name:</label>
        <input type="text" id="FullName" name="FullName" required><br><br>

        <label for="PatientNo">Patient Number:</label>
        <input type="text" id="PatientNo" name="PatientNo" required><br><br>

        <label for="PatientSSN">Patient SSN:</label>
        <input type="text" id="PatientSSN" name="PatientSSN" required><br><br>

        <label for="Contacts">Contacts:</label>
        <input type="text" id="Contacts" name="Contacts" required><br><br>

        <label for="Email">Email:</label>
        <input type="email" id="Email" name="Email" required><br><br>

        <label for="PatientDOB">Patient Date of Birth:</label>
        <input type="date" id="PatientDOB" name="PatientDOB" required><br><br>

        <label for="PatientEmergencyContact">Patient Emergency Contact:</label>
        <input type="text" id="PatientEmergencyContact" name="PatientEmergencyContact" required><br><br>

        <label for="PatientAddress">Patient Address:</label>
        <input type="text" id="PatientAddress" name="PatientAddress" required><br><br>

        <label for="PatientPreExistingCondition">Patient Pre-Existing Condition:</label>
        <input type="text" id="PatientPreExistingCondition" name="PatientPreExistingCondition" required><br><br>

        <label for="DoctorName">Doctor Name:</label>
        <select id="DoctorName" name="DoctorName" required>
            <option value="">Select a Doctor</option>
            <?php
            
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "DrugDispensingTool";
            
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            // Check connection
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            } 

            // Fetch doctor names from the 'doctors' table
            $query = "SELECT DoctorNo, DoctorName FROM Doctors";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['DoctorName'] . '">' . $row['DoctorName'] . '</option>';
                }
            }

            $conn->close();
            ?>
        </select><br><br>

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

