<?php

    include('server.php');
    include('manage_token.php');
    session_start();

    // Library JWT
    // include("JWT/src/JWT.php");
    // use \Firebase\JWT\JWT;

    // $errors = array();
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    $password = base64_encode($password);
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $query = mysqli_query($connect, $sql);
    $result = mysqli_fetch_assoc($query);
    
    if(mysqli_num_rows($query) == 1) {
        if($result['token'] == NULL) {
            if($result['verify'] == 'YES') {
                $sql_role = "SELECT * FROM role WHERE role_id = ".$result['role_id'];
                $query_role = mysqli_query($connect, $sql_role);
                $role = mysqli_fetch_assoc($query_role);
    
                $sql = "INSERT INTO log_users (users_id, userid, name, role_id, login_at) VALUES ('".$result['id']."', '".$result['userid']."', '".$result['name']."', '".$result['role_id']."', SYSDATE())";
    
                $token = encode_jwt($result['id'], $result['userid']);
                $sql_token = "UPDATE users SET token = '$token' WHERE id = '".$result['id']."'";
    
                if(mysqli_query($connect, $sql) && mysqli_query($connect, $sql_token)) {
                    $_SESSION['name'] = $result['name'];
                    $_SESSION['role'] = $role['role_name'];
                    $_SESSION['userid'] = $result['userid'];
                    $_SESSION['token'] = $token;
                    echo "success";
                } else {
                    echo "ไม่สามารถเข้าสู่ระบบได้";
                }
            } else if($result['verify'] == 'NO'){
                echo "กรุณายืนยันอีเมลก่อนเข้าสู่ระบบ";
            }
        } else {
            echo "มีผู้ใช้งานบัญชีนี้อยู่ในขณะนี้";
        }
        
        
    } else {
        echo "อีเมลหรือรหัสผ่านไม่ถูกต้อง";
    }
?>