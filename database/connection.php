<?php
$hostname = "localhost";
$database = "blog";
$port = 4040;
$username = "root";
$password = "fata8712";

$conn = new mysqli($hostname, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
