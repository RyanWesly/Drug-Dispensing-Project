<!DOCTYPE html>
<html>
<head>
    <title>Search Patient</title>
    <link rel="stylesheet" href="view_reg.css">
</head>
<body>
    <header>Search Patient</header>
    <form action="patientSSN.php" method="GET">
        <label for="PatientNo">Patient Number:</label>
        <input type="text" id="PatientNo" name="PatientNo" required>
        <input type="submit" value="Search">
    </form>
    <a href="PatientHome.php">Back to Patient Home</a>
</body>
</html>