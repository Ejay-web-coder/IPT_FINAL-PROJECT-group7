<?php 

include "connection.php";

// Set the response content type to JSON
header('Content-Type: application/json');

// Read raw POST data from the request body and decode it from JSON to an associative array
$data = json_decode(file_get_contents("php://input"), true);

$email = $data["uname"];
$password = $data["pword"];

//SQL query : SELECT
$sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    //user found
    echo "valid";
} else {
    echo "invalid";
}




