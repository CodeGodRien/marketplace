<?php
session_start();
include "../config/dbconn.php";

if (isset($_POST['email']) && isset($_POST['password'])) {

    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

$loginEmail = validate($_POST['email']);
$loginPassword = validate($_POST['password']);

$sql = "SELECT * FROM users WHERE email = '$loginEmail' AND userPassword = '$loginPassword'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['userID'] = $row['userID'];
    header("Location: ../pages/customer_dashboard.php");
    exit();
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


?>