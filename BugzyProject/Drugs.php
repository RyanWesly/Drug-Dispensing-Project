<?php
require_once("connection.php");
include_once("");
include("connection.php");
require("connection.php");

$drug_id = "74";
$drug_name = "Panadol";

$sql = "INSERT INTO Drugs( drug_id , drug_name )
VALUES ('$drug_id', '$drug_name')";

if($conn->query($sql) === TRUE){
    echo "New record created successfully";
} else {
    echo "Error: ". $sql . "<br>" . $conn ->error;
}

$conn -> close();

echo($sql);

?>