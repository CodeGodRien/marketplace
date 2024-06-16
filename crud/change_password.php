<?php
session_start();
require '../config/dbconn.php'; 


if (isset($_POST['confirm-change-password'])) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    function validate($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $password = validate($password);
    $confirm_password = validate($confirm_password);

    if ($password === $confirm_password) {
        
        if (isset($_GET['token_pass'])) {
            $token = $_GET['token_pass'];

            
            $sql = "SELECT * FROM users WHERE token_pass = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $token = $row['token_pass'];
                $current_password = $row['userPassword'];

                if ($password !== $current_password) {
                    
                    $update_stmt = $conn->prepare("UPDATE users SET userPassword = ? WHERE token_pass = ?");
                    $update_stmt->bind_param("ss", $password, $token);
                    if ($update_stmt->execute()) {
                        $_SESSION['alert'] = "Password successfully changed";
                    } else {
                        $_SESSION['alert'] = "Error updating password";
                    }
                } else {
                    $_SESSION['alert'] = "New password cannot be the same as the current password";
                }
            } else {
                $_SESSION['alert'] = "No user found with this email";
            }
        } else {
            $_SESSION['alert'] = "token pass not set in session";
        }
    } else {
        $_SESSION['alert'] = "Passwords do not match";
    }
} else {
    $_SESSION['alert'] = "Confirm change password not set";
}

header("Location: ../pages/index.php");
exit();
?>