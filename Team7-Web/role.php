<?php

    include('server.php');
    session_start();

    if($_REQUEST['method'] == "select_permission") {
        $role_id = $_POST['role_id'];
        
        $sql_permission = "SELECT * FROM role WHERE role_id = '$role_id'";
        $result = mysqli_query($connect, $sql_permission);
        $permission = $result->fetch_assoc();
        // echo $permission['permission']; exit;
        if($permission['permission'] != "") {
            echo json_encode($permission['permission']);
        } else {
            echo 'nopermission';
        }
    }

    if($_REQUEST['method'] == "save_permission") {
        $role_id = $_POST['role_id'];
        $permission = array();
        $permission = $_POST['permission'];
        $permission = json_encode($permission);
        
        $sql_permission = "UPDATE role SET permission = '$permission' WHERE role_id = '$role_id'";
        if(mysqli_query($connect, $sql_permission)) {
            echo "success";
        } else {
            echo "fail";
        }
    }

    if($_REQUEST['method'] == "check_permission") {
        $role_name = $_POST['role_name'];
        
        $sql_permission = "SELECT permission FROM role WHERE role_name = '$role_name'";
        $query = $connect->query($sql_permission);
        $role = mysqli_fetch_assoc($query);
        if($role['permission'] != "") {
            $permission = json_decode($role['permission']);
            $list_permission = array();
            foreach($permission as $key => $value) {
                array_push($list_permission, $value);
            }
            echo json_encode($list_permission);
        } else {
            echo 'nopermission';
        }
    }

?>