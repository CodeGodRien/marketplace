<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resend Verification</title>
    <link rel="stylesheet" href="../styles/index.css">
    <style>@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
</head>


<body>
    <div class="resend-verification-container">
        <div class="verification-header">
            <h1>Verification Page</h1>
        </div>
        
        <div class="resend-container">
            <h2>Resend Verification</h2>
            <?php
                if (isset($_SESSION['alert'])) {
                    echo $_SESSION['alert'];
                    unset($_SESSION['alert']);
                }
            ?>
            <p id="resend-verification-container-paragraph">Enter NU Email to resend the code</p>
            <form action="../crud/resend_code.php" method="POST" class="resend-verification-form">
                <div class="resend-verification-card-inputs">
                    <input type="text" name="email" required>
                </div>
                <div class="resend-verification-submit" >
                <input type="submit" value="resend code" name = "resend_btn" class="resend-button">
                </div>
            </form>

        </div>
    </div>
</body>
</html>