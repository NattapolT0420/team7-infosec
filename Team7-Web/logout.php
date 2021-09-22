<?php

    include('server.php');
    include('manage_token.php');
    session_start();

    $data_token = decode_jwt($_SESSION['token']);
    // print_r($data_token);

    $sql_token = "UPDATE users SET token = NULL WHERE id = '".$data_token['id']."'";
    if(mysqli_query($connect, $sql_token)) {
        session_destroy();
        echo "success";
    } else {
        echo "fail";
    }  

?>