<?php
session_start();
require "../config/dbconn.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../styles/index.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
</head>
<body>
    <div class="login-left">
        <div class="upper-login"><h2>NUB Marketplace</h2></div>
        <div class="lower-login">
            <h1 class="login-h1">Login To Your Account</h1>
            
        <?php
            if(isset($_SESSION['alert'])) {
            echo $_SESSION['alert'];
            unset($_SESSION['alert']);
            }
        ?>
            <form action="../crud/login.php" method="POST" id="login-form">
                <input type="text" placeholder="NU Email" class="input-box" name="email">
                <input type="password" placeholder="Password" class="input-box" name="password">
                <input type="submit" value="Sign In" class="login-button">
            </form>
        </div>
    </div>
    <div class="login-right">
        <div class="triangle"></div>
        <div class="small-triangle"></div>
        <div class="login-right-container">
            <h1>New Here?</h1>
            <p>Sign up and discover a great amount of new items!</p>
            <button><a href="../pages/registration.php">Sign Up</a></button>
        </div>
    </div>
</body>
</html>