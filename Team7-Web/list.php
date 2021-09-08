<?php

    include('server.php');
    session_start();

    if($_REQUEST['method'] == "select_list") {
        $id = $_POST['id'];
        
        $sql = "SELECT userid,name,role_id FROM users WHERE id = '$id'";
        $result = mysqli_query($connect, $sql);
        $list = $result->fetch_assoc();
        echo json_encode($list);
    }

    if($_REQUEST['method'] == "save_list") {
        $id = $_POST['id'];
        $userid = $_POST['userid'];
        $name = $_POST['name'];
        
        $sql_check = "SELECT * FROM users WHERE userid = '$userid' AND name = '$name'";
        $query = mysqli_query($connect, $sql_check);

        if(mysqli_num_rows($query) >= 1) {
            echo "already";
        } else {
            $sql_role = "SELECT * FROM users WHERE id = '$id'";
            $query = mysqli_query($connect, $sql_role);
            $result = mysqli_fetch_assoc($query);
            $sql_list_log = "INSERT INTO log_users (users_id, userid, name, role_id, updated_at) VALUES ('$id', '$userid', '$name', '".$result['role_id']."', SYSDATE())";
            $sql_list = "UPDATE users SET userid = '$userid', name = '$name' WHERE id = '$id'";
            if(mysqli_query($connect, $sql_list) && mysqli_query($connect, $sql_list_log)) {
                echo "success";
            } else {
                echo "fail";
            }
        }
    }

    if($_REQUEST['method'] == "del_list") {
        $id = $_POST['id'];
        
        $sql = "DELETE FROM users where id = $id";
        $sql_log = "DELETE FROM log_users where users_id = $id";
        if(mysqli_query($connect, $sql) && mysqli_query($connect, $sql_log)) {
            echo "success";
        } else {
            echo "fail";
        }
    }

    if($_REQUEST['method'] == "log_list") {
        $id = $_POST['id'];

        $sql = "SELECT * FROM log_users WHERE users_id = $id AND (created_at IS NOT NULL OR updated_at IS NOT NULL)";
        $result = mysqli_query($connect, $sql);
        $datalog = "";

        foreach($result->fetch_all(MYSQLI_ASSOC) as $data) {
            $sql_role = "SELECT role_name FROM role WHERE role_id = ".$data['role_id'];
            $query = mysqli_query($connect, $sql_role);
            $role = mysqli_fetch_assoc($query);

            if($data['created_at'] != NULL) {
                $datalog .= '<p><label for="logdatetime">สร้างเมื่อ '. $data['created_at'] .'</label><br>';
            } else if($data['updated_at'] != NULL) {
                $datalog .= '<p><label for="logdatetime">แก้ไขเมื่อ '. $data['updated_at'] .'</label><br>';
            }
            if($data['role_id'] == "2") {
                $datalog .= '<label for="userid">รหัสประจำตัวผู้สอน :&nbsp</label>';
            } else if($data['role_id'] == "3" || $data['role_id'] == "4") {
                $datalog .= '<label for="userid">รหัสประจำตัวนักเรียน :&nbsp</label>';
            }
            $datalog .= '<label for="ีloguserid">' . $data['userid'] . '</label><br>';
            $datalog .= '<label for="name">ชื่อ - นามสกุล :&nbsp</label>';
            $datalog .= '<label for="logname">' . $data['name'] . '</label><br>';
            $datalog .= '<label for="role">สถานะ :&nbsp</label>';
            $datalog .= '<label for="logrole">' . $role['role_name'] . '</label><br></p><hr>';
        }
        $datalog = substr($datalog, 0, -4); // substring <hr>
        
        echo $datalog;
    }

?>