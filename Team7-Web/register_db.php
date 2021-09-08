<?php
    include('PHPMailer.php');
    include('server.php');
    session_start();

    $userid = $_POST['userid'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role_id = $_POST['role_id'];
    $role_name = $_POST['role_name'];

    // print_r("userid: ".$userid." name: ".$name." email: ".$email." password: ".$password. " role_id: ".$role_id);
    // exit;

    $check = 'check';

    if($role_name == 'PARENT') {
        $check_student_query = "SELECT * FROM users WHERE userid = '$userid' AND role_id = '3'";
        $query = mysqli_query($connect, $check_student_query);

        if(mysqli_num_rows($query) != 0) {
            $check_email_query = "SELECT * FROM users WHERE email = '$email'";
            $query = mysqli_query($connect, $check_email_query);
            $result = mysqli_fetch_assoc($query);
            
            if($result) {
                if($result['email'] === $email) {
                    $_SESSION['error'] = "อีเมลนี้มีอยู่ในระบบแล้ว";
                    echo "อีเมลนี้มีอยู่ในระบบแล้ว";
                }
            } else {
                $check = 'success';
            }
        } else {
            $_SESSION['error'] = "ไม่มีรหัสประจำตัวนักเรียนนี้อยู่ในระบบ";
            echo "ไม่มีรหัสประจำตัวนักเรียนนี้อยู่ในระบบ";
        }
    } else {
        $check_query = "SELECT * FROM users WHERE userid = '$userid' OR email = '$email'";
        $query = mysqli_query($connect, $check_query);
        $result = mysqli_fetch_assoc($query);

        if($result) {
            if($result['userid'] === $userid) {
                $_SESSION['error'] = "รหัสประจำตัวนี้มีอยู่ในระบบแล้ว";
                echo "รหัสประจำตัวนี้มีอยู่ในระบบแล้ว";
            }
            if($result['email'] === $email) {
                $_SESSION['error'] = "อีเมลนี้มีอยู่ในระบบแล้ว";
                echo "อีเมลนี้มีอยู่ในระบบแล้ว";
            }
        } else {
            $check = 'success';
        }
    }

    if($check == 'success') {

        // Verification Email
        $to      = $email; // Send email to our user
        $subject = 'ยืนยันอีเมล'; // Give the email a subject 
        $message = '
        <div width="100%" bgcolor="#eeeeee" style="margin:0">
            <center style="width:100%;background:#eeeeee">
                <div style="max-width:600px;margin:auto">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width:600px">
                        <tbody>
                            <tr>
                                <td style="padding:20px 0;text-align:center;font-size: 18px;font-weight: bold;">
                                    Team7 - Infomation Security
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width:600px">
                        <tbody>
                            <tr>
                                <td bgcolor="#ffffff">
                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td style="padding:30px;font-family:sans-serif;font-size:15px;line-height:20px;color:#555555">
                                                    <div style="text-align:center;font-size:16px;line-height:20px;font-family:sans-serif">
                                                        สวัสดีคุณ '.$name.'<br>
                                                        ขอบคุณสำหรับการลงทะเบียน
                                                        <br><br>
                                                        <table cellspacing="0"
                                                            style="margin:0;border-spacing:0;border-collapse:collapse;border:1px solid #e6e8ee;width:100%;font-family:sans-serif">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="text-align:center;padding:15px 30px 30px 30px;color:#373b3f;font-size:16px;line-height:24px;font-family:sans-serif">
                                                                        <div style="font-size:20px;text-align:center;color:#373b3f;font-family:sans-serif;text-decoration:none;padding: 0px 80px 5px 80px;">
                                                                            คุณจะสามารถเข้าสู่ระบบได้หลังจากที่ยืนยันอีเมลโดยการกดปุ่มด้านล่าง
                                                                        </div>
                                                                        <div style="padding:16px 0;font-weight:bold;font-family:sans-serif;line-height:24px">
                                                                            <span style="color:#1E8449">บทบาท : '.$role_name.'</span>
                                                                        </div>
                                                                        <br>
                                                                        <a href="http://nattapolt.ddns.net:100/Team7-Web/verify.php?email='.$email.'" target="_blank"
                                                                            style="text-decoration: none; color: white; background-color: #28B463; border: 0px; border-radius: 5px; font-size: 18px; font-weight:bold; padding: 16px 32px; margin: 4px 2px; transition-duration: 0.4s;">ยืนยันอีเมล
                                                                        </a>
                                                                        <br>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width:680px">
                        <tbody>
                            <tr>
                                <td style="padding:30px 10px;width:100%;font-size:12px;font-family:sans-serif;line-height:18px;text-align:center;color:#888888">
                                    <span style="font-size: 14px; font-weight: bold;">ติดต่อ</span><br><br>
                                    FACEBOOK : Team7-Infosec<br>
                                    เบอร์โทรศัพท์ : 000-000-0000<br>
                                    E-Mail : Team7-Infosec@email.com
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </center>
        </div>';
        
        //Recipients
        $mail->setFrom('Team7-Infosec@email.com', 'Team7 - Infamation Security');
        $mail->addAddress($to);

        //Content
        $mail->Subject = $subject;
        $mail->Body    = $message;
        if($mail->send()) {
            $password = base64_encode($password);
            $sql_users = "INSERT INTO users (userid, name, email, password, role_id, verify) VALUES ('$userid', '$name', '$email', '$password', '$role_id', 'NO')";
            mysqli_query($connect, $sql_users);
            $sql_log_users = "INSERT INTO log_users (users_id, userid, name, role_id, created_at) VALUES ('".mysqli_insert_id($connect)."', '$userid', '$name', '$role_id', SYSDATE())";
            if(mysqli_query($connect, $sql_log_users)) {
                echo "success";
            } else {
                echo "ไม่สามารถลงทะเบียนได้";
            }
        } else {
            echo "ไม่สามารถส่งอีเมลได้";
        }
    }
    
?>