<?php
    include('PHPMailer.php');
    include('server.php');
    session_start();

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $subject_data = $_POST['subject'];

    $check_email = "SELECT * FROM users LEFT JOIN role ON (role.role_id = users.role_id) WHERE users.userid = '".$_SESSION['userid']."' AND role.role_name = '".$_SESSION['role']."'";
    $query = mysqli_query($connect, $check_email);
    $result = mysqli_fetch_assoc($query);

    // print_r("userid: ".$result['userid']."fname: ".$fname." lname: ".$lname." subject: ".$subject_data." email: ".$result['email']);
    // exit;
    // if($result['role_name'] == 'ADMIN') {
    //     $role = 'รหัสประจำตัวผู้ดูแลระบบ :';
    // } else if($result['role_name'] == 'TEACHER') {
    //     $role = 'รหัสประจำตัวผู้สอน :';
    // } else if($result['role_name'] == 'STUDENT' || $result['role_name'] == 'PARENT') {
    //     $role = 'รหัสประจำตัวนักเรียน :';
    // }
    $userid = $result['userid'];
    $email = $result['email'];

    $to      = 's6102041610041@email.kmutnb.ac.th'; // Send email to our user
    $subject = 'ติดต่อ'; // Give the email a subject 
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
                                                <div style="text-align:center;font-size:20px;line-height:20px;font-family:sans-serif">
                                                    ติดต่อ
                                                    <br><br>
                                                    <table cellspacing="0"
                                                        style="margin:0;border-spacing:0;border-collapse:collapse;border:1px solid #e6e8ee;width:100%;font-family:sans-serif">
                                                        <tbody>
                                                            <tr>
                                                                <td style="text-align:left;padding:20px 0px 20px 30px;color:#373b3f;font-size:16px;line-height:24px;font-weight:bold;font-family:sans-serif;width:27%;">
                                                                    <div style="text-decoration:none;">
                                                                        รหัสประจำตัว :
                                                                    </div>
                                                                    <div style="line-height:50px">
                                                                        จาก :
                                                                    </div>
                                                                    <div>
                                                                        เรื่อง :
                                                                    </div>
                                                                </td>
                                                                <td style="text-align:left;padding:20px 30px 20px 0px;color:#373b3f;font-size:16px;line-height:24px;font-family:sans-serif">
                                                                    <div style="text-decoration:none;">
                                                                        '.$userid.'
                                                                    </div>
                                                                    <div style="line-height:50px">
                                                                        '.$fname.' '.$lname.'
                                                                    </div>
                                                                    <div>
                                                                        <span style="color:#1E8449">'.$subject_data.'</span>
                                                                    </div>
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
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </center>
    </div>';
    
    //Recipients
    $mail->setFrom($email, $email);
    $mail->addReplyTo($email);
    $mail->addAddress($to);

    //Content
    $mail->Subject = $subject;
    $mail->Body    = $message;
    if($mail->send()) {
        echo "success";
    } else {
        echo "fail";
    }
    
?>