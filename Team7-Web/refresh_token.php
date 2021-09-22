<?php

    include('server.php');
    include('manage_token.php');
    session_start();

    if($_REQUEST['method'] == "get_datetime") {
        $data_token = decode_jwt($_SESSION['token']);
        // print_r($data_token);
        echo $data_token['date_time'];
    }

    if($_REQUEST['method'] == "refresh_token") {
        $data_token = decode_jwt($_SESSION['token']);
        print_r($data_token);

        $token = encode_jwt($data_token['id'], $data_token['userid']);
        $sql_token = "UPDATE users SET token = '$token' WHERE id = '".$data_token['id']."'";

        if(mysqli_query($connect, $sql_token)) {
            $_SESSION['token'] = $token;
            print_r(decode_jwt($token));
            echo "success";
        } else {
            echo "fail";
        }
    }

?>