<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "gym_management"; 

$conn = new mysqli($hostname, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>