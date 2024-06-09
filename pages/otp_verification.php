<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP verifcation</title>
    <link rel="stylesheet" href="../styles/index.css">
    <style>@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
</head>


<body>
        <div class="verification-container">
            <div class="verification-header">
                <h1>Verification Page</h1>
            </div>
            
            <div class="otp-container">
                <h2>OTP Verifcation</h2>
                <p id = "container-paragraph">Enter the 4 digits code that you have received on your NU email</p>
                <div class="otp-card-inputs">
                    <input type="text" maxlength="1" autofocus>
                    <input type="text" maxlength="1">
                    <input type="text" maxlength="1">
                    <input type="text" maxlength="1">
                </div>
                <p>Didn't get the otp <a href = "#">Resend</a></p>
                <button>Verify</button>

            </div>


        </div>
    </div>
</body>
</html>