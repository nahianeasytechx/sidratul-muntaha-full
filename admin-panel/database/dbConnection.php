
<?php

    $host = 'localhost';
    $username = 'sidratul';
    $password = 'L5e567zQnJx.A:';
    $database = 'sidratul_muntaha';

//    $servername="localhost";

//    $username="root";
//    $database_name="sidratul_muntaha";
//     $password="";

    $conn=mysqli_connect($servername,$username,$password,$database_name);
    $conn->set_charset("utf8mb4");
    if($conn->connect_error){
        die("Connection failed:" . $conn->connect_error);

    }



    ?>
