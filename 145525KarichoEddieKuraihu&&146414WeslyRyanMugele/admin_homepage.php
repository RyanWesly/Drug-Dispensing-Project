<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "DrugDispensingTool";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the admin is logged in
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

// Delete user
/*if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_user"])) {
    $username = $_POST["username"];

    // Delete the user from the database
    $stmt = $conn->prepare("DELETE FROM loginDetails WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->close();
}

// Update user
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_user"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $role = $_POST["role"];

    // Update the user information in the database
    $stmt = $conn->prepare("UPDATE sysuser SET email = ?, role = ? WHERE username = ?");
    $stmt->bind_param("sss", $email, $role, $username);
    $stmt->execute();
    $stmt->close();
}*/

// Fetch all users
$sql = "SELECT * FROM loginDetails";
$result = $conn->query($sql);

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>ADMIN DASHBOARD</title>
    <link rel="stylesheet" href="admin_homepage.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .logout {
            text-align: right;
            margin-bottom: 20px;
        }

        .edit-form input {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <div class="logout">
        Logged in as: <?php echo $_SESSION["username"]; ?>
        <a href="logout.php">Logout</a>
    </div>

    <h2>All Users</h2>
    <table>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td>
                    <?php if (isset($_SESSION["edit_mode"]) && $_SESSION["edit_mode"] === $row["username"]) { ?>
                        <form class="edit-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <input type="hidden" name="username" value="<?php echo $row["username"]; ?>">
                            <input type="text" name="email" value="<?php echo $row["email"]; ?>">
                            <select name="role">
                                <option value="patient" <?php if ($row["role"] === "patient") echo "selected"; ?>>Patient</option>
                                <option value="doctor" <?php if ($row["role"] === "doctor") echo "selected"; ?>>Doctor</option>
                                <option value="pharmacist" <?php if ($row["role"] === "pharmacist") echo "selected"; ?>>Pharmacist</option>
                                <option value="admin" <?php if ($row["role"] === "admin") echo "selected"; ?>>Admin</option>
                            </select>
                            <button type="submit" name="update_user">Update</button>
                        </form>
                    <?php } else {
                        echo $row["username"];
                    } ?>
                </td>
                <td><?php echo $row["email"]; ?></td>
                <td><?php echo $row["role"]; ?></td>
                <td>
                    <?php if (isset($_SESSION["edit_mode"]) && $_SESSION["edit_mode"] === $row["username"]) { ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <input type="hidden" name="username" value="<?php echo $row["username"]; ?>">
                            <button type="submit" name="delete_user">Delete</button>
                            <button type="button" onclick="disableEditMode()">Cancel</button>
                        </form>
                    <?php } else { ?>
                        <button type="button" onclick="enableEditMode('<?php echo $row['username']; ?>')">Edit</button>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>

    <script>
        function enableEditMode(username) {
            // Store the username in a session variable
            <?php $_SESSION["edit_mode"] = "' + username + '"; ?>

            // Reload the page to enable the edit mode
            location.reload();
        }

        function disableEditMode() {
            // Remove the edit mode session variable
            <?php unset($_SESSION["edit_mode"]); ?>

            // Reload the page to disable the edit mode
            location.reload();
        }
    </script>
</body>
</html>