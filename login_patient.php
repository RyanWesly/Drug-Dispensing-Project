<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["login"])) {
    // Retrieve the form data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Simplified database connection
    $conn = mysqli_connect("localhost", "root", "", "drug_dispensing");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve user information
    $query = "SELECT * FROM sysuser WHERE username = '$username' AND role = 'patient'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row && password_verify($password, $row["password"])) {
        // Store user information in session
        $_SESSION["username"] = $row["username"];
        $_SESSION["email"] = $row["email"];
        $_SESSION["role"] = $row["role"];

        // Redirect to homepage after successful login
        header("Location: patient_homepage.php");
        exit();
    } else {
        $login_error = "Invalid username or password";
    }

    // Close the connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Login</title>
</head>
<body>
    <h1>Patient Login</h1>
    <h2>Welcome, Patients!</h2>
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
