<?php
// Include Connection.php to establish a database connection
require "Connection.php";

// Assuming you have already established a database connection

// Fetch the history of dispensed drugs from the database
$query = "SELECT * FROM dispensed_drugs";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>History of Dispensed Drugs</title>
    <link rel="stylesheet" href="history.css">
</head>
<body>
<div class="pharmacy-home-button">
        <a href="PharmacyHome.php">Pharmacy Home</a>
    </div>
    <header>History of Dispensed Drugs</header>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <tr>
                <th>Date</th>
                <th>Drug Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['drugName']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No dispensed drugs found.</p>
    <?php endif; ?>
</body>
</html>