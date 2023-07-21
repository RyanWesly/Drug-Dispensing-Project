<!DOCTYPE html>
<html>
<head>
    <title>Search Patient</title>
    <link rel="stylesheet" href="patientNo.css">
</head>
<body>
    <div class="header">
        <a class="header-logo" href="DoctorHome2.php">Home</a>
    </div>
    <h1>Search Patient</h1>
    <form action="searchp.php" method="GET">
        <label for="PatientNo">Patient Number:</label>
        <input type="text" id="PatientNo" name="PatientNo" required>
        <input type="submit" value="Search">
    </form>
</body>
</html>
