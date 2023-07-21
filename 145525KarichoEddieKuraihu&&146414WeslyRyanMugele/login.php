<?php
session_start(); // Start the session

require "connection.php";

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    // Sanitize and validate user input (to prevent SQL injection)
    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $role = mysqli_real_escape_string($conn, $role);

    $query = "SELECT * FROM `loginDetails` WHERE username = '$username' AND email = '$email' AND role = '$role'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if ($password == $row["password"]) {
            $_SESSION["username"] = $row["username"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["role"] = $row["role"];

            // Redirect to homepage based on the selected role
            switch ($role) {
                case "patient":
                    header("Location: PatientHome.php");
                    exit();
                case "doctor":
                    header("Location: DoctorHome.php");
                    exit();
                case "pharmacist":
                    header("Location: PharmacyHome.php");
                    exit();
                case "admin":
                    header("Location: admin_homepage.php");
                    exit();
            }
        } else {
            $login_error = "Invalid username, email, or password";
        }
    } else {
        $login_error = "Invalid username, email, or password";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <h1>Kugzy&Co</h1>
    <h2>Welcome to our Drug Dispensing System</h2>
    <h3>Please fill in your details below to be able to use our system</h3>

    <!-- Login Form -->
    <h4>Login</h4>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="patient">Patient</option>
            <option value="doctor">Doctor</option>
            <option value="pharmacist">Pharmacist</option>
            <option value="admin">Admin</option>
        </select><br><br>

        <input type="submit" name="login" value="Log In">
    </form>

    <?php if (isset($login_error)) {
        echo "<p>$login_error</p>";
    } ?>

    <p>If you don't have an account, <a href="signup.php">sign up here</a>.</p>
</body>
</html>