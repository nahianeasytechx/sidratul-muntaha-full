<?php
session_start();

//--------------------------------------------------------------------
// For local development ---------------------------------------------
//--------------------------------------------------------------------

$site_url = "";
$servername = "localhost";
$username = "root";
$password = "";
$database_name = "";

//---------------------------------------------------------------------
// For production -----------------------------------------------------
//---------------------------------------------------------------------

// $site_url = "";
// $servername = "localhost";
// $username = "";
// $password = "";
// $database_name = "";


// Create connection
$conn = mysqli_connect($servername, $username, $password, $database_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

?>