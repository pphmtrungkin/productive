<?php 
    $servername = "sql312.infinityfree.com";
    $dBUsername = "if0_34716326";
    $dBPassword = "YOa81G9YVld";
    $dbName = "if0_34716326_users";
    $conn = mysqli_connect($servername, $dBUsername,$dBPassword, $dbName);
    
    if(!$conn){
        echo "Connection Failed".mysqli_connect_error();
    }
?>