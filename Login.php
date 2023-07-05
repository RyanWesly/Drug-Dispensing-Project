<?php
session_start();

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

// Check if the form is submitted for role selection
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["select_role"])) {
    $selectedRole = $_POST["role"];

    // Store the selected role in the session
    $_SESSION["selectedRole"] = $selectedRole;

    // Redirect to the login page based on the selected role
    if ($selectedRole === "patient") {
        header("Location: login_patient.php");
        exit();
    } elseif ($selectedRole === "doctor") {
        header("Location: login_doctor.php");
        exit();
    } elseif ($selectedRole === "pharmacist") {
        header("Location: login_pharmacist.php");
        exit();
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kugzy Drug Dispensing System</title>
    <link.rel="stylesheet".href="styles.css">
</head>
<body>
    <h1>Kugzy Drug Dispensing System</h1>
    <h2>Welcome to our Drug Dispensing System</h2>
    <h3>Please select your role below to continue</h3>

    <!-- Role Selection Form -->
    <h4>Select Role</h4>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="patient">Patient</option>
            <option value="doctor">Doctor</option>
            <option value="pharmacist">Pharmacist</option>
        </select><br><br>

        <input type="submit" name="select_role" value="Continue">
    </form>

    <p>If you don't have an account, <a href="signup.php">sign up here</a>.</p>
</body>
</html>

