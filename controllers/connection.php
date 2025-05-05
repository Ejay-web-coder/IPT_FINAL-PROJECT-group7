<?php

$conn = new mysqli("localhost", "root", "", "ipt_database");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);}