<?php
    include("server.php");

    $sql = "SELECT * FROM users WHERE role_id='2'";
    $query = mysqli_query($connect, $sql);
    $list_teacher = array();
    foreach ($query->fetch_all(MYSQLI_ASSOC) as $result) {
        $arr = [
            "teacher_userid" => $result['userid'],
            "teacher_name" => $result['name'],
        ];
        array_push($list_teacher, $arr);
    }
    return $list_teacher;
?>