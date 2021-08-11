<?php

    $connect = new mysqli("127.0.0.1","root","my-secret-pw","mydb");

    if($connect) {
        // echo "Connection Success";
    }else{
        echo "Connection Failed";
        exit();
    }

?>