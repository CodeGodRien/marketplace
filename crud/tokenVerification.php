<?php
session_start();
require '../config/dbconn.php';


if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $conn->prepare("SELECT verify_status FROM users WHERE verify_token = ? LIMIT 1");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
 
        if ($row["verify_status"] === 0) {  
            $update_stmt = $conn->prepare("UPDATE users SET verify_status = 1 WHERE verify_token = ? LIMIT 1");
            $update_stmt->bind_param("s", $token);
            $update_stmt->execute();

            if ($update_stmt->affected_rows > 0) {
                $_SESSION['alert'] = "Account has been verified successfully. You can now login your account";
                header("Location: ../pages/index.php");

                exit(0);
            } else {
                $_SESSION['alert'] = "Verification failed";
                header("Location: ../pages/index.php");
                exit(0);
;
            }
        } else {
            $_SESSION['alert'] = "Email already verified. Please login";
            header("Location: ../pages/index.php");
            exit(0);

        }
    } else {
        $_SESSION['alert'] = "Token does not exist";
        header("Location: ../pages/index.php");
        exit(0);
    }
} else {
    $_SESSION['alert'] = "Not Allowed";
    header("Location: ../pages/index.php");
    exit(0);
}

?>
