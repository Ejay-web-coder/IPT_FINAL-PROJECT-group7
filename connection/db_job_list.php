<?php
// Database configuration
$host = 'localhost'; // Change if your database is hosted elsewhere
$db = 'job_board';
$user = 'root'; // Change to your database username
$pass = ''; // Change to your database password

// Create a connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}