<?php 

    session_start();

    if(isset($_SESSION['token'])) {
        header('location: index.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>

    <!-- CSS -->
    <link rel='stylesheet' type='text/css' href='css/main.css'>

</head>

<body class="bodylogin">
    <section class="container framelogin">
        <div class="row">
            <div class="col-md-5" style="margin: auto; text-align: center;">
                <img src="images/login.png" alt="LOGIN" style="width: 60%;">
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-6">
                <div class="text-center text-primary" style="font-size: 40px; font-weight: bold;">เข้าสู่ระบบ</div>
                <form method="post" novalidate>
                    <div class="container form-group">
                        
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </symbol>
                        </svg>
                        <?php if(isset($_SESSION['chklogin'])) : ?>
                        <div class="alert alert-warning align-items-center justify-content-center mb-1" role="alert" style="display: flex;">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
                                <use xlink:href="#exclamation-triangle-fill" />
                            </svg>
                            <div>
                                <?php
                                        echo $_SESSION['chklogin'];
                                        unset($_SESSION['chklogin']);
                                    ?>
                            </div>
                        </div>
                        <?php endif ?>

                        <div class="alert alert-danger align-items-center justify-content-center mb-1" role="alert" style="display: none;">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                                <use xlink:href="#exclamation-triangle-fill" />
                            </svg>
                            <div class="error"></div>
                        </div>

                        <label for="Email" style="font-size: 20px;">อีเมล</label>
                        <input type="email" class="form-control" name="email" autocomplete="off"
                            placeholder="กรุณาใส่อีเมล" required>
                        <div class="invalid" name="invalid-email">
                            กรุณาใส่อีเมลให้ถูกต้องตามรูปแบบ ดังนี้
                            <ul>
                                <li>อีเมลต้องไม่มีตัวอักษรพิเศษ<br>! # $ % & ' * + - / = ? ^ ' | { } [ ] ( ) ~</li>
                                <li>อีเมลต้องเป็นตัวอักษรภาษาอังกฤษหรือตัวเลขเท่านั้น A-Z a-z 0-9</li>
                                <li>ห้ามใส่ . ติดกันในอีเมล</li>
                                <li>ต้องมี @ ในอีเมล</li>
                            </ul>
                        </div>

                        <label for="Password" style="font-size: 20px; margin-top: 5%;">รหัสผ่าน</label>
                        <input type="password" class="form-control" placeholder="กรุณาใส่รหัสผ่าน" name="password"
                            autocomplete="off" required>
                        <div class="invalid" name="invalid-password">
                            กรุณาใส่รหัสผ่านให้ถูกต้องตามรูปแบบ ดังนี้
                            <ul>
                                <li>รหัสผ่านต้องมีความยาว 8 - 15 ตัวอักษร</li>
                                <li>รหัสผ่านต้องขึ้นต้นด้วยตัวอักษรภาษาอังกฤษพิมพ์ใหญ่ A-Z</li>
                                <li>รหัสผ่านต้องเป็นตัวอักษรภาษาอังกฤษหรือตัวเลขเท่านั้น a-z 0-9</li>
                                <li>รหัสผ่านต้องไม่มีตัวอักษรพิเศษ<br>! # $ % & ' * + - / = ? ^ ' | { } [ ] ( ) ~</li>
                            </ul>
                        </div>
                        <button type="submit" class="btn btn-success btnlogin" name="btnlogin">เข้าสู่ระบบ</button>
                    </div>

                    <div class="container text-center">
                        <a href="register.php" style="font-size: 18px;">ลงทะเบียนสำหรับบัญชีใหม่</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>

<script>

function validateEmail(email) {
    const re =
        /^(([^!#\$%&'*+/=?\^\|~<>(){}[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

$("input[name='email']").keyup(function() {
    if (validateEmail($("input[name='email']").val())) {
        $("input[name='email']").prop('classList').remove('is-invalid')
        $("input[name='email']").prop('classList').add('is-valid')
        $("div[name='invalid-email']").prop('classList').remove('d-block')
    } else {
        $("input[name='email']").prop('classList').remove('is-valid')
        $("input[name='email']").prop('classList').add('is-invalid')
        $("div[name='invalid-email']").prop('classList').add('d-block')
    }
});

function validatePassword(pw) {
    // const re_pw = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{7,15}$/;
    const re_pw = /^[A-Z][a-zA-Z0-9]{7,14}$/;
    return re_pw.test(pw);
}

$("input[name='password']").keyup(function() {
    if (validatePassword($("input[name='password']").val())) {
        $("input[name='password']").prop('classList').remove('is-invalid')
        $("input[name='password']").prop('classList').add('is-valid')
        $("div[name='invalid-password']").prop('classList').remove('d-block')
    } else {
        $("input[name='password']").prop('classList').remove('is-valid')
        $("input[name='password']").prop('classList').add('is-invalid')
        $("div[name='invalid-password']").prop('classList').add('d-block')
    }
});

$("form").submit(function() {
    // console.log("Login")

    if ($("input[name='email']").val() == "" && $("input[name='password']").val() == "") {

        $("input[name='email']").prop('classList').add('is-invalid')
        $("div[name='invalid-email']").prop('classList').add('d-block')

        $("input[name='password']").prop('classList').add('is-invalid')
        $("div[name='invalid-password']").prop('classList').add('d-block')

        event.preventDefault();
    } else if ($("input[name='email']").attr('class').includes('is-invalid')) {
        $("input[name='email']").focus();
        event.preventDefault();
    } else if ($("input[name='password']").attr('class').includes('is-invalid')) {
        $("input[name='password']").focus();
        event.preventDefault();
    } else {
        event.preventDefault();
        $.ajax({
            url: "login_db.php",
            method: "post",
            data: {
                email: $("input[name='email']").val(),
                password: $("input[name='password']").val(),
            },
            success: function(response) {
                // console.log(response);
                if(response == "success") {
                    location.href = 'index.php';
                    // $.ajax({
                    //     url: "manage_token.php?method=save_token",
                    //     type: "post",
                    //     data: {
                    //         action : "get_token",
                    //     },//ส่งข้อมูล user และกำหนด action เป็น get_token
                    //     success:function(response) {
                    //         //เก็บ token ไว้ในตัวแปร token
                    //         token=response.trim();
                    //         //แสดง token <div id="server_response"></div>
                    //         $("#server_response").html("<b>Token:</b>"+token);
                    //     }
                    // });
                } else {
                    $(".alert-warning").css("display","none");
                    $(".alert-danger").css("display","flex");
                    $(".error").html(response);
                }
            }
        })
    }
});

</script>

</html>