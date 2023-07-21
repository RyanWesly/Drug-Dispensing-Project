<?php
require_once("connection.php");

$sql = "SELECT * FROM Patients";
$results = $conn ->query($sql);
$row = $results ->fetch_assoc();
print_r($row);