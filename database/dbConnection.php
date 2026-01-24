
<?php

  $servername="localhost";

  $username="root";
  $database_name="sidratul_muntaha";
    $password="";
    // $servername="localhost"; 
    // $username="sidratul";
    // $database_name="sidratul_muntaha";
    // $password="L5e567zQnJx.A:";

    $conn=mysqli_connect($servername,$username,$password,$database_name);
    $conn->set_charset("utf8mb4");
    if($conn->connect_error){
        die("Connection failed:" . $conn->connect_error);

    }


//     function getDatabaseConnection() {
        
//     $host = 'localhost';
//     $username = 'sidratul';
//     $password = 'L5e567zQnJx.A:';
//     $database = 'sidratul_muntaha';
//     // $host = 'localhost';
//     // $username = 'sidratul';
//     // $password = 'L5e567zQnJx.A:';
//     // $database = 'sidratul_muntaha';
    
//     $conn = new mysqli($host, $username, $password, $database);
    
//     if ($conn->connect_error) {
//         error_log("Database connection failed: " . $conn->connect_error);
//         return null;
//     }
    
//     return $conn;
// }
    ?>
