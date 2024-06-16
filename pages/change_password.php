<?php
$token = $_GET['token_pass'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change password</title>
    <link rel="stylesheet" href="../styles/index.css">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
</head>

<body>
    <div class="change-password-container">
        <div class="change-password-header">
            <h1>Change Password</h1>
        </div>
        <div class="password-card">
            <h2>Change Password</h2>
            <p id="container-paragraph">Your password must be at least 6 characters and should include a combination of
                numbers, letters and special characters (!$@%).</p>
            <?php
            if(isset($_SESSION['alert'])) {
                echo $_SESSION['alert'];
                unset($_SESSION['alert']);
            }
            ?>
            <div class="change-password-card-inputs">
                <form action="../crud/change_password.php?token_pass=<?php echo urlencode($token);?>" method="POST"
                    class="change-password-forms">
                    <div class="input-rows">
                        <label class=change-password-label>New Password</label>
                        <div>
                            <input type="text" placeholder="Enter New Password" name="password"
                                class="change-password-box" required>
                        </div>
                        <label class=change-password-label>Confirm Password</label>
                        <div>
                            <input type="text" placeholder="Confirm New Password" name="confirm-password"
                                class="change-password-box" required>
                        </div>
                    </div>
            </div>
            <input type="submit" value="Confirm" name="confirm-change-password" class="change-password-button">
        </div>
        </form>

    </div>
</body>

</html>