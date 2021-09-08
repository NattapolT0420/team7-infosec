<?php
    include("server.php");
    session_start();

    date_default_timezone_set("Asia/Bangkok");
    function dateDiff($data) {
        $date = date('Y-m-d H:i:s', strtotime($data));
        $now = date("Y-m-d H:i:s");
        $theDiff = "";
        //echo $now;//2014-06-06 21:35:55
        $datetime1 = date_create($date);
        $datetime2 = date_create($now);
        $interval = date_diff($datetime1, $datetime2);
        $min=$interval->format('%i');
        $sec=$interval->format('%s');
        $hour=$interval->format('%h');
        $mon=$interval->format('%m');
        $day=$interval->format('%d');
        $year=$interval->format('%y');
        if($interval->format('%i%h%d%m%y')=="00000") {
            //echo $interval->format('%i%h%d%m%y')."<br>";
            return $sec." วินาทีที่แล้ว";
        } else if($interval->format('%h%d%m%y')=="0000"){
            return $min." นาทีที่แล้ว";
        } else if($interval->format('%d%m%y')=="000"){
            return $hour." ชั่วโมงที่แล้ว";
        } else if($interval->format('%m%y')=="00"){
            return $day." วันที่แล้ว";
        } else if($interval->format('%y')=="0"){
            return $mon." เดือนที่แล้ว";
        } else{
            return $year." ปีที่แล้ว";
        }    
    }

    if($_GET['page'] == "list_role") {
        
        $sql = "SELECT * FROM role";
        $result = $connect->query($sql);

        $caseCh_arr = array();
        foreach($result->fetch_all(MYSQLI_ASSOC) as $data) {
            $caseCh_col_arr["list_role"] = '<div class="txt_table ">' . $data['role_name'] . '</div>';

            $val = "";
            if($data['permission']) {
                $permission = json_decode($data['permission']);
                foreach($permission as $key => $value) {
                    if($value == "list_role"){
                        $val .= "จัดการสิทธิ์, ";
                    } elseif($value == "list_teacher"){
                        $val .= "รายชื่อผู้สอน, ";
                    } elseif ($value == "list_student") {
                        $val .= "รายชื่อนักเรียน, ";
                    } elseif ($value == "list_parent") {
                        $val .= "รายชื่อผู้ปกครอง, ";
                    } elseif ($value == "status_teacher") {
                        $val .= "การใช้งานของผู้สอน, ";
                    } elseif ($value == "status_student") {
                        $val .= "การใช้งานของนักเรียน, ";
                    } elseif ($value == "status_parent") {
                        $val .= "การใช้งานของผู้ปกครอง, ";
                    } elseif ($value == "course") {
                        $val .= "จัดการรายวิชา, ";
                    } elseif ($value == "teacher_course") {
                        $val .= "รายวิชาที่สอน, ";
                    } elseif ($value == "student_course") {
                        $val .= "รายวิชาที่เรียน, ";
                    } elseif ($value == "grade") {
                        $val .= "ผลการเรียน, ";
                    } elseif ($value == "petition_grade") {
                        $val .= "คำร้องขอตัดเกรด, ";
                    } elseif ($value == "petition_course") {
                        $val .= "คำร้องขอเพิ่ม / ถอนรายวิชา, ";
                    } elseif ($value == "petition") {
                        $val .= "จัดการคำร้องอื่น ๆ, ";
                    }
                }
                if($val != ""){
                    $val = substr($val, 0, -2);
                }
            }
            $caseCh_col_arr["list_permission"] = '<div class="txt_table ">' . $val . '</div>';

            $caseCh_col_arr["action"] =
            ' <div><button type="button" class="btn btn-warning btn-sm edit mr-1" onclick="edit_role('. $data['role_id'] .')">แก้ไข</button></div>';
            array_push($caseCh_arr, $caseCh_col_arr);
        }
        echo json_encode($caseCh_arr);
    }

    if($_GET['page'] == "list_teacher") {
        
        $sql = "SELECT * FROM users WHERE role_id='2'";
        $result = $connect->query($sql);

        $caseCh_arr = array();
        foreach($result->fetch_all(MYSQLI_ASSOC) as $data) {
            $caseCh_col_arr["list_teacher_id"] = '<div class="txt_table ">' . $data['userid'] . '</div>';
            $caseCh_col_arr["list_teacher_name"] = '<div class="txt_table ">' . $data['name'] . '</div>';
            $caseCh_col_arr["action"] =
            ' <div><button type="button" class="btn btn-warning btn-sm edit mr-1" onclick="edit_list('. $data['id'] .')">แก้ไข</button>
            <button type="button" class="btn btn-danger btn-sm del mr-1" onclick="del_list('. $data['id'] .')">ลบ</button>
            <button type="button" class="btn btn-info btn-sm del" onclick="log_list('. $data['id'] .')">ประวัติ</button></div>';
            array_push($caseCh_arr, $caseCh_col_arr);
        }
        echo json_encode($caseCh_arr);
    }

    if($_GET['page'] == "list_student") {
        
        $sql = "SELECT * FROM users WHERE role_id='3'";
        $result = $connect->query($sql);

        $caseCh_arr = array();
        foreach($result->fetch_all(MYSQLI_ASSOC) as $data) {
            $caseCh_col_arr["list_student_id"] = '<div class="txt_table ">' . $data['userid'] . '</div>';
            $caseCh_col_arr["list_student_name"] = '<div class="txt_table ">' . $data['name'] . '</div>';
            $caseCh_col_arr["action"] =
            ' <div><button type="button" class="btn btn-warning btn-sm edit mr-1" onclick="edit_list('. $data['id'] .')">แก้ไข</button>
            <button type="button" class="btn btn-danger btn-sm del mr-1" onclick="del_list('. $data['id'] .')">ลบ</button>
            <button type="button" class="btn btn-info btn-sm del" onclick="log_list('. $data['id'] .')">ประวัติ</button></div>';
            array_push($caseCh_arr, $caseCh_col_arr);
        }
        echo json_encode($caseCh_arr);
    }

    if($_GET['page'] == "list_parent") {
        
        $sql = "SELECT * FROM users WHERE role_id='4'";
        $result = $connect->query($sql);

        $caseCh_arr = array();
        foreach($result->fetch_all(MYSQLI_ASSOC) as $data) {
            $caseCh_col_arr["list_student_id"] = '<div class="txt_table ">' . $data['userid'] . '</div>';
            $caseCh_col_arr["list_student_name"] = '<div class="txt_table ">' . $data['name'] . '</div>';
            $caseCh_col_arr["action"] =
            ' <div><button type="button" class="btn btn-warning btn-sm edit mr-1" onclick="edit_list('. $data['id'] .')">แก้ไข</button>
            <button type="button" class="btn btn-danger btn-sm del mr-1" onclick="del_list('. $data['id'] .')">ลบ</button>
            <button type="button" class="btn btn-info btn-sm del" onclick="log_list('. $data['id'] .')">ประวัติ</button></div>';
            array_push($caseCh_arr, $caseCh_col_arr);
        }
        echo json_encode($caseCh_arr);
    }

    if($_GET['page'] == "status_teacher") {
        
        $sql = "SELECT MAX(log_id) as log_id, users_id,userid,name,role_id,MAX(login_at) as login_at FROM log_users WHERE role_id='2' AND login_at IS NOT NULL GROUP BY users_id";
        $result = $connect->query($sql);

        $caseCh_arr = array();
        foreach($result->fetch_all(MYSQLI_ASSOC) as $data) {
            $caseCh_col_arr["status_teacher_id"] = '<div class="txt_table ">' . $data['userid'] . '</div>';
            $caseCh_col_arr["status_teacher_name"] = '<div class="txt_table ">' . $data['name'] . '</div>';
            // $caseCh_col_arr["status_teacher"] =
            // '<div><select class="form-select" id="val_status_teacher" name="val_status_teacher">
            //     <option value="" disabled selected>กรุณาเลือกสถานะ</option>
            //     <option value="normal">ปกติ</option>
            //     <option value="sick">ลาป่วย</option>
            //     <option value="vacation">ลาพักร้อน</option>
            //     <option value="resign">ลาออก</option>
            // </select></div>';
            $caseCh_col_arr["time_teacher"] = '<div class="txt_table ">' . dateDiff($data['login_at']) . '</div>';
            array_push($caseCh_arr, $caseCh_col_arr);
        }
        echo json_encode($caseCh_arr);
    }

    if($_GET['page'] == "status_student") {
        
        $sql = "SELECT MAX(log_id) as log_id, users_id,userid,name,role_id,MAX(login_at) as login_at FROM log_users WHERE role_id='3' AND login_at IS NOT NULL GROUP BY users_id";
        $result = $connect->query($sql);

        $caseCh_arr = array();
        foreach($result->fetch_all(MYSQLI_ASSOC) as $data) {
            $caseCh_col_arr["status_student_id"] = '<div class="txt_table ">' . $data['userid'] . '</div>';
            $caseCh_col_arr["status_student_name"] = '<div class="txt_table ">' . $data['name'] . '</div>';
            // $caseCh_col_arr["status_student"] =
            // '<div><select class="form-select" id="val_status_student" name="val_status_student">
            //     <option value="" disabled selected>กรุณาเลือกสถานะ</option>
            //     <option value="normal">ปกติ</option>
            //     <option value="sick">ลาป่วย</option>
            //     <option value="resign">ออก</option>
            // </select></div>';
            $caseCh_col_arr["time_student"] = '<div class="txt_table ">' . dateDiff($data['login_at']) . '</div>';
            array_push($caseCh_arr, $caseCh_col_arr);
        }
        echo json_encode($caseCh_arr);
    }

    if($_GET['page'] == "status_parent") {
        
        $sql = "SELECT MAX(log_id) as log_id, users_id,userid,name,role_id,MAX(login_at) as login_at FROM log_users WHERE role_id='4' AND login_at IS NOT NULL GROUP BY users_id";
        $result = $connect->query($sql);

        $caseCh_arr = array();
        foreach($result->fetch_all(MYSQLI_ASSOC) as $data) {
            $caseCh_col_arr["status_parent_id"] = '<div class="txt_table ">' . $data['userid'] . '</div>';
            $caseCh_col_arr["status_parent_name"] = '<div class="txt_table ">' . $data['name'] . '</div>';
            // $caseCh_col_arr["status_student"] =
            // '<div><select class="form-select" id="val_status_student" name="val_status_student">
            //     <option value="" disabled selected>กรุณาเลือกสถานะ</option>
            //     <option value="normal">ปกติ</option>
            //     <option value="sick">ลาป่วย</option>
            //     <option value="resign">ออก</option>
            // </select></div>';
            $caseCh_col_arr["time_parent"] = '<div class="txt_table ">' . dateDiff($data['login_at']) . '</div>';
            array_push($caseCh_arr, $caseCh_col_arr);
        }
        echo json_encode($caseCh_arr);
    }

    if($_GET['page'] == "course") {
        
        $sql = "SELECT * FROM course";
        $result = $connect->query($sql);

        $caseCh_arr = array();
        foreach($result->fetch_all(MYSQLI_ASSOC) as $data) {
            $sql_teacher = "SELECT * FROM users WHERE userid = ".$data['course_teacher'];
            $result = mysqli_query($connect, $sql_teacher);
            $teacher = $result->fetch_assoc();

            $caseCh_col_arr["course_id"] = '<div class="txt_table ">' . $data['course_id'] . '</div>';
            $caseCh_col_arr["course_name"] = '<div class="txt_table ">' . $data['course_name'] . '</div>';
            $caseCh_col_arr["course_credit"] = '<div class="txt_table ">' . $data['course_credit'] . '</div>';
            $caseCh_col_arr["course_teacher"] = '<div class="txt_table ">' . $teacher['name'] . '</div>';
            $caseCh_col_arr["action"] =
            ' <div><button type="button" class="btn btn-warning btn-sm edit mr-1" onclick="edit_course('. $data['id'] .')">แก้ไข</button>
            <button type="button" class="btn btn-danger btn-sm del mr-1" onclick="del_course('. $data['id'] .')">ลบ</button>
            <button type="button" class="btn btn-info btn-sm del" onclick="log_course('. $data['id'] .')">ประวัติ</button></div>';
            array_push($caseCh_arr, $caseCh_col_arr);
        }
        echo json_encode($caseCh_arr);
    }

    if($_GET['page'] == "teacher_course") {
        
        $sql = "SELECT * FROM course WHERE course_teacher='".$_SESSION['userid']."'";
        $result = $connect->query($sql);

        $caseCh_arr = array();
        foreach($result->fetch_all(MYSQLI_ASSOC) as $data) {
            $caseCh_col_arr["course_id"] = '<div class="txt_table ">' . $data['course_id'] . '</div>';
            $caseCh_col_arr["course_name"] = '<div class="txt_table ">' . $data['course_name'] . '</div>';
            array_push($caseCh_arr, $caseCh_col_arr);
        }
        echo json_encode($caseCh_arr);
    }

    if($_GET['page'] == "student_course") {
        
        $sql = "SELECT * FROM petition_course WHERE student_id='".$_SESSION['userid']."' AND status='อนุมัติแล้ว'";
        $result = $connect->query($sql);

        $caseCh_arr = array();
        foreach($result->fetch_all(MYSQLI_ASSOC) as $data) {
            $sql_course = "SELECT * FROM course WHERE course_id = '".$data['course_id']."'";
            $result = mysqli_query($connect, $sql_course);
            $course = $result->fetch_assoc();

            $caseCh_col_arr["course_id"] = '<div class="txt_table ">' . $data['course_id'] . '</div>';
            $caseCh_col_arr["course_name"] = '<div class="txt_table ">' . $course['course_name'] . '</div>';
            array_push($caseCh_arr, $caseCh_col_arr);
        }
        echo json_encode($caseCh_arr);
    }

    if($_GET['page'] == "grade") {
        
        // $sql = "SELECT c.course_id, c.course_name, u.name, c.course_credit, g.score FROM grade AS g
        // LEFT JOIN course AS c ON (c.course_id = g.course_id)
        // LEFT JOIN petition_grade AS pg ON (pg.course_id = g.course_id)
        // LEFT JOIN users AS u ON (u.userid = c.course_teacher)
        // WHERE pg.status='อนุมัติแล้ว'";
        $sql = "SELECT c.course_id, c.course_name, u.name, c.course_credit, g.score, pc.student_id FROM grade AS g
        LEFT JOIN course AS c ON (c.course_id = g.course_id)
        LEFT JOIN petition_course AS pc ON (pc.course_id = g.course_id)
        LEFT JOIN petition_grade AS pg ON (pg.course_id = g.course_id)
        LEFT JOIN users AS u ON (u.userid = c.course_teacher)
        WHERE pc.student_id = '".$_SESSION['userid']."' AND pg.status='อนุมัติแล้ว'";
        $result = $connect->query($sql);

        $caseCh_arr = array();
        foreach($result->fetch_all(MYSQLI_ASSOC) as $data) {
            // $sql_course = "SELECT * FROM course WHERE course_id = '".$data['course_id']."'";
            // $result = mysqli_query($connect, $sql_course);
            // $course = $result->fetch_assoc();

            $caseCh_col_arr["course_id"] = '<div class="txt_table ">' . $data['course_id'] . '</div>';
            $caseCh_col_arr["course_name"] = '<div class="txt_table ">' . $data['course_name'] . '</div>';
            $caseCh_col_arr["teacher"] = '<div class="txt_table ">' . $data['name'] . '</div>';
            $caseCh_col_arr["credit"] = '<div class="txt_table ">' . $data['course_credit'] . '</div>';

            $score_arr = json_decode($data['score']);
            foreach($score_arr as $key => $value) {
                if($key == $data['student_id']) {
                    $score = $value;
                }
            }
            if(is_numeric($score)) {
                if($score >= 80 && $score <= 100){
                    $grade = 'A';
                } else if($score >= 75 && $score < 80) {
                    $grade = 'B+';
                } else if($score >= 70 && $score < 75) {
                    $grade = 'B';
                } else if($score >= 65 && $score < 70) {
                    $grade = 'C+';
                } else if($score >= 60 && $score < 65) {
                    $grade = 'C';
                } else if($score >= 55 && $score < 60) {
                    $grade = 'D+';
                } else if($score >= 50 && $score < 55) {
                    $grade = 'D';
                } else if($score >= 0 && $score < 50) {
                    $grade = 'F';
                }
                $caseCh_col_arr["grade"] = '<div class="txt_table">' . $grade . '</div>';
            } else {
                $grade = 'คะแนนไม่ถูกต้อง';
                $caseCh_col_arr["grade"] = '<div class="txt_table" style="color: #FFFFFF; background-color: #E74C3C; width: 80%; border-radius: 10px; margin-left: auto; margin-right: auto;">' . $grade . '</div>';
            }
            array_push($caseCh_arr, $caseCh_col_arr);
        }
        echo json_encode($caseCh_arr);
    }

    if($_GET['page'] == "petition_grade") {
        
        $sql = "SELECT * FROM course WHERE course_teacher='".$_SESSION['userid']."'";
        $result = $connect->query($sql);

        $caseCh_arr = array();
        foreach($result->fetch_all(MYSQLI_ASSOC) as $data) {
            $caseCh_col_arr["course_id"] = '<div class="txt_table ">' . $data['course_id'] . '</div>';
            $caseCh_col_arr["course_name"] = '<div class="txt_table ">' . $data['course_name'] . '</div>';

            $grade_check_status = "SELECT * FROM petition_grade WHERE course_id = '". $data['course_id'] ."'";
            $query = mysqli_query($connect, $grade_check_status);
            if(mysqli_num_rows($query) == 0) {
                $caseCh_col_arr["action"] =
                '<div><button type="button" class="btn btn-warning btn-sm edit mr-1" onclick="grade('. $data['id'] .')">ตัดเกรด</button></div>';
            } else {
                $grade = $query->fetch_assoc();
                if($grade['status'] == "รอการอนุมัติ") {
                    $caseCh_col_arr["action"] = '<div class="txt_table" style="color: #FFFFFF; background-color: #F1C40F; width: 50%; border-radius: 10px; margin-left: auto; margin-right: auto;">' . $grade['status'] . '</div>';
                } else if($grade['status'] == "อนุมัติแล้ว") {
                    $caseCh_col_arr["action"] = '<div class="txt_table" style="color: #FFFFFF; background-color: #27AE60; width: 50%; border-radius: 10px; margin-left: auto; margin-right: auto;">' . $grade['status'] . '</div>';
                } else if($grade['status'] == "ไม่อนุมัติ") {
                    $caseCh_col_arr["action"] =
                    '<div><button type="button" class="btn btn-danger btn-sm edit mr-1" onclick="grade('. $data['id'] .')">ตัดเกรดอีกครั้ง</button></div>';
                }
            }

            array_push($caseCh_arr, $caseCh_col_arr);
        }
        echo json_encode($caseCh_arr);
    }

    if($_GET['page'] == "petition_grade_student") {
        
        $post = array();
        $request_body = file_get_contents('php://input');
        $post = json_decode($request_body);
        $course_id = $post->course_id;
        $grade_id = $post->grade_id;

        if($course_id != "") {
            $sql = "SELECT * FROM petition_course WHERE course_id='$course_id' AND status='อนุมัติแล้ว'";
            $result = $connect->query($sql);

            $caseCh_arr = array();
            foreach($result->fetch_all(MYSQLI_ASSOC) as $data) {
                $sql_course = "SELECT * FROM course WHERE course_id = '".$data['course_id']."'";
                $result = mysqli_query($connect, $sql_course);
                $course_name = $result->fetch_assoc();

                $sql_student = "SELECT * FROM users WHERE userid = ".$data['student_id'];
                $result = mysqli_query($connect, $sql_student);
                $student = $result->fetch_assoc();

                // $caseCh_col_arr["course_id"] = '<div class="txt_table"></div>';
                // $caseCh_col_arr["course_name"] = '<div class="txt_table"></div>';
                $caseCh_col_arr["student_id"] = '<div class="txt_table" data-id="' . $data['course_id'] . '" data-name="' . $course_name['course_name'] . '">' . $data['student_id'] . '</div>';
                $caseCh_col_arr["student_name"] = '<div class="txt_table">' . $student['name'] . '</div>';
                $caseCh_col_arr["action"] =
                '<div><input type="text" class="form-control grade" placeholder="คะแนน..." data-id="'. $data['student_id'] .'"></div>';
                array_push($caseCh_arr, $caseCh_col_arr);
            }
            echo json_encode($caseCh_arr);
        } else if($grade_id != "") {
            $sql = "SELECT * FROM grade AS g LEFT JOIN petition_course AS pc ON (pc.course_id = g.course_id) WHERE grade_id='$grade_id'";
            $result = $connect->query($sql);

            $caseCh_arr = array();
            foreach($result->fetch_all(MYSQLI_ASSOC) as $data) {
                $sql_course = "SELECT * FROM course WHERE course_id = '".$data['course_id']."'";
                $result = mysqli_query($connect, $sql_course);
                $course_name = $result->fetch_assoc();

                $sql_student = "SELECT * FROM users WHERE userid = ".$data['student_id'];
                $result = mysqli_query($connect, $sql_student);
                $student = $result->fetch_assoc();

                $score_arr = json_decode($data['score']);
                foreach($score_arr as $key => $value) {
                    if($key == $data['student_id']) {
                        $score = $value;
                    }
                }

                $caseCh_col_arr["student_id"] = '<div class="txt_table">' . $data['student_id'] . '</div>';
                $caseCh_col_arr["student_name"] = '<div class="txt_table">' . $student['name'] . '</div>';
                $caseCh_col_arr["action"] = '<div class="txt_table">' . $score . '</div>';
                array_push($caseCh_arr, $caseCh_col_arr);
            }
            echo json_encode($caseCh_arr);
        }
    }

    if($_GET['page'] == "petition_course") {
        
        $sql = "SELECT * FROM petition_course WHERE student_id='".$_SESSION['userid']."'";
        $result = $connect->query($sql);

        $caseCh_arr = array();
        foreach($result->fetch_all(MYSQLI_ASSOC) as $data) {
            $sql_course = "SELECT * FROM course WHERE course_id = '".$data['course_id']."'";
            $result = mysqli_query($connect, $sql_course);
            $course_name = $result->fetch_assoc();

            $caseCh_col_arr["course_id"] = '<div class="txt_table ">' . $data['course_id'] . '</div>';
            $caseCh_col_arr["course_name"] = '<div class="txt_table ">' . $course_name['course_name'] . '</div>';
            $caseCh_col_arr["course_credit"] = '<div class="txt_table ">' . $course_name['course_credit'] . '</div>';
            if($data['status'] == "รอการอนุมัติ") {
                $caseCh_col_arr["status"] = '<div class="txt_table" style="color: #FFFFFF; background-color: #F1C40F; width: 50%; border-radius: 10px; margin-left: auto; margin-right: auto;">' . $data['status'] . '</div>';
            } else if($data['status'] == "อนุมัติแล้ว") {
                $caseCh_col_arr["status"] = '<div class="txt_table" style="color: #FFFFFF; background-color: #27AE60; width: 50%; border-radius: 10px; margin-left: auto; margin-right: auto;">' . $data['status'] . '</div>';
            } else if($data['status'] == "ไม่อนุมัติ") {
                $caseCh_col_arr["status"] = '<div class="txt_table" style="color: #FFFFFF; background-color: #E74C3C; width: 50%; border-radius: 10px; margin-left: auto; margin-right: auto;">' . $data['status'] . '</div>';
            }
            $caseCh_col_arr["send_at"] = '<div class="txt_table ">' . $data['send_at'] . '</div>';
            $caseCh_col_arr["check_at"] = '<div class="txt_table ">' . $data['check_at'] . '</div>';
            $caseCh_col_arr["action"] =
            ' <div><button type="button" class="btn btn-danger btn-sm del mr-1" onclick="del_petition_course('. $data['id'] .')">ถอนวิชา</button></div>';
            array_push($caseCh_arr, $caseCh_col_arr);
        }
        echo json_encode($caseCh_arr);
    }

    if($_GET['page'] == "petition_course_list") {
        
        $sql = "SELECT * FROM petition_course WHERE status='รอการอนุมัติ'";
        $result = $connect->query($sql);

        $caseCh_arr = array();
        foreach($result->fetch_all(MYSQLI_ASSOC) as $data) {
            $sql_course = "SELECT * FROM course WHERE course_id = '".$data['course_id']."'";
            $result = mysqli_query($connect, $sql_course);
            $course_name = $result->fetch_assoc();

            $sql_student = "SELECT * FROM users WHERE userid = ".$data['student_id'];
            $result = mysqli_query($connect, $sql_student);
            $student = $result->fetch_assoc();

            $caseCh_col_arr["course_id"] = '<div class="txt_table ">' . $data['course_id'] . '</div>';
            $caseCh_col_arr["course_name"] = '<div class="txt_table ">' . $course_name['course_name'] . '</div>';
            $caseCh_col_arr["course_credit"] = '<div class="txt_table ">' . $course_name['course_credit'] . '</div>';
            $caseCh_col_arr["student_id"] = '<div class="txt_table ">' . $data['student_id'] . '</div>';
            $caseCh_col_arr["student_name"] = '<div class="txt_table ">' . $student['name'] . '</div>';
            $caseCh_col_arr["send_at"] = '<div class="txt_table ">' . $data['send_at'] . '</div>';
            $caseCh_col_arr["action"] =
            ' <div><button type="button" class="btn btn-success btn-sm del mr-1" onclick="approve_petition_course('. $data['id'] .')">อนุมัติ</button>
            <button type="button" class="btn btn-danger btn-sm del mr-1" onclick="disapproved_petition_course('. $data['id'] .')">ไม่อนุมัติ</button></div>';
            array_push($caseCh_arr, $caseCh_col_arr);
        }
        echo json_encode($caseCh_arr);
    }

    if($_GET['page'] == "petition_grade_list") {
        
        $sql = "SELECT * FROM petition_grade WHERE status='รอการอนุมัติ'";
        $result = $connect->query($sql);

        $caseCh_arr = array();
        foreach($result->fetch_all(MYSQLI_ASSOC) as $data) {
            $sql_course = "SELECT * FROM course WHERE course_id = '".$data['course_id']."'";
            $result = mysqli_query($connect, $sql_course);
            $course_name = $result->fetch_assoc();

            $sql_teacher = "SELECT * FROM users WHERE userid = ".$course_name['course_teacher'];
            $result = mysqli_query($connect, $sql_teacher);
            $teacher = $result->fetch_assoc();

            $sql_grade = "SELECT grade_id FROM grade WHERE course_id = '".$data['course_id']."'";
            $result = mysqli_query($connect, $sql_grade);
            $grade = $result->fetch_assoc();

            $caseCh_col_arr["course_id"] = '<div class="txt_table ">' . $data['course_id'] . '</div>';
            $caseCh_col_arr["course_name"] = '<div class="txt_table ">' . $course_name['course_name'] . '</div>';
            $caseCh_col_arr["course_credit"] = '<div class="txt_table ">' . $course_name['course_credit'] . '</div>';
            $caseCh_col_arr["teacher_id"] = '<div class="txt_table ">' . $teacher['userid'] . '</div>';
            $caseCh_col_arr["teacher_name"] = '<div class="txt_table ">' . $teacher['name'] . '</div>';
            $caseCh_col_arr["send_at"] = '<div class="txt_table ">' . $data['send_at'] . '</div>';
            $caseCh_col_arr["action"] =
            ' <div><button type="button" class="btn btn-success btn-sm del mr-1" onclick="petition_grade('. $grade['grade_id'] .')">รายละเอียด</button></div>';
            array_push($caseCh_arr, $caseCh_col_arr);
        }
        echo json_encode($caseCh_arr);
    }
?>