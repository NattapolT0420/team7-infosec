<?php

    include('server.php');

    if($_REQUEST['method'] == "insert_grade") {
        $course_id = $_POST['course_id'];
        $grade_student = array();
        $grade_student = $_POST['grade_student'];
        $grade_student = json_encode($grade_student);

        $sql_check_petition = "SELECT * FROM petition_grade WHERE course_id = '$course_id'";
        $query_check_petition = mysqli_query($connect, $sql_check_petition);
        
        if(mysqli_num_rows($query_check_petition) >= 1) {
            $sql_update_petition_grade = "UPDATE petition_grade SET status = 'รอการอนุมัติ', send_at = SYSDATE(), check_at = NULL WHERE course_id = '$course_id'";
            $query_update_petition_grade = mysqli_query($connect, $sql_update_petition_grade);
            $sql_update_grade = "UPDATE grade SET score = '$grade_student' WHERE course_id = '$course_id'";
            $query_update_grade = mysqli_query($connect, $sql_update_grade);

            if($query_update_petition_grade && $query_update_grade) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $sql_petition_grade = "INSERT INTO petition_grade (course_id, status, send_at) VALUES ('$course_id', 'รอการอนุมัติ', SYSDATE())";
            $query_petition_grade = mysqli_query($connect, $sql_petition_grade);
            $sql_grade = "INSERT INTO grade (course_id, score) VALUES ('$course_id', '$grade_student')";
            $query_grade = mysqli_query($connect, $sql_grade);
            
            if($query_petition_grade && $query_grade) {
                echo "success";
            } else {
                echo "fail";
            }
        }
    }

    if($_REQUEST['method'] == "petition_grade") {
        $grade_id = $_POST['grade_id'];
        $sql_grade = "SELECT grade.course_id, grade.score, course.course_name FROM grade LEFT JOIN course ON (course.course_id = grade.course_id) WHERE grade_id = '$grade_id'";
        $result = mysqli_query($connect, $sql_grade);
        $grade = $result->fetch_assoc();

        echo json_encode($grade);
    }

    if($_REQUEST['method'] == "approve_grade") {
        $grade_id = $_POST['grade_id'];
        
        $sql_grade = "SELECT course_id FROM grade WHERE grade_id = '$grade_id'";
        $query_grade = mysqli_query($connect, $sql_grade);
        $grade = $query_grade->fetch_assoc();

        $sql = "UPDATE petition_grade SET status = 'อนุมัติแล้ว', check_at = SYSDATE() WHERE course_id = '".$grade['course_id']."'";
        if(mysqli_query($connect, $sql)) {
            echo "success";
        } else {
            echo "fail";
        }
    }

    if($_REQUEST['method'] == "disapproved_grade") {
        $grade_id = $_POST['grade_id'];
        
        $sql_grade = "SELECT course_id FROM grade WHERE grade_id = '$grade_id'";
        $query_grade = mysqli_query($connect, $sql_grade);
        $grade = $query_grade->fetch_assoc();
        
        $sql = "UPDATE petition_grade SET status = 'ไม่อนุมัติ', check_at = SYSDATE() WHERE course_id = '".$grade['course_id']."'";
        if(mysqli_query($connect, $sql)) {
            echo "success";
        } else {
            echo "fail";
        }
    }
?>