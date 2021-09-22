<?php

    include('server.php');

    if($_REQUEST['method'] == "check_userid") {
        $userid = $_POST['userid'];

        $check_userid = "SELECT * FROM users WHERE userid = '$userid'";
        $query = mysqli_query($connect, $check_userid);
        // echo mysqli_num_rows($query);
        
        if(mysqli_num_rows($query) >= 1) {
            echo "รหัสประจำตัวนี้มีอยู่ในระบบแล้ว";
        } else {
            echo "success";
        }
    }

    if($_REQUEST['method'] == "check_userid_student") {
        $userid = $_POST['userid'];

        $check_userid = "SELECT * FROM users WHERE userid = '$userid' AND role_id = '3'";
        $query = mysqli_query($connect, $check_userid);
        // echo mysqli_num_rows($query);
        
        if(mysqli_num_rows($query) == 0) {
            echo "ไม่มีรหัสประจำตัวนักเรียนนี้อยู่ในระบบ";
        } else {
            echo "success";
        }
    }

    if($_REQUEST['method'] == "check_email") {
        $email = $_POST['email'];

        $check_email = "SELECT * FROM users WHERE email = '$email'";
        $query = mysqli_query($connect, $check_email);
        // echo mysqli_num_rows($query);
        
        if(mysqli_num_rows($query) >= 1) {
            echo "อีเมลนี้มีอยู่ในระบบแล้ว";
        } else {
            echo "success";
        }
    }

?>