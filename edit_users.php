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

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];

// Retrieve user information from the database
$stmt = $conn->prepare("SELECT * FROM sysuser WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Check if the form is submitted for user information update
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update"])) {
    $newEmail = sanitize_input($_POST["email"]);

    // Update user information in the database
    $stmt = $conn->prepare("UPDATE sysuser SET email = ? WHERE username = ?");
    $stmt->bind_param("ss", $newEmail, $username);
    $stmt->execute();
    $stmt->close();

    // Redirect to display_info.php after successful update
    header("Location: display_info.php");
    exit();
}

// Function to sanitize user inputs
function sanitize_input($input)
{
    global $conn;
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    $input = $conn->real_escape_string($input);
    return $input;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Information</title>
</head>
<body>
    <h1>Welcome, <?php echo $username; ?>!</h1>
    <h2>Edit Information</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?php echo $user["email"]; ?>" required><br><br>
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>