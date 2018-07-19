<?php

// Report all PHP errors (see changelog)
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "socialmedia";

// Create connection
$conn_oop = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn_oop->connect_error) {
    die("Connection failed: " . $conn_oop->connect_error);
}
include 'all_function.php';
//echo "Database Connected successfully";