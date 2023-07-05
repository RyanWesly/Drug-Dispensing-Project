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

// Check if the form is submitted for signup
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["signup"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    // Prepare and execute the query to insert user information
    $stmt = $conn->prepare("INSERT INTO sysuser (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $role);
    $stmt->execute();
    $stmt->close();

    // Redirect to login page after successful signup
    header("Location: login.php");
    exit();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Signup</title>
</head>
<body>
    <h1>User Signup</h1>
    <h2>Welcome to the User Signup Page</h2>
    <h3>Please fill out the form to sign up</h3>

    <!-- Signup Form -->
    <h4>Sign Up</h4>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="signup-username">Username:</label>
        <input type="text" id="signup-username" name="username" required><br><br>

        <label for="signup-email">Email:</label>
        <input type="text" id="signup-email" name="email" required><br><br>

        <label for="signup-password">Password:</label>
        <input type="password" id="signup-password" name="password" required><br><br>

        <label for="signup-role">Role:</label>
        <select id="signup-role" name="role" required>
            <option value="patient">Patient</option>
            <option value="doctor">Doctor</option>
            <option value="pharmacist">Pharmacist</option>
        </select><br><br>

        <input type="submit" name="signup" value="Sign Up">
    </form>
</body>
</html>
