//for email
<?php        
require 'vendor/autoload.php'; //Create an instance; passing true enables exceptions
            $mail = new PHPMailer\PHPMailer\PHPMailer();

            // Use SMT
            $mail->isSMTP();

            // SMTP settings
            $mail->SMTPDebug = 0;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = 'gentriusprojects@gmail.com';
            $mail->Password = 'lbef xirr qxgq tsix';

            // Set 'from' email address and name
            $mail->setFrom('gentriusprojects@gmail.com', 'Gentrius Solutions');

            // Add a recipient email address
            $mail->addAddress($Email);

            // Email subject and body
            $mail->Subject = 'Test Email';
            $mail->Body = "Dear $UserName,\n\n" . // Include user name
                "Congratulations! Your registration was successful.\n\n" .
                "Thank you for joining our community. We’re excited to have you on board! Here are the details of your registration:\n\n" .
                "- Email: $Email\n" . // Include email
                "- Registration Date: " . date('Y-m-d') . "\n\n" . // Include registration date
                "To get started, we encourage you to explore our platform and take advantage of the features available to you. If you have any questions or need assistance, feel free to reach out to our support team at support@example.com.\n\n" .
                "Welcome aboard!\n\n" .
                "Best regards,\n" .
                "HELPZ\n" .
                "+91 9856985674\n" .
                "www.helpz.org";

            // Send email
            if (!$mail->send()) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                // echo 'Message sent!';
            }
            ?>