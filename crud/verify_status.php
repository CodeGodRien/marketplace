<?php

if (!isset($_SESSION['userID'])) {
    header("Location: ../pages/index.php");
    exit;
} else {
    $userID = $_SESSION['userID'];
    
    $sql = "SELECT verify_status FROM users WHERE userID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $userID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $vStatus);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        if ($vStatus == 0) {
            header("Location: ../pages/index.php");
            exit;
        }
    } else {
        echo "Error preparing the SQL statement.";
    }
}

mysqli_close($conn);
?>