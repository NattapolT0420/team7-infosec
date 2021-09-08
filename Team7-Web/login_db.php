<?php

    include('server.php');
    session_start();

    $errors = array();

    $email = $_POST['email'];
    $password = $_POST['password'];

    $password = base64_encode($password);
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $query = mysqli_query($connect, $sql);
    $result = mysqli_fetch_assoc($query);

    if(mysqli_num_rows($query) == 1) {
        if($result['verify'] == 'YES') {
            $sql_role = "SELECT * FROM role WHERE role_id = ".$result['role_id'];
            $query_role = mysqli_query($connect, $sql_role);
            $role = mysqli_fetch_assoc($query_role);
            $_SESSION['name'] = $result['name'];
            $_SESSION['role'] = $role['role_name'];
            $_SESSION['userid'] = $result['userid'];

            $sql = "INSERT INTO log_users (users_id, userid, name, role_id, login_at) VALUES ('".$result['id']."', '".$result['userid']."', '".$result['name']."', '".$result['role_id']."', SYSDATE())";
            if(mysqli_query($connect, $sql)) {
                echo "success";
            } else {
                echo "ไม่สามารถเข้าสู่ระบบได้";
            }
        } else if($result['verify'] == 'NO'){
            echo "กรุณายืนยันอีเมลก่อนเข้าสู่ระบบ";
        }
        
    } else {
        echo "อีเมลหรือรหัสผ่านไม่ถูกต้อง";
    }
?>