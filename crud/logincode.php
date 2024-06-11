<?php
include('dbcon.php');

if(isset($_POST['login_btn']))
{
    if(empty(trim($_POST['email'])) && empty(trim($_POST['password'])))
    {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $login_query = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
        $login_query_run = mysqli_query($con, $login_query);

        if(mysqli_num_rows($login_query_run) > 0)
        {
            $row = mysqli_fetch_array($login_query_run);

            if($row["verify_status"] == 1){

                $_SESSION['authenticated'] = TRUE;
                $_SESSION['auth_user'] = [
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'email' => $row['email'],
                    'contact_number' => $row['contact_number'],
                    'userPassword' => $row['userPassword'],
                ];
                $_SESSION['alert'] = "You are logged in successfully";
                header("Location: ../pages/index.php");
                exit(0);

            }else{
                $_SESSION['alert'] = "Please verify your email address";
                header("Location: ../pages/index.php");
                exit(0);
            }
        }
        else
        {
            $_SESSION['alert'] = "Invalid email or Password";
            header("Location: ../pages/index.php");
            exit(0);
        }
    }
    else
    {
        $_SESSION['alert'] = "All fields are Mandatory";
        header("Location: ../pages/index.php");
        exit(0);
    }
}
?>