<?php
    include("server.php");

    $sql = "SELECT * FROM course";
    $query = mysqli_query($connect, $sql);
    $list_course = array();
    foreach ($query->fetch_all(MYSQLI_ASSOC) as $result) {
        $arr = [
            "course_id" => $result['course_id'],
            "course_name" => $result['course_name'],
        ];
        array_push($list_course, $arr);
    }
    return $list_course;
?>