<?php

$conn = new mysqli("localhost", "root", "", "login_admin");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);}