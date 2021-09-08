<?php 

    session_start();

    if(isset($_SESSION['name'])) {
        header('location: index.php');
    }

    if(isset($_GET['email'])) {
        $email = $_GET['email'];
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

<body class="bodylogin" style="height: 100% !important;">
    <input type="hidden" id="input_email" name="input_email" value="<?php echo $email; ?>">
</body>

<script>
$(function() {
    $.ajax({
        url: "manage_verify.php?method=verify_users",
        method: "post",
        data: {
            email: $('#input_email').val()
        },
        // beforeSend: function() {
        //     Swal.fire({
        //         title: 'กำลังยืนยันอีเมล',
        //         allowEscapeKey: false,
        //         allowOutsideClick: false,
        //         didOpen: () => {
        //             Swal.showLoading()
        //         },
        //     })
        // },
        success: function(response) {
            console.log(response);
            // Swal.close();
            if(response == "success") {
                Swal.fire({
                    title: 'ยืนยันอีเมลสำเร็จ',
                    icon: 'success',
                    confirmButtonColor: '#27AE60',
                    confirmButtonText: 'เข้าสู่หน้าหลัก'
                }).then((result) => {
                    location.href = 'index.php';
                })
            } else if (response == "confirmed") {
                Swal.fire({
                    title: 'มีการยืนยันอีเมลแล้ว',
                    icon: 'warning',
                    confirmButtonColor: '#F5B041',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    location.href = 'login.php';
                })
            } else if (response == "fail") {
                Swal.fire({
                    title: 'ไม่สามารถยืนยันได้',
                    icon: 'error',
                    confirmButtonColor: '#FF2557',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    location.href = 'login.php';
                })
            }
        },
    })
});
</script>
</html>