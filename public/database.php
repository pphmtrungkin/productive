<?php 
    $servername = "localhost";
    $dBUsername = "root";
    $dBPassword = "";
    $dbName = "loginsystem";
    $conn= "";

    try{
        $conn = mysqli_connect($servername, $dBUsername,$dBPassword, $dbName);
    } catch (mysqli_sql_exception){
        echo("Could not connect!");
    }
?>