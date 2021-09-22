<?php

    session_start();

    if(!isset($_SESSION['token'])) {
        $_SESSION['chklogin'] = "กรุณาเข้าสู่ระบบก่อน";
        header('location: login.php');
    }

    // if(isset($_GET['logout'])) {
    //     session_destroy();
    //     unset($_SESSION['name']);
    //     header('location: login.php');
    // }

    include("list_teacher.php");
    include("list_course.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team7-Infosec</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>

    <!-- Table Auto Refresh -->
    <link href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css" rel="stylesheet">
    <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>

    <!-- Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!-- SweetAlert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- CSS -->
    <link rel='stylesheet' type='text/css' href='css/main.css'>
</head>

<body id="bodyindex">

    <header class="header" id="header">
        <div class="header_back">
            <button type="button" class="header_btn_back" onclick="header_back()"><i class='bx bxs-left-arrow'></i></button>
            <span class="header_title_grade">Text</span>
        </div>
        <div class="header_title">หน้าหลัก</div>
        <div class="header_input course">
            <input type="text" id="course_id" class="form-control" placeholder="รหัสวิชา..." style="width: 25%;">
            <input type="text" id="course_name" class="form-control" placeholder="ชื่อวิชา..." style="width: 25%;">
            <input type="text" id="course_credit" class="form-control" placeholder="หน่วยกิต..." style="width: 15%;">
            <select class="form-control form-select" id="course_teacher" name="course_teacher" style="width: 25%;">
                <option value="" disabled selected>กรุณาเลือกผู้สอน</option>
                <?php
                    foreach ($list_teacher as $index => $value) {
                        echo '<option value="' . $value['teacher_userid'] . '">' . $value['teacher_name'] . '</option>';
                    }
                ?>
            </select>
            <button type="button" class="btn btn-success add" onclick="add_course()" id="add_course">เพิ่มวิชา</button>
        </div>
        <div class="header_input petition_course">
            <select class="form-select" id="select_petition_course" name="select_petition_course" style="width: 70%;">
                <option value="" disabled selected>กรุณาเลือกวิชา</option>
                <?php
                    foreach ($list_course as $index => $value) {
                        echo '<option value="' . $value['course_id'] . '">' . $value['course_name'] . '</option>';
                    }
                ?>
            </select>
            <button type="button" class="btn btn-success add" onclick="add_petition_course()" id="add_petition_course">เพิ่มวิชา</button>
        </div>
        <div class="header_input petition_grade">
            <button type="button" class="btn btn-success" onclick="send_petition_grade()" id="send_petition_grade">ส่งคำร้อง</button>
        </div>
        <div class="header_input petition_check_grade">
            <button type="button" class="btn btn-success" onclick="approve_petition_grade()" style="margin-right: 1rem;">อนุมัติ</button>
            <button type="button" class="btn btn-danger" onclick="disapproved_petition_grade()">ไม่อนุมัติ</button>
        </div>
        <div class="header_img"> <img src="https://i.imgur.com/hczKIze.jpg" alt=""> </div>
    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <div class="nav_toggle-name">
                    <span id="username"><?php echo $_SESSION['name']; ?></span>
                    <button type="button" class="nav_toggle">
                        <i class='bx bx-menu nav_toggle-icon' id="header-toggle"></i>
                    </button>
                </div>
                <div class="nav_list">
                    <a href="#home" class="nav_link active" data-bs-toggle="tab">
                        <i class='bx bx-home-circle nav_icon'></i>
                        <span class="nav_name">หน้าหลัก</span>
                    </a>
                    <a href="#info" class="nav_link" data-bs-toggle="tab">
                        <i class='bx bx-info-circle nav_icon'></i>
                        <span class="nav_name">อัพเดทข่าวสาร</span>
                    </a>
                    <a href="#contact" class="nav_link" data-bs-toggle="tab">
                        <i class='bx bxs-contact nav_icon'></i>
                        <span class="nav_name">ติดต่อ</span>
                    </a>

                    <hr>

                    <div id="role"><?php echo $_SESSION['role']; ?></div>
                    <input type="hidden" id="input_role_name" name="input_role_name" value="<?php echo $_SESSION['role']; ?>">
                    <?php if($_SESSION['role'] == 'ADMIN') { ?>
                        <a href="#list_role" class="nav_link" data-bs-toggle="tab" id="tab_list_role" data="list_role">
                            <i class='bx bxs-user-badge nav_icon'></i>
                            <span class="nav_name">จัดการสิทธิ์</span>
                        </a>
                    <?php } ?>
                    <div id="permission" style="display: none;">
                        <a href="#list_teacher" class="nav_link" data-bs-toggle="tab" data="list_teacher">
                            <i class='bx bx-user nav_icon'></i>
                            <span class="nav_name">รายชื่อผู้สอน</span>
                        </a>
                        <a href="#list_student" class="nav_link" data-bs-toggle="tab" data="list_student">
                            <i class='bx bxs-user nav_icon'></i>
                            <span class="nav_name">รายชื่อนักเรียน</span>
                        </a>
                        <a href="#list_parent" class="nav_link" data-bs-toggle="tab" data="list_parent">
                            <i class='bx bxs-group nav_icon'></i>
                            <span class="nav_name">รายชื่อผู้ปกครอง</span>
                        </a>
                        <a href="#status_teacher" class="nav_link" data-bs-toggle="tab" data="status_teacher">
                            <i class='bx bx-user-pin nav_icon'></i>
                            <span class="nav_name">การใช้งานของผู้สอน</span>
                        </a>
                        <a href="#status_student" class="nav_link" data-bs-toggle="tab" data="status_student">
                            <i class='bx bxs-user-pin nav_icon'></i>
                            <span class="nav_name">การใช้งานของนักเรียน</span>
                        </a>
                        <a href="#status_parent" class="nav_link" data-bs-toggle="tab" data="status_parent">
                            <i class='bx bxs-user-account nav_icon'></i>
                            <span class="nav_name">การใช้งานของผู้ปกครอง</span>
                        </a>
                        <a href="#course" class="nav_link" data-bs-toggle="tab" data="course">
                            <i class='bx bx-book-open nav_icon'></i>
                            <span class="nav_name">จัดการรายวิชา</span>
                        </a>
                        <a href="#teacher_course" class="nav_link" data-bs-toggle="tab" data="teacher_course">
                            <i class='bx bx-book-open nav_icon'></i>
                            <span class="nav_name">รายวิชาที่สอน</span>
                        </a>
                        <a href="#student_course" class="nav_link" data-bs-toggle="tab" data="student_course">
                            <i class='bx bx-book-open nav_icon'></i>
                            <span class="nav_name">รายวิชาที่เรียน</span>
                        </a>
                        <a href="#grade" class="nav_link" data-bs-toggle="tab" data="grade">
                            <i class='bx bxs-graduation nav_icon'></i>
                            <span class="nav_name">ผลการเรียน</span>
                        </a>
                        <a href="#petition_grade" class="nav_link" data-bs-toggle="tab" data="petition_grade">
                            <i class='bx bx-list-ul nav_icon'></i>
                            <span class="nav_name">คำร้องขอตัดเกรด</span>
                        </a>
                        <a href="#petition_course" class="nav_link" data-bs-toggle="tab" data="petition_course">
                            <i class='bx bx-list-ul nav_icon'></i>
                            <span class="nav_name">คำร้องขอเพิ่ม<br> / ถอนรายวิชา</span>
                        </a>
                        <a href="#petition" class="nav_link" data-bs-toggle="tab" data="petition">
                            <i class='bx bx-list-ul nav_icon'></i>
                            <span class="nav_name">จัดการคำร้องอื่น ๆ</span>
                        </a>
                    </div>
                </div>
            </div>
            <button type="button" class="nav_link btnlogout" onclick="logout()">
                <i class='bx bx-log-out-circle' style="font-size: 1.5rem;"></i>
                <span class="nav_name">SignOut</span>
            </button>
        </nav>
    </div>
    <!--Container Main start-->
    <div class="tab-content main">
        <div class="tab-pane active" role="tabpanel" id="home">
            <h1 style="height: 70vh; display: flex; justify-content: center; align-items: center; color: #FFFFFF;">คุณได้เข้าสู่ระบบโดยสิทธิ์ของ <?php echo $_SESSION['role']; ?></h1>
            <h5 style="height: 15vh; display: flex; justify-content: center; align-items: flex-end; text-align: center;">นำเสนอโดย<br><br>TEAM7 - INFOMATION SECURITY</h5>
        </div>
        <div class="tab-pane" role="tabpanel" id="info">
            <h2 style="text-align: center;">อัพเดทข่าวสาร</h2>
            <div class="card" style="margin-top: 30px;">
                <p>This side navigation is of full height (100%) and always shown.</p>
                <p>Lorem ipsum dolor sit amet, illum definitiones no quo, maluisset concludaturque et eum, altera fabulas ut
                    quo. Atqui causae gloriatur ius te, id agam omnis evertitur eum. Affert laboramus repudiandae nec et.
                    Inciderint efficiantur his ad. Eum no molestiae voluptatibus.</p>
                <p>Lorem ipsum dolor sit amet, illum definitiones no quo, maluisset concludaturque et eum, altera fabulas ut
                    quo. Atqui causae gloriatur ius te, id agam omnis evertitur eum. Affert laboramus repudiandae nec et.
                    Inciderint efficiantur his ad. Eum no molestiae voluptatibus.</p>
            </div>
            <div class="card">
                <p>This side navigation is of full height (100%) and always shown.</p>
                <p>Lorem ipsum dolor sit amet, illum definitiones no quo, maluisset concludaturque et eum, altera fabulas ut
                    quo. Atqui causae gloriatur ius te, id agam omnis evertitur eum. Affert laboramus repudiandae nec et.
                    Inciderint efficiantur his ad. Eum no molestiae voluptatibus.</p>
                <p>Lorem ipsum dolor sit amet, illum definitiones no quo, maluisset concludaturque et eum, altera fabulas ut
                    quo. Atqui causae gloriatur ius te, id agam omnis evertitur eum. Affert laboramus repudiandae nec et.
                    Inciderint efficiantur his ad. Eum no molestiae voluptatibus.</p>
            </div>
            <div class="card">
                <p>This side navigation is of full height (100%) and always shown.</p>
                <p>Lorem ipsum dolor sit amet, illum definitiones no quo, maluisset concludaturque et eum, altera fabulas ut
                    quo. Atqui causae gloriatur ius te, id agam omnis evertitur eum. Affert laboramus repudiandae nec et.
                    Inciderint efficiantur his ad. Eum no molestiae voluptatibus.</p>
                <p>Lorem ipsum dolor sit amet, illum definitiones no quo, maluisset concludaturque et eum, altera fabulas ut
                    quo. Atqui causae gloriatur ius te, id agam omnis evertitur eum. Affert laboramus repudiandae nec et.
                    Inciderint efficiantur his ad. Eum no molestiae voluptatibus.</p>
            </div>
        </div>
        <div class="tab-pane" role="tabpanel" id="contact">
            <div class="container">
                <div style="text-align:center">
                    <h2>ติดต่อ</h2>
                    <p>กรุณากรอกข้อมูลและรายละเอียดที่ต้องการจะติดต่อ</p>
                </div>
                <div class="row">
                    <div class="column">
                        <img src="images/contact.jpg" style="width:90%; padding-top: 2%;">
                    </div>
                    <div class="column form-group">
                        <form id="contact-form" method="post">
                            <label for="fname">ชื่อ</label>
                            <input type="text" class="form-control" id="fname" name="firstname"
                                placeholder="กรุณากรอกชื่อ...">
                            <label for="lname">นามสกุล</label>
                            <input type="text" class="form-control" id="lname" name="lastname"
                                placeholder="กรุณากรอกนามสกุล...">
                            <!-- <label for="country">จังหวัด</label>
                            <select class="form-select" id="country" name="country">
                                <option value="bangkok">กรุงเทพมหานคร</option>
                                <option value="nst">นครศรีธรรมราช</option>
                                <option value="chiangmai">เชียงใหม่</option>
                                <option value="nan">น่าน</option>
                            </select> -->
                            <label for="subject">เรื่อง</label>
                            <textarea class="form-control" id="subject" name="subject"
                                placeholder="กรุณาระบุเรื่องที่ต้องการจะติดต่อ..." style="height:170px"></textarea>
                            <input class="btn btn-success" type="submit" value="ส่ง">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- ADMIN -->
        <div class="tab-pane" role="tabpanel" id="list_role">
            <div class="table">
                <table id="table" data-toggle="table" data-pagination="true" data-page-size="10"
                    data-page-list="[10, 50, 100, 200, ALL]" data-url="data.php?page=list_role" data-method="post"
                    data-query-params="searchQueryParams">
                    <thead class="thead-light">
                        <tr>
                            <th data-field="list_role" data-align="center" data-width="25" data-width-unit="%">
                                <div class="th-inner">สิทธิ์</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="list_permission" data-align="center" data-width="60" data-width-unit="%">
                                <div class="th-inner ">การเข้าถึง</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="action" data-align="center" data-width="15" data-width-unit="%">
                                <div class="th-inner ">จัดการการเข้าถึง</div>
                                <div class="fht-cell"></div>
                            </th>
                            <!-- Modal Role -->
                            <?php require'roleModal.php'; ?>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="tab-pane" role="tabpanel" id="list_teacher">
            <div class="table">
                <table id="table" data-toggle="table" data-pagination="true" data-page-size="10"
                    data-page-list="[10, 50, 100, 200, ALL]" data-url="data.php?page=list_teacher" data-method="post"
                    data-query-params="searchQueryParams">
                    <thead class="thead-light">
                        <tr>
                            <th data-field="list_teacher_id" data-align="center" data-width="20" data-width-unit="%">
                                <div class="th-inner">รหัสประจำตัวผู้สอน</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="list_teacher_name" data-align="center" data-width="60" data-width-unit="%">
                                <div class="th-inner">ชื่อ - นามสกุล</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="action" data-align="center" data-width="20" data-width-unit="%">
                                <div class="th-inner ">การจัดการ</div>
                                <div class="fht-cell"></div>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="tab-pane" role="tabpanel" id="list_student">
            <div class="table">
                <table id="table" data-toggle="table" data-pagination="true" data-page-size="10"
                    data-page-list="[10, 50, 100, 200, ALL]" data-url="data.php?page=list_student" data-method="post"
                    data-query-params="searchQueryParams">
                    <thead class="thead-light">
                        <tr>
                            <th data-field="list_student_id" data-align="center" data-width="20" data-width-unit="%">
                                <div class="th-inner">รหัสประจำตัวนักเรียน</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="list_student_name" data-align="center" data-width="60" data-width-unit="%">
                                <div class="th-inner">ชื่อ - นามสกุล</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="action" data-align="center" data-width="20" data-width-unit="%">
                                <div class="th-inner ">การจัดการ</div>
                                <div class="fht-cell"></div>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="tab-pane" role="tabpanel" id="list_parent">
            <div class="table">
                <table id="table" data-toggle="table" data-pagination="true" data-page-size="10"
                    data-page-list="[10, 50, 100, 200, ALL]" data-url="data.php?page=list_parent" data-method="post"
                    data-query-params="searchQueryParams">
                    <thead class="thead-light">
                        <tr>
                            <th data-field="list_student_id" data-align="center" data-width="20" data-width-unit="%">
                                <div class="th-inner">รหัสประจำตัวนักเรียน</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="list_student_name" data-align="center" data-width="60" data-width-unit="%">
                                <div class="th-inner">ชื่อ - นามสกุล</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="action" data-align="center" data-width="20" data-width-unit="%">
                                <div class="th-inner ">การจัดการ</div>
                                <div class="fht-cell"></div>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <!-- Modal List -->
        <?php require'listModal.php'; ?>
        <!-- Modal List Log -->
        <?php require'listlogModal.php'; ?>

        <div class="tab-pane" role="tabpanel" id="status_teacher">
            <div class="table">
                <table id="table" data-toggle="table" data-pagination="true" data-page-size="10"
                    data-page-list="[10, 50, 100, 200, ALL]" data-url="data.php?page=status_teacher" data-method="post"
                    data-query-params="searchQueryParams">
                    <thead class="thead-light">
                        <tr>
                            <th data-field="status_teacher_id" data-align="center" data-width="20" data-width-unit="%">
                                <div class="th-inner">รหัสประจำตัวผู้สอน</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="status_teacher_name" data-align="center" data-width=60" data-width-unit="%">
                                <div class="th-inner">ชื่อ - นามสกุล</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="time_teacher" data-align="center" data-width="20" data-width-unit="%">
                                <div class="th-inner ">ใช้งานล่าสุด</div>
                                <div class="fht-cell"></div>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="tab-pane" role="tabpanel" id="status_student">
            <div class="table">
                <table id="table" data-toggle="table" data-pagination="true" data-page-size="10"
                    data-page-list="[10, 50, 100, 200, ALL]" data-url="data.php?page=status_student" data-method="post"
                    data-query-params="searchQueryParams">
                    <thead class="thead-light">
                        <tr>
                            <th data-field="status_student_id" data-align="center" data-width="20" data-width-unit="%">
                                <div class="th-inner">รหัสประจำตัวนักเรียน</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="status_student_name" data-align="center" data-width="60" data-width-unit="%">
                                <div class="th-inner">ชื่อ - นามสกุล</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="time_student" data-align="center" data-width="20" data-width-unit="%">
                                <div class="th-inner ">ใช้งานล่าสุด</div>
                                <div class="fht-cell"></div>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="tab-pane" role="tabpanel" id="status_parent">
            <div class="table">
                <table id="table" data-toggle="table" data-pagination="true" data-page-size="10"
                    data-page-list="[10, 50, 100, 200, ALL]" data-url="data.php?page=status_parent" data-method="post"
                    data-query-params="searchQueryParams">
                    <thead class="thead-light">
                        <tr>
                            <th data-field="status_parent_id" data-align="center" data-width="20" data-width-unit="%">
                                <div class="th-inner">รหัสประจำตัวนักเรียน</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="status_parent_name" data-align="center" data-width="60" data-width-unit="%">
                                <div class="th-inner">ชื่อ - นามสกุล</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="time_parent" data-align="center" data-width="20" data-width-unit="%">
                                <div class="th-inner ">ใช้งานล่าสุด</div>
                                <div class="fht-cell"></div>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="tab-pane" role="tabpanel" id="course">
            <div class="table">
                <table id="table" data-toggle="table" data-pagination="true" data-page-size="10"
                    data-page-list="[10, 50, 100, 200, ALL]" data-url="data.php?page=course" data-method="post"
                    data-query-params="searchQueryParams">
                    <thead class="thead-light">
                        <tr>
                            <th data-field="course_id" data-align="center" data-width="10" data-width-unit="%">
                                <div class="th-inner">รหัสวิชา</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="course_name" data-align="center" data-width="35" data-width-unit="%">
                                <div class="th-inner">ชื่อวิชา</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="course_credit" data-align="center" data-width="10" data-width-unit="%">
                                <div class="th-inner">หน่วยกิต</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="course_teacher" data-align="center" data-width="25" data-width-unit="%">
                                <div class="th-inner">ผู้สอน</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="action" data-align="center" data-width="20" data-width-unit="%">
                                <div class="th-inner ">การจัดการ</div>
                                <div class="fht-cell"></div>
                            </th>
                            <!-- Modal Course -->
                            <?php require'courseModal.php'; ?>
                            <!-- Modal Course Log -->
                            <?php require'courselogModal.php'; ?>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="tab-pane" role="tabpanel" id="petition">
            <h5 style="font-weight: bold;">คำร้องขอเพิ่ม / ถอนรายวิชา</h5>
            <div class="table">
                <table id="table" data-toggle="table" data-pagination="true" data-page-size="5"
                    data-page-list="[5, 10, 50, 100, 200, ALL]" data-url="data.php?page=petition_course_list" data-method="post"
                    data-query-params="searchQueryParams">
                    <thead class="thead-light">
                        <tr>
                            <th data-field="course_id" data-align="center" data-width="10" data-width-unit="%">
                                <div class="th-inner">รหัสวิชา</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="course_name" data-align="center" data-width="25" data-width-unit="%">
                                <div class="th-inner">ชื่อวิชา</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="course_credit" data-align="center" data-width="5" data-width-unit="%">
                                <div class="th-inner">หน่วยกิต</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="student_id" data-align="center" data-width="10" data-width-unit="%">
                                <div class="th-inner">รหัสประจำตัวนักเรียน</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="student_name" data-align="center" data-width="20" data-width-unit="%">
                                <div class="th-inner">ชื่อ - นามสกุล</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="send_at" data-align="center" data-width="15" data-width-unit="%">
                                <div class="th-inner">วันที่ส่งคำร้อง</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="action" data-align="center" data-width="15" data-width-unit="%">
                                <div class="th-inner ">การจัดการ</div>
                                <div class="fht-cell"></div>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
            <br>
            <h5 style="font-weight: bold;">คำร้องขอตัดเกรด</h5>
            <div class="table">
                <table id="table" data-toggle="table" data-pagination="true" data-page-size="5"
                    data-page-list="[5, 10, 50, 100, 200, ALL]" data-url="data.php?page=petition_grade_list" data-method="post"
                    data-query-params="searchQueryParams">
                    <thead class="thead-light">
                        <tr>
                            <th data-field="course_id" data-align="center" data-width="10" data-width-unit="%">
                                <div class="th-inner">รหัสวิชา</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="course_name" data-align="center" data-width="25" data-width-unit="%">
                                <div class="th-inner">ชื่อวิชา</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="course_credit" data-align="center" data-width="5" data-width-unit="%">
                                <div class="th-inner">หน่วยกิต</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="teacher_id" data-align="center" data-width="10" data-width-unit="%">
                                <div class="th-inner">รหัสประจำตัวผู้สอน</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="teacher_name" data-align="center" data-width="20" data-width-unit="%">
                                <div class="th-inner">ผู้สอน</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="send_at" data-align="center" data-width="15" data-width-unit="%">
                                <div class="th-inner">วันที่ส่งคำร้อง</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="action" data-align="center" data-width="15" data-width-unit="%">
                                <div class="th-inner ">การจัดการ</div>
                                <div class="fht-cell"></div>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- ADMIN -->

        <!-- TEACHER -->
        <div class="tab-pane" role="tabpanel" id="teacher_course">
            <div class="table">
                <table id="table" data-toggle="table" data-pagination="true" data-page-size="10"
                    data-page-list="[10, 50, 100, 200, ALL]" data-url="data.php?page=teacher_course" data-method="post"
                    data-query-params="searchQueryParams">
                    <thead class="thead-light">
                        <tr>
                            <th data-field="course_id" data-align="center" data-width="20" data-width-unit="%">
                                <div class="th-inner">รหัสวิชา</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="course_name" data-align="center" data-width="80" data-width-unit="%">
                                <div class="th-inner">ชื่อวิชา</div>
                                <div class="fht-cell"></div>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="tab-pane" role="tabpanel" id="petition_grade">
            <div class="table">
                <table id="table" data-toggle="table" data-pagination="true" data-page-size="10"
                    data-page-list="[10, 50, 100, 200, ALL]" data-url="data.php?page=petition_grade" data-method="post"
                    data-query-params="searchQueryParams">
                    <thead class="thead-light">
                        <tr>
                            <th data-field="course_id" data-align="center" data-width="20" data-width-unit="%">
                                <div class="th-inner">รหัสวิชา</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="course_name" data-align="center" data-width="60" data-width-unit="%">
                                <div class="th-inner">ชื่อวิชา</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="action" data-align="center" data-width="20" data-width-unit="%">
                                <div class="th-inner">การจัดการ</div>
                                <div class="fht-cell"></div>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="tab-pane" role="tabpanel" id="petition_grade_student">
            <input type="hidden" id="input_grade_student" name="input_grade_student">
            <input type="hidden" id="input_petition_grade_student" name="input_petition_grade_student">
            <div class="table">
                <table id="table" class="table_grade_student" data-toggle="table" data-pagination="true" data-page-size="10"
                    data-page-list="[10, 50, 100, 200, ALL]" data-url="data.php?page=petition_grade_student" data-method="post"
                    data-query-params="searchQueryParams">
                    <thead class="thead-light">
                        <tr>
                            <th data-field="student_id" data-align="center" data-width="20" data-width-unit="%">
                                <div class="th-inner">รหัสประจำตัวนักเรียน</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="student_name" data-align="center" data-width="60" data-width-unit="%">
                                <div class="th-inner">ชื่อ - นามสกุล</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="action" data-align="center" data-width="20" data-width-unit="%">
                                <div class="th-inner ">คะแนน</div>
                                <div class="fht-cell"></div>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- TEACHER -->

        <!-- STUDENT & PARENT --> 
        <div class="tab-pane" role="tabpanel" id="student_course">
            <div class="table">
                <table id="table" data-toggle="table" data-pagination="true" data-page-size="10"
                    data-page-list="[10, 50, 100, 200, ALL]" data-url="data.php?page=student_course" data-method="post"
                    data-query-params="searchQueryParams">
                    <thead class="thead-light">
                        <tr>
                            <th data-field="course_id" data-align="center" data-width="20" data-width-unit="%">
                                <div class="th-inner">รหัสวิชา</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="course_name" data-align="center" data-width="80" data-width-unit="%">
                                <div class="th-inner">ชื่อวิชา</div>
                                <div class="fht-cell"></div>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="tab-pane" role="tabpanel" id="grade">
            <div class="table">
                <table id="table" data-toggle="table" data-pagination="true" data-page-size="10"
                    data-page-list="[10, 50, 100, 200, ALL]" data-url="data.php?page=grade" data-method="post"
                    data-query-params="searchQueryParams">
                    <thead class="thead-light">
                        <tr>
                            <th data-field="course_id" data-align="center" data-width="20" data-width-unit="%">
                                <div class="th-inner">รหัสวิชา</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="course_name" data-align="center" data-width="35" data-width-unit="%">
                                <div class="th-inner">ชื่อวิชา</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="teacher" data-align="center" data-width="20" data-width-unit="%">
                                <div class="th-inner">ผู้สอน</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="credit" data-align="center" data-width="10" data-width-unit="%">
                                <div class="th-inner">หน่วยกิต</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="grade" data-align="center" data-width="15" data-width-unit="%">
                                <div class="th-inner">ผลการเรียน</div>
                                <div class="fht-cell"></div>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- STUDENT & PARENT -->

        <!-- STUDENT -->
        <div class="tab-pane" role="tabpanel" id="petition_course">
            <div class="table">
                <table id="table" data-toggle="table" data-pagination="true" data-page-size="10"
                    data-page-list="[10, 50, 100, 200, ALL]" data-url="data.php?page=petition_course" data-method="post"
                    data-query-params="searchQueryParams">
                    <thead class="thead-light">
                        <tr>
                            <th data-field="course_id" data-align="center" data-width="15" data-width-unit="%">
                                <div class="th-inner">รหัสวิชา</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="course_name" data-align="center" data-width="25" data-width-unit="%">
                                <div class="th-inner">ชื่อวิชา</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="course_credit" data-align="center" data-width="5" data-width-unit="%">
                                <div class="th-inner">หน่วยกิต</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="send_at" data-align="center" data-width="15" data-width-unit="%">
                                <div class="th-inner">วันที่ส่งคำร้อง</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="status" data-align="center" data-width="15" data-width-unit="%">
                                <div class="th-inner">สถานะ</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="check_at" data-align="center" data-width="15" data-width-unit="%">
                                <div class="th-inner">วันที่ตรวจคำร้อง</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th data-field="action" data-align="center" data-width="10" data-width-unit="%">
                                <div class="th-inner ">การจัดการ</div>
                                <div class="fht-cell"></div>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- STUDENT -->
    </div>
    <!--Container Main end-->
</body>

<script type="text/javascript" src="js/script.js"></script>

</html>