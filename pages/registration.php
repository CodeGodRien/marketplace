<?php
session_start();
require "../config/dbconn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="../styles/index.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
</head>

<body>
    <div class="registration-left">
        <div class="upper-registration">
            <h2>NUB Marketplace</h2>
        </div>
        <div class="registration-left-container">
            <h1>Already a member?</h1>
            <p>If you already have an account, just sign in.</p>
            <button onclick="location.href='../pages/index.php'">Sign In</button>
        </div>
        <div class="triangle-registration"></div>
        <div class="small-triangle-registration"></div>
    </div>

    <div class="registration-right">
        <div class="registration-right-container">
            <h1>Create Free Account</h1>

            <form action="../crud/generate_code.php" method="POST" id="registration-form">
                <div class="form-row">
                    <input type="text" name="first_name" placeholder="First Name" class="registration-input-box"
                        required>
                    <input type="text" name="last_name" placeholder="Last Name" class="registration-input-box" required>
                </div>
                <div class="special-form-row">
                    <input type="email" name="email" placeholder="NU Email" class="registration-input-box" required>
                    <input type="text" name="contact_number" placeholder="Contact Number" class="registration-input-box"
                        required>
                </div>
                <div class="form-row">
                    <input type="password" name="password" placeholder="Password" class="registration-input-box"
                        required>
                    <input type="password" name="confirm_password" placeholder="Confirm Password"
                        class="registration-input-box" required>
                        <div class="resend-code-registration">
                            <button onclick="location.href='../pages/resend_verification.php'">Resend Code</button>
                        </div>
                </div>


                <input type="submit" value="Sign In" name="register_btn" class="login-button">
            </form>
        </div>
    </div>

</body>

</html>
<?php
            if (isset($_SESSION['alert'])) {
                echo $_SESSION['alert'];
                unset($_SESSION['alert']);
            }
            ?>
            <?php
            if(isset($_SESSION['status'])) {
                echo $_SESSION['status'];
                unset($_SESSION['status']);
             }
            ?>