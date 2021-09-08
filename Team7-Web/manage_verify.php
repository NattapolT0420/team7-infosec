<?php

    include('server.php');
    session_start();

    if($_REQUEST['method'] == "verify_users") {
        $email = $_POST['email'];

        $sql_users = "SELECT * FROM users WHERE email = '$email'";
        $query_data_users = mysqli_query($connect, $sql_users);
        $result = mysqli_fetch_assoc($query_data_users);

        if(mysqli_num_rows($query_data_users) == 1) {
            if($result['verify'] == 'NO') {
                $verify_users = "UPDATE users SET verify = 'YES' WHERE email = '$email'";
                $query_users = mysqli_query($connect, $verify_users);
                $sql_log_users = "INSERT INTO log_users (users_id, userid, name, role_id, login_at) VALUES ('".$result['id']."', '".$result['userid']."', '".$result['name']."', '".$result['role_id']."', SYSDATE())";
                if(mysqli_query($connect, $sql_log_users)) {
                    $sql_role = "SELECT * FROM role WHERE role_id = ".$result['role_id'];
                    $query_role = mysqli_query($connect, $sql_role);
                    $role = mysqli_fetch_assoc($query_role);
                    $_SESSION['name'] = $result['name'];
                    $_SESSION['role'] = $role['role_name'];
                    $_SESSION['userid'] = $result['userid'];
                    echo "success";
                }
            } else if($result['verify'] == 'YES'){
                echo "confirmed";
            }
        } else {
            echo "fail";
        }
    }
?>