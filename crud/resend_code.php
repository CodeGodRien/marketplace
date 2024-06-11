<?php
session_start();
require '../config/dbconn.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


function resend_email_verify($first_name, $email, $verify_token){
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'sample@gmail.com';
        $mail->Password   = 'password of gmail'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('neilardrey14@gmail.com', 'Sender');
        $mail->addAddress($email, $first_name);

        $mail->isHTML(true);
        $mail->Subject = 'Resend Email Verification';
        $mail->Body = "Hi $first_name,<br>Please click the link below to confirm your email address and activate your account:<br><a href='http://localhost/Project/marketplace/crud/tokenVerification.php?token=". urlencode($verify_token) ."'>Verify Email</a>";
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}
if (isset($_POST['resend_btn'])) {
    if (!empty(trim($_POST['email']))) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }    
        
        $checkemail_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $checkemail_query_run = mysqli_query($conn, $checkemail_query);
        
        if (mysqli_num_rows($checkemail_query_run) > 0) {
            $row = mysqli_fetch_array($checkemail_query_run);
            if ($row['verify_status'] == "0") {
                $first_name = $row["first_name"];
                $verify_token = $row["verify_token"];
                $email = $row["email"];
   
                resend_email_verify($first_name, $email, $verify_token);
                $_SESSION['alert'] = "Verification has been sent to your email";
            } else {
                $_SESSION['alert'] = "Email already verified. Please Login";
            }
        } else {
            $_SESSION['alert'] = "Email is not registered. Please Register now!";
        }
    } else {
        $_SESSION['alert'] = "Please enter the email field";
    }
    header("Location: ../pages/resend_verification.php");
    exit(0);
}


?>

