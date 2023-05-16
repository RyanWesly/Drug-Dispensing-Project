<?php
require_once ("connection.php");
include_once("");
include("connection.php");
require("connection.php");

$first_name = "Mary";
$email = "mary@gmail.com";
$phone = "0723456789";

$sql = "INSERT INTO Patients( first_name , email , phone )
VALUES ('$first_name', '$email', '$phone' )";

if($conn->query($sql) === TRUE){
    echo "New record created successfully";
} else {
    echo "Error: ". $sql . "<br>" . $conn ->error;
}

$conn -> close();

echo($sql);
?>