<?php



$host = "localhost";
$dbname = "g_exam";
$user = "root";
$password = "";

// Create a connection to the database
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Return the database connection object
return $conn;
