<?php 

    session_start();

    if(isset($_SESSION['name'])) {
        header('location: index.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>

    <!-- SweetAlert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- CSS -->
    <link rel='stylesheet' type='text/css' href='css/main.css'>

</head>
<body class="bodyregister">
    <div class="container frameregister">
        <div class="row">
            <div class="text-center text-primary" style="font-size: 40px; font-weight: bold;">ลงทะเบียน</div>
        </div>

        <br>
        <div class="row menuregister" style="padding-left: 3%; padding-right: 3%;">
            <ul class="nav nav-pills nav-fill" id="type" role="tablist" style="padding-left: inherit;" onclick="clicktab();">
                <li class="nav-item" role="presentation" style="text-align: center; width: 33.33%;">
                    <a class="nav-link btn btn-lg btn-default" role="tab" data-bs-toggle="pill" data-bs-target="#teacher">ครู</a>
                </li>
                <li class="nav-item" role="presentation" style="text-align: center; width: 33.33%;">
                    <a class="nav-link btn btn-lg btn-default" role="tab" data-bs-toggle="pill" data-bs-target="#student">นักเรียน</a>
                </li>
                <li class="nav-item" role="presentation" style="text-align: center; width: 33.34%;">
                    <a class="nav-link btn btn-lg btn-default" role="tab" data-bs-toggle="pill" data-bs-target="#parent">ผู้ปกครอง</a>
                </li>
            </ul>
            <div class="tab-content tabregister">
                <div id="teacher" class="tab-pane" role="tabpanel">
                    <form method="post" class="form-group needs-validation" novalidate>

                        <!-- Alert -->
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                            </symbol>
                        </svg>
                        <div class="alert alert-danger align-items-center justify-content-center mb-1" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                            <div class="error"></div>
                        </div>
                        <!-- Alert -->

                        <input type="hidden" name="role_id" value="2">
                        <input type="hidden" name="role_name" value="TEACHER">

                        <label for="Teacher-ID">รหัสประจำตัวผู้สอน:</label>
                        <input type="text" class="form-control" name="userid" placeholder="ตัวอย่าง: 0000000000000" autocomplete="off" required>
                        <div class="invalid" name="invalid-userid">
                            กรุณาใส่รหัสประจำตัวครูเป็นตัวเลข 13 หลัก
                        </div>

                        <label for="Name">ชื่อ - นามสกุล:</label>
                        <input type="text" class="form-control" name="name" placeholder="ตัวอย่าง: สอนดี มีชัย" autocomplete="off" required>
                        <div class="invalid" name="invalid-name">
                            กรุณาใส่ชื่อ - นามสกุล เป็นตัวอักษรภาษาไทยหรือภาษาอังกฤษ
                        </div>

                        <label for="Email">ที่อยู่อีเมล:</label>
                        <input type="email" class="form-control" name="email" placeholder="ตัวอย่าง: email@example.com" autocomplete="off" required>
                        <div class="invalid" name="invalid-email">
                            กรุณาใส่อีเมลให้ถูกต้องตามรูปแบบ ดังนี้
                            <ul>
                                <li>อีเมลต้องไม่มีตัวอักษรพิเศษ<br>! # $ % & ' * + - / = ? ^ ' | { } [ ] ( ) ~</li>
                                <li>อีเมลต้องเป็นตัวอักษรภาษาอังกฤษหรือตัวเลขเท่านั้น A-Z a-z 0-9</li>
                                <li>ห้ามใส่ . ติดกันในอีเมล</li>
                                <li>ต้องมี @ ในอีเมล</li>
                            </ul>
                        </div>

                        <label for="Password">รหัสผ่าน:</label>
                        <input type="password" class="form-control" name="password" placeholder="ตัวอย่าง: secretpw" autocomplete="off" required>
                        <div class="invalid" name="invalid-password">
                            กรุณาใส่รหัสผ่านให้ถูกต้องตามรูปแบบ ดังนี้
                            <ul>
                                <li>รหัสผ่านต้องมีความยาว 8 - 15 ตัวอักษร</li>
                                <li>รหัสผ่านต้องขึ้นต้นด้วยตัวอักษรภาษาอังกฤษพิมพ์ใหญ่ A-Z</li>
                                <li>รหัสผ่านต้องเป็นตัวอักษรภาษาอังกฤษหรือตัวเลขเท่านั้น a-z 0-9</li>
                                <li>รหัสผ่านต้องไม่มีตัวอักษรพิเศษ<br>! # $ % & ' * + - / = ? ^ ' | { } [ ] ( ) ~</li>
                            </ul>
                        </div>

                        <label for="Password">ยืนยันรหัสผ่าน:</label>
                        <input type="password" class="form-control" name="checkpassword" placeholder="ตัวอย่าง: secretpw" autocomplete="off" required>
                        <div class="invalid" name="invalid-checkpassword">
                            กรุณายืนยันรหัสผ่าน
                        </div>

                        <br><br>
                        <button type="button" class="btn btn-danger btncancle">ยกเลิก</button>
                        <button type="submit" class="btn btn-success btnsubmit" name="btnregister">ลงทะเบียน</button>
                    </form>
                </div>
                <div id="student" class="tab-pane" role="tabpanel">
                    <form method="post" class="form-group needs-validation" novalidate>
                        <!-- Alert -->
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                            </symbol>
                        </svg>
                        <div class="alert alert-danger align-items-center justify-content-center mb-1" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                            <div class="error"></div>
                        </div>
                        <!-- Alert -->

                        <input type="hidden" name="role_id" value="3">
                        <input type="hidden" name="role_name" value="STUDENT">

                        <label for="Student-ID">รหัสประจำตัวนักเรียน:</label>
                        <input type="text" class="form-control" name="userid" placeholder="ตัวอย่าง: 0000000000000" autocomplete="off" required>
                        <div class="invalid" name="invalid-userid">
                            กรุณาใส่รหัสประจำตัวนักเรียนเป็นตัวเลข 13 หลัก
                        </div>

                        <label for="Name">ชื่อ - นามสกุล:</label>
                        <input type="text" class="form-control" name="name" placeholder="ตัวอย่าง: สอนดี มีชัย" autocomplete="off" required>
                        <div class="invalid" name="invalid-name">
                            กรุณาใส่ชื่อ - นามสกุล เป็นตัวอักษรภาษาไทยหรือภาษาอังกฤษ
                        </div>

                        <label for="Email">ที่อยู่อีเมล:</label>
                        <input type="email" class="form-control" name="email" placeholder="ตัวอย่าง: email@example.com" autocomplete="off" required>
                        <div class="invalid" name="invalid-email">
                            กรุณาใส่อีเมลให้ถูกต้องตามรูปแบบ ดังนี้
                            <ul>
                                <li>อีเมลต้องไม่มีตัวอักษรพิเศษ<br>! # $ % & ' * + - / = ? ^ ' | { } [ ] ( ) ~</li>
                                <li>อีเมลต้องเป็นตัวอักษรภาษาอังกฤษหรือตัวเลขเท่านั้น A-Z a-z 0-9</li>
                                <li>ห้ามใส่ . ติดกันในอีเมล</li>
                                <li>ต้องมี @ ในอีเมล</li>
                            </ul>
                        </div>

                        <label for="Password">รหัสผ่าน:</label>
                        <input type="password" class="form-control" name="password" placeholder="ตัวอย่าง: secretpw" autocomplete="off" required>
                        <div class="invalid" name="invalid-password">
                            กรุณาใส่รหัสผ่านให้ถูกต้องตามรูปแบบ ดังนี้
                            <ul>
                                <li>รหัสผ่านต้องมีความยาว 8 - 15 ตัวอักษร</li>
                                <li>รหัสผ่านต้องขึ้นต้นด้วยตัวอักษรภาษาอังกฤษพิมพ์ใหญ่ A-Z</li>
                                <li>รหัสผ่านต้องเป็นตัวอักษรภาษาอังกฤษหรือตัวเลขเท่านั้น a-z 0-9</li>
                                <li>รหัสผ่านต้องไม่มีตัวอักษรพิเศษ<br>! # $ % & ' * + - / = ? ^ ' | { } [ ] ( ) ~</li>
                            </ul>
                        </div>

                        <label for="Password">ยืนยันรหัสผ่าน:</label>
                        <input type="password" class="form-control" name="checkpassword" placeholder="ตัวอย่าง: secretpw" autocomplete="off" required>
                        <div class="invalid" name="invalid-checkpassword">
                            กรุณายืนยันรหัสผ่าน
                        </div>

                        <br><br>
                        <button type="button" class="btn btn-danger btncancle">ยกเลิก</button>
                        <button type="submit" class="btn btn-success btnsubmit" name="btnregister">ลงทะเบียน</button>
                    </form>
                </div>
                <div id="parent" class="tab-pane" role="tabpanel">
                    <form method="post" class="form-group needs-validation" novalidate>
                        <!-- Alert -->
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                            </symbol>
                        </svg>
                        <div class="alert alert-danger align-items-center justify-content-center mb-1" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                            <div class="error"></div>
                        </div>
                        <!-- Alert -->

                        <input type="hidden" name="role_id" value="4">
                        <input type="hidden" name="role_name" value="PARENT">

                        <label for="Student-ID">รหัสประจำตัวนักเรียน:</label>
                        <input type="text" class="form-control" name="userid" placeholder="ตัวอย่าง: 0000000000000" autocomplete="off" required>
                        <div class="invalid" name="invalid-userid">
                            กรุณาใส่รหัสประจำตัวนักเรียนเป็นตัวเลข 13 หลัก
                        </div>

                        <label for="Name">ชื่อ - นามสกุล:</label>
                        <input type="text" class="form-control" name="name" placeholder="ตัวอย่าง: สอนดี มีชัย" autocomplete="off" required>
                        <div class="invalid" name="invalid-name">
                            กรุณาใส่ชื่อ - นามสกุล เป็นตัวอักษรภาษาไทยหรือภาษาอังกฤษ
                        </div>

                        <label for="Email">ที่อยู่อีเมล:</label>
                        <input type="email" class="form-control" name="email" placeholder="ตัวอย่าง: email@example.com" autocomplete="off" required>
                        <div class="invalid" name="invalid-email">
                            กรุณาใส่อีเมลให้ถูกต้องตามรูปแบบ ดังนี้
                            <ul>
                                <li>อีเมลต้องไม่มีตัวอักษรพิเศษ<br>! # $ % & ' * + - / = ? ^ ' | { } [ ] ( ) ~</li>
                                <li>อีเมลต้องเป็นตัวอักษรภาษาอังกฤษหรือตัวเลขเท่านั้น A-Z a-z 0-9</li>
                                <li>ห้ามใส่ . ติดกันในอีเมล</li>
                                <li>ต้องมี @ ในอีเมล</li>
                            </ul>
                        </div>

                        <label for="Password">รหัสผ่าน:</label>
                        <input type="password" class="form-control" name="password" placeholder="ตัวอย่าง: secretpw" autocomplete="off" required>
                        <div class="invalid" name="invalid-password">
                            กรุณาใส่รหัสผ่านให้ถูกต้องตามรูปแบบ ดังนี้
                            <ul>
                                <li>รหัสผ่านต้องมีความยาว 8 - 15 ตัวอักษร</li>
                                <li>รหัสผ่านต้องขึ้นต้นด้วยตัวอักษรภาษาอังกฤษพิมพ์ใหญ่ A-Z</li>
                                <li>รหัสผ่านต้องเป็นตัวอักษรภาษาอังกฤษหรือตัวเลขเท่านั้น a-z 0-9</li>
                                <li>รหัสผ่านต้องไม่มีตัวอักษรพิเศษ<br>! # $ % & ' * + - / = ? ^ ' | { } [ ] ( ) ~</li>
                            </ul>
                        </div>

                        <label for="Password">ยืนยันรหัสผ่าน:</label>
                        <input type="password" class="form-control" name="checkpassword" placeholder="ตัวอย่าง: secretpw" autocomplete="off" required>
                        <div class="invalid" name="invalid-checkpassword">
                            กรุณายืนยันรหัสผ่าน
                        </div>

                        <br><br>
                        <button type="button" class="btn btn-danger btncancle">ยกเลิก</button>
                        <button type="submit" class="btn btn-success btnsubmit" name="btnregister">ลงทะเบียน</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<script>

    // $( document ).ready(function() {
    //     console.log("ready!");
    //     // document.querySelector('a[data-bs-toggle="pill"]').click();
    // });

    function clicktab() {
        // console.log("Click Tab")
        const observer = new ResizeObserver(entries => {
            for (const entry of entries) {
                $('HTML').height(entry.contentRect.height+50);
            }
        })
        observer.observe(document.querySelector('body'))

        $('.alert').css("display","none");

        const form = $('.tab-pane.active').find("form")

        const userid = $('.tab-pane.active').find("input[name='userid']");
        const name = $('.tab-pane.active').find("input[name='name']");
        const email = $('.tab-pane.active').find("input[name='email']");
        const password = $('.tab-pane.active').find("input[name='password']");
        const checkpassword = $('.tab-pane.active').find("input[name='checkpassword']");

        const invalid_userid = $('.tab-pane.active').find("div[name='invalid-userid']");
        const invalid_name = $('.tab-pane.active').find("div[name='invalid-name']");
        const invalid_email = $('.tab-pane.active').find("div[name='invalid-email']");
        const invalid_password = $('.tab-pane.active').find("div[name='invalid-password']");
        const invalid_checkpassword = $('.tab-pane.active').find("div[name='invalid-checkpassword']");

        function validateUserID(userid) {
            const re_userid = /\d{13}$/;
            return re_userid.test(userid);
        }

        userid.keyup(function() {
            if(validateUserID(userid.val()) && userid.val().length <= 13) {
                userid.prop('classList').remove('is-invalid')
                userid.prop('classList').add('is-valid')
                invalid_userid.prop('classList').remove('d-block')
            } else if(userid.val().length > 13) {
                userid.prop('classList').remove('is-valid')
                userid.prop('classList').add('is-invalid')
                invalid_userid.prop('classList').add('d-block')
            } else {
                userid.prop('classList').remove('is-valid')
                userid.prop('classList').add('is-invalid')
                invalid_userid.prop('classList').add('d-block')
            }
        });

        function validateName(name) {
            const re_name = /[a-zA-zก-ฮ]{1,255}$/;
            return re_name.test(name);
        }

        name.keyup(function() {
            if(validateName(name.val())) {
                name.prop('classList').remove('is-invalid')
                name.prop('classList').add('is-valid')
                invalid_name.prop('classList').remove('d-block')
            } else {
                name.prop('classList').remove('is-valid')
                name.prop('classList').add('is-invalid')
                invalid_name.prop('classList').add('d-block')
            }
        });

        function validateEmail(email) {
            const re_email =
                /^(([^!#\$%&'*+/=?\^\|~<>(){}[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re_email.test(email);
        }

        email.keyup(function() {
            if (validateEmail(email.val())) {
                email.prop('classList').remove('is-invalid')
                email.prop('classList').add('is-valid')
                invalid_email.prop('classList').remove('d-block')
            } else {
                email.prop('classList').remove('is-valid')
                email.prop('classList').add('is-invalid')
                invalid_email.prop('classList').add('d-block')
            }
        });

        function validatePassword(pw) {
            const re_pw = /^[A-Z][a-zA-Z0-9]{7,14}$/;
            return re_pw.test(pw);
        }

        password.keyup(function() {
            if(validatePassword(password.val())) {
                password.prop('classList').remove('is-invalid')
                password.prop('classList').add('is-valid')
                invalid_password.prop('classList').remove('d-block')
            } else {
                password.prop('classList').remove('is-valid')
                password.prop('classList').add('is-invalid')
                invalid_password.prop('classList').add('d-block')
            }
        });

        checkpassword.keyup(function() {
            if(checkpassword.val() == "") {
                checkpassword.prop('classList').remove('is-valid')
                checkpassword.prop('classList').add('is-invalid')
                invalid_checkpassword.html("กรุณายืนยันรหัสผ่าน")
                invalid_checkpassword.prop('classList').add('d-block')
            }
            if(checkpassword.val() != "" && checkpassword.val() != password.val()) {
                checkpassword.prop('classList').remove('is-valid')
                checkpassword.prop('classList').add('is-invalid')
                invalid_checkpassword.html("รหัสผ่านไม่ตรงกัน")
                invalid_checkpassword.prop('classList').add('d-block')
            }
            if(checkpassword.val() != "" && checkpassword.val() == password.val()) {
                checkpassword.prop('classList').remove('is-invalid')
                checkpassword.prop('classList').add('is-valid')
                invalid_checkpassword.prop('classList').remove('d-block')
            }
        });
    }

    $("form").submit(function() {
        console.log("Register");

        const alert = $('.tab-pane.active').find(".alert");
        const error = $('.tab-pane.active').find(".error");

        const role_id = $('.tab-pane.active').find("input[name='role_id']");
        const role_name = $('.tab-pane.active').find("input[name='role_name']");
        const userid = $('.tab-pane.active').find("input[name='userid']");
        const name = $('.tab-pane.active').find("input[name='name']");
        const email = $('.tab-pane.active').find("input[name='email']");
        const password = $('.tab-pane.active').find("input[name='password']");
        const checkpassword = $('.tab-pane.active').find("input[name='checkpassword']");

        const invalid_userid = $('.tab-pane.active').find("div[name='invalid-userid']");
        const invalid_name = $('.tab-pane.active').find("div[name='invalid-name']");
        const invalid_email = $('.tab-pane.active').find("div[name='invalid-email']");
        const invalid_password = $('.tab-pane.active').find("div[name='invalid-password']");
        const invalid_checkpassword = $('.tab-pane.active').find("div[name='invalid-checkpassword']");

        if(userid.val() == "" && name.val() == "" && email.val() == "" && password.val() == "" && password.val() == "") {
            
            userid.prop('classList').add('is-invalid')
            invalid_userid.prop('classList').add('d-block')

            name.prop('classList').add('is-invalid')
            invalid_name.prop('classList').add('d-block')

            email.prop('classList').add('is-invalid')
            invalid_email.prop('classList').add('d-block')

            password.prop('classList').add('is-invalid')
            invalid_password.prop('classList').add('d-block')

            checkpassword.prop('classList').add('is-invalid')
            invalid_checkpassword.prop('classList').add('d-block')

            event.preventDefault();
        }
        else if(userid.attr('class').includes('is-invalid')) {
            userid.focus()
            event.preventDefault();
        }
        else if(name.attr('class').includes('is-invalid')) {
            name.focus()
            event.preventDefault();
        }
        else if(email.attr('class').includes('is-invalid')) {
            email.focus()
            event.preventDefault();
        }
        else if(password.attr('class').includes('is-invalid')) {
            password.focus()
            event.preventDefault();
        }
        else if(checkpassword.attr('class').includes('is-invalid')) {
            checkpassword.focus()
            event.preventDefault();
        }
        else {
            event.preventDefault();
            $.ajax({
                url: "register_db.php",
                method: "post",
                data: {
                    userid: userid.val(),
                    name: name.val(),
                    email: email.val(),
                    password: password.val(),
                    role_id: role_id.val(),
                    role_name: role_name.val()
                },
                beforeSend: function() {
                    alert.css("display","none");
                    Swal.fire({
                        title: 'กำลังส่งอีเมล',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                    })
                },
                success: function(response) {
                    // console.log(response);
                    Swal.close();
                    if(response == "success") {
                        Swal.fire({
                            title: 'ลงทะเบียนสำเร็จ',
                            text: "กรุณายืนยันอีเมลที่ใช้ลงทะเบียน",
                            icon: 'success',
                            confirmButtonColor: '#27AE60',
                            confirmButtonText: 'ตกลง'
                        }).then((result) => {
                            location.href = 'login.php';
                        })
                    } else {
                        alert.css("display","flex");
                        error.html(response);
                    }
                },
            })
        }
    });

    $('.btncancle').click(function() {
        location.href = 'login.php';
    });
</script>

</html>