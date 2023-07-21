<!DOCTYPE html>
<html>
<head>
    <title>Search Patient</title>
    <link rel="stylesheet" href="prescP.css">
</head>
<body>
<div class="pharmacy-home-button">
        <a href="PharmacyHome.php">Pharmacy Home</a>
    </div>
    <header>Search Patient</header>
    <form action="search_p_prescription.php" method="GET">
        <label for="PatientNo">Patient Number:</label>
        <input type="text" id="PatientNo" name="PatientNo" required>
        <input type="submit" value="Search">
    </form>
</body>
</html>
