<?php

    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "team7";

    $connect = mysqli_connect($hostname, $username, $password, $dbname);

    if(!$connect) {
        die("Connection Failed" . mysqli_connect_error());
    }
?>