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
                $current_password = $row['userPassword'];

                // Verify that the new password is not the same as the current password
                if (!password_verify($password, $current_password)) {
                    // Hash the new password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Update the password in the database
                    $update_sql = "UPDATE users SET userPassword = ?, token_pass = NULL WHERE token_pass = ?";
                    $update_stmt = $conn->prepare($update_sql);
                    $update_stmt->bind_param("ss", $hashed_password, $token);

                    if ($update_stmt->execute()) {
                        $_SESSION['alert'] = "Password successfully changed";
                    } else {
                        $_SESSION['alert'] = "Error updating password";
                    }

                    $update_stmt->close();
                } else {
                    $_SESSION['alert'] = "New password cannot be the same as the current password";
                }
            } else {
                $_SESSION['alert'] = "No user found with this token";
            }

            $stmt->close();
        } else {
            $_SESSION['alert'] = "Token pass not set in session";
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
