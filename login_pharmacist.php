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

// Check if the form is submitted for login
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepare and execute the query to retrieve user information
    $stmt = $conn->prepare("SELECT * FROM sysuser WHERE username = ? AND role = 'pharmacist'");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if ($row && password_verify($password, $row["password"])) {
        // Store user information in session
        $_SESSION["username"] = $row["username"];
        $_SESSION["email"] = $row["email"];
        $_SESSION["role"] = $row["role"];

        // Redirect to homepage after successful login
        header("Location: pharmacist_homepage.php");
        exit();
    } else {
        $login_error = "Invalid username or password";
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pharmacist Login</title>
</head>
<body>
    <h1>Pharmacist Login</h1>
    <h2>Welcome, Pharmacists!</h2>
    <h3>Please log in to continue</h3>

    <!-- Login Form -->
    <h4>Login</h4>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" name="login" value="Log In">
    </form>

    <?php if (isset($login_error)) {
        echo "<p>$login_error</p>";
    } ?>
</body>
</html>
