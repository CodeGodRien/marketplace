<?php
session_start();
require '../config/dbconn.php'; 
require '../vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendemail_code($first_name, $email, $token_pass) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'sample@gmail.com';
        $mail->Password   = 'idk'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port       = 587; 

        $mail->setFrom('neilardrey14@gmail.com', 'Sender');
        $mail->addAddress($email, $first_name); 

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Code';
        $mail->Body    = "Hi $first_name,<br>Please click the link below to change your password:<br><a href='http://localhost/Project/marketplace/pages/change_password.php?token_pass=". urlencode($token_pass) ."'>Verify Email</a>";

        $mail->send();
        return true; 
    } catch (Exception $e) {
        return false; 
    }
}

if (isset($_POST['confirm_code_btn'])) {
    
    if (!empty(trim($_POST['email']))) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $token_pass = md5(uniqid(time()));

        
        function isValidOutlookEmail($email) {
            $pattern = '/^[a-zA-Z._%+-]+@([a-zA-Z0-9-]+\.)?nu-baliwag\.edu\.ph$/';
            return preg_match($pattern, $email);
        }
        
        
        if (empty($email) || !isValidOutlookEmail($email)) {
            $_SESSION['alert'] = "Valid Outlook email is required.";
            header("Location: ../pages/resend_verification.php");
            exit();
        }

       
        $checkemail_query = "SELECT * FROM users WHERE email = ? LIMIT 1";
        $stmt_checkemail = $conn->prepare($checkemail_query);
        $stmt_checkemail->bind_param("s", $email);
        $stmt_checkemail->execute();
        $checkemail_result = $stmt_checkemail->get_result();

        if ($checkemail_result->num_rows > 0) {
            
            $row = $checkemail_result->fetch_assoc();
            $first_name = $row["first_name"];
            $email = $row["email"];
            
            $insert_query = "UPDATE users SET token_pass = ? WHERE email = ?";
            $stmt_insert = $conn->prepare($insert_query);
            $stmt_insert->bind_param("ss", $token_pass, $email);

            if ($stmt_insert->execute()) {
                
                if (sendemail_code($first_name, $email, $token_pass)) {
                    $_SESSION['alert'] = "Code has been sent to your email.";
                    $_SESSION['user_email'] = $email;
                    header("Location: ../pages/send_code_password.php");
                    exit();
                } else {
                    $_SESSION['alert'] = "Failed to send email. Please try again.";
                    header("Location: ../pages/send_code_password.php");
                    exit();
                }
            } else {
                $_SESSION['alert'] = "Failed to update token. Please try again.";
                header("Location: ../pages/send_code_password.php");
                exit();
            }
        } else {
            // Email not found in database
            $_SESSION['alert'] = "Email not found. Please register your email now!";
            header("Location: ../pages/send_code_password.php");
            exit();
        }

    } else {
        $_SESSION['alert'] = "Email field is required.";
        header("Location: ../pages/resend_verification.php");
        exit();
    }
}
?>
