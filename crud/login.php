<?php
session_start();
require "../config/dbconn.php";

if (isset($_POST['email'], $_POST['password'])) {
    $loginEmail = $_POST['email'];
    $loginPassword = $_POST['password'];

    // Validate input - Example for email validation
    // if (!filter_var($loginEmail, FILTER_VALIDATE_EMAIL)) {
    //     $_SESSION['alert'] = "Invalid email format.";
    //     header("Location: ../pages/index.php");
    //     exit();
    // }

    // Use prepared statement to avoid SQL injection
    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $loginEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify password - Example using password_verify()
        // $hashedPasswordFromDB = $row['userPassword'];
        // if (password_verify($loginPassword, $hashedPasswordFromDB)) {
        if ($row['userPassword'] === $loginPassword) { // Replace with proper password verification
            if ($row["verify_status"] == 1) {
                $_SESSION['authenticated'] = TRUE;
                $_SESSION['auth_user'] = [
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'email' => $row['email'],
                    'contact_number' => $row['contact_number'],
                    // 'userPassword' => $row['userPassword'], // Do not store password in session
                ];
                $_SESSION['userID'] = $row['userID'];
                header("Location: ../pages/customer_dashboard.php");
                exit();
            } else {
                $_SESSION['alert'] = "Please verify your email address";
                header("Location: ../pages/index.php");
                exit();
            }
        } else {
            $_SESSION['alert'] = "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Wrong username or password',
                        text: 'Please try again.'
                    });
                </script>
            ";
            header("Location: ../pages/index.php");
            exit();
        }
    } else {
        $_SESSION['alert'] = "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Wrong username or password',
                    text: 'Please try again.'
                });
            </script>
        ";
        header("Location: ../pages/index.php");
        exit();
    }
} else {
    $_SESSION['alert'] = "Invalid request.";
    header("Location: ../pages/index.php");
    exit();
}
?>
