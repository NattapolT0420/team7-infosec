<?php

    include('server.php');
    session_start();

    if($_REQUEST['method'] == "add_petition_course") {
        $course_id = $_POST['course_id'];
        
        $course_check_query = "SELECT * FROM petition_course WHERE course_id = '$course_id' AND student_id = '".$_SESSION['userid']."'";
        $query = mysqli_query($connect, $course_check_query);

        $grade_check_query = "SELECT * FROM petition_grade WHERE course_id = '$course_id'";
        $query_grade = mysqli_query($connect, $grade_check_query);

        if(mysqli_num_rows($query) >= 1) {
            echo "again";
        } else if(mysqli_num_rows($query_grade) >= 1) {
            echo "grade";
        } else {
            $sql = "INSERT INTO petition_course (course_id, student_id, status, send_at) VALUES ('$course_id', '".$_SESSION['userid']."','รอการอนุมัติ', SYSDATE())";
            mysqli_query($connect, $sql);
            echo "success";
        }
    }
    
    if($_REQUEST['method'] == "approve_petition_course") {
        $id = $_POST['id'];
        
        $sql = "UPDATE petition_course SET status = 'อนุมัติแล้ว', check_at = SYSDATE() WHERE id = '$id'";
        if(mysqli_query($connect, $sql)) {
            echo "success";
        } else {
            echo "fail";
        }
    }

    if($_REQUEST['method'] == "disapproved_petition_course") {
        $id = $_POST['id'];
        
        $sql = "UPDATE petition_course SET status = 'ไม่อนุมัติ', check_at = SYSDATE() WHERE id = '$id'";
        if(mysqli_query($connect, $sql)) {
            echo "success";
        } else {
            echo "fail";
        }
    }

    if($_REQUEST['method'] == "del_petition_course") {
        $id = $_POST['id'];
        
        $sql = "DELETE FROM petition_course WHERE id = '$id'";
        if(mysqli_query($connect, $sql)) {
            echo "success";
        } else {
            echo "fail";
        }
    }

    if($_REQUEST['method'] == "petition_course_name") {
        $id = $_POST['id'];
        $sql_course = "SELECT course_id, course_name FROM course WHERE id = '$id'";
        $result = mysqli_query($connect, $sql_course);
        $course = $result->fetch_assoc();

        echo json_encode($course);
    }

?>