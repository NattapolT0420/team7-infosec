<?php

    include('server.php');

    if($_REQUEST['method'] == "insert_course") {
        $course_id = $_POST['course_id'];
        $course_name = $_POST['course_name'];
        $course_credit = $_POST['course_credit'];
        $course_teacher = $_POST['course_teacher'];

        // print_r("course_id: ".$course_id." course_name: ".$course_name." course_credit: ".$course_credit."course_teacher: ".$course_teacher);
        // exit;

        $course_check_query = "SELECT * FROM course WHERE course_id = '$course_id' OR course_name = '$course_name'";
        $query = mysqli_query($connect, $course_check_query);
        // echo mysqli_num_rows($query);
        
        if(mysqli_num_rows($query) >= 1) {
            echo "again";
        } else {
            $sql = "INSERT INTO course (course_id, course_name, course_credit, course_teacher) VALUES ('$course_id', '$course_name', '$course_credit', '$course_teacher')";
            $query = mysqli_query($connect, $sql);
            $sql_course_log = "INSERT INTO log_course (table_course_id, course_id, course_name, course_credit, course_teacher, add_at) VALUES ('".mysqli_insert_id($connect)."', '$course_id', '$course_name', '$course_credit', '$course_teacher', SYSDATE())";
            $query_course_log = mysqli_query($connect, $sql_course_log);
            if($query && $query_course_log) {
                echo "success";
            }
        }
    }

    if($_REQUEST['method'] == "select_course") {
        $id = $_POST['id'];
        
        $sql = "SELECT * FROM course WHERE id = '$id'";
        $result = mysqli_query($connect, $sql);
        $list = $result->fetch_assoc();
        echo json_encode($list);
    }

    if($_REQUEST['method'] == "save_course") {
        $id = $_POST['id'];
        $course_id = $_POST['course_id'];
        $course_name = $_POST['course_name'];
        $course_credit = $_POST['course_credit'];
        $course_teacher = $_POST['course_teacher'];
        
        $sql_check = "SELECT * FROM course WHERE course_id = '$course_id' AND course_name = '$course_name' AND course_credit = '$course_credit' AND course_teacher = '$course_teacher'";
        $query = mysqli_query($connect, $sql_check);

        if(mysqli_num_rows($query) >= 1) {
            echo "already";
        } else {
            $sql_course_log = "INSERT INTO log_course (table_course_id, course_id, course_name, course_credit, course_teacher, edit_at) VALUES ('$id', '$course_id', '$course_name', '$course_credit', '$course_teacher', SYSDATE())";
            $sql_course = "UPDATE course SET course_id = '$course_id', course_name = '$course_name', course_credit = '$course_credit', course_teacher = '$course_teacher' WHERE id = '$id'";
            if(mysqli_query($connect, $sql_course) && mysqli_query($connect, $sql_course_log)) {
                echo "success";
            } else {
                echo "fail";
            }
        }
    }

    if($_REQUEST['method'] == "del_course") {
        $id = $_POST['id'];
        
        $sql = "DELETE FROM course where id = $id";
        $sql_log = "DELETE FROM log_course where table_course_id = $id";
        if(mysqli_query($connect, $sql) && mysqli_query($connect, $sql_log)) {
            echo "success";
        } else {
            echo "fail";
        }
    }

    if($_REQUEST['method'] == "log_course") {
        $id = $_POST['id'];

        $sql = "SELECT * FROM log_course WHERE table_course_id = $id";
        $result = mysqli_query($connect, $sql);
        $datalog = "";

        foreach($result->fetch_all(MYSQLI_ASSOC) as $data) {
            $sql_user = "SELECT name FROM users WHERE userid = ".$data['course_teacher'];
            $query = mysqli_query($connect, $sql_user);
            $user = mysqli_fetch_assoc($query);

            if($data['add_at'] != NULL) {
                $datalog .= '<p><label for="logdatetime">เพิ่มวิชาเมื่อ '. $data['add_at'] .'</label><br>';
            } else if($data['edit_at'] != NULL) {
                $datalog .= '<p><label for="logdatetime">แก้ไขวิชาเมื่อ '. $data['edit_at'] .'</label><br>';
            }
            $datalog .= '<label for="CourseID">รหัสวิชา :&nbsp</label>';
            $datalog .= '<label for="ีlogcourseid">' . $data['course_id'] . '</label><br>';
            $datalog .= '<label for="CourseName">ชื่อวิชา :&nbsp</label>';
            $datalog .= '<label for="logcoursename">' . $data['course_name'] . '</label><br>';
            $datalog .= '<label for="CourseCredit">หน่วยกิต :&nbsp</label>';
            $datalog .= '<label for="logcoursecredit">' . $data['course_credit'] . '</label><br>';
            $datalog .= '<label for="CourseTeacher">ผู้สอน :&nbsp</label>';
            $datalog .= '<label for="logcourseteacher">' . $user['name'] . '</label><br></p><hr>';
        }
        $datalog = substr($datalog, 0, -4); // substring <hr>
        
        echo $datalog;
    }
?>