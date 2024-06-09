<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Products</title>
    <link rel="stylesheet" href="../styles/index.css">
</head>
<body>
    <div class="settings-container">
        <?php  include_once '../components/sidebar.php'; ?>

        <div class="Password-container">
            <div class="Header">
                <h1>Change Password</h1>
            </div>
        </div>

        <div class="text-container">
            <div class="information-text">
                <p>Your password must be at least 6 characters and should include a combination of numbers, letters and special characters (!$@%).</p>
            </div>

            <form action="" method="" id="registration-form">
            <div class="row-container">

                <div class="rows">
                    Current Password
                    <div>
                        <input type="text" placeholder="Enter Current Password" class="security-input-box">
                    </div>
                </div>
                <div class="rows">
                    New Password
                    <div>
                        <input type="text" placeholder="Enter New Password" class="security-input-box">
                    </div>
                </div>
                <div class="rows">
                    Re-type New Password
                    <div>
                        <input type="text" placeholder="Re-type New Password" class="security-input-box">
                        <a href="">Forgotten your password?</a>
                    </div>    
                </div>
                </form>

                <div class="security-submit">
                    <button class = security-cancel><a href="">Cancel</a></button>
                    <button class = security-save><a href="">Save</a></button>
                </div>
                
            </div>
        </div>
    </div>
</body>
</html>