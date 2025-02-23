<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once('connection.php');
require 'vendor/autoload.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['forgotemail'];
    $otp = rand(100000, 999999);

    // Check if email exists in tbl_login
    $sql1 = "SELECT * FROM tbl_login WHERE username = '$email'";
    $result1 = mysqli_query($conn, $sql1);

    if (mysqli_num_rows($result1) > 0) {
        // Insert OTP into tbl_otp
        $sql = "INSERT INTO tbl_otp (email, otp, timestamp, status) VALUES ('$email', '$otp', NOW(), 'unused')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Send OTP via email
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = 'your mail';
            $mail->Password = 'your code';
            $mail->setFrom('mail', 'passcode');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'OTP for Password Reset';
            $mail->Body = "Your OTP is: $otp";

            if ($mail->send()) {
                echo "Message has been sent.";
            } else {
                echo "Message could not be sent. Mailer Error: " . $mail->ErrorInfo;
            }
        } else {
            echo "Failed to insert OTP into the database.";
        }
    } else {
        echo "Invalid email ID.";
    }
}
?>
