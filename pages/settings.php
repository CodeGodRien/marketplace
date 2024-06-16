<?php
    session_start();
    require '../config/dbconn.php';
    if (!isset($_SESSION['userID'])) {
        header("Location: ../pages/index.php");
    } else {
        $userID = $_SESSION['userID'];
        $sql = "SELECT * FROM users WHERE userID = '$userID'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $vStatus = $row['verify_status'];
        if ($vStatus == 0) {
            header("Location: ../pages/index.php");
        } 
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="../styles/index.css">
</head>

<body>
    <div class="settings-container">
        <?php  
        include_once '../components/sidebar.php'; 
        $sql = "SELECT * FROM users WHERE userID = '$userID'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        ?>
        <div class="details-container">
            <div class="left-details">
                <div class="details-header">
                    <h1>Account Details</h1>
                </div>
                <div class="details">
                    <form action="">
                        <div class="form-row">
                            <div class="row-1 label-row">
                                <label for="first_name">First Name</label>
                            </div>
                            <div class="row label-row">
                                <label for="last_name">Last Name</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="row-1">
                                <input type="text" class="details-input" value="<?php echo $row['first_name']; ?>"
                                    readonly>
                            </div>
                            <div class="row">
                                <input type="text" class="details-input" value="<?php echo $row['last_name']; ?>"
                                    readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="row-1 label-row">
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="row-1 long-row">
                                <input type="text" class="details-input" value="<?php echo $row['email']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="row-1 label-row">
                                <label for="contact_number">Contact Number</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="row-1 long-row">
                                <input type="text" class="details-input" value="<?php echo $row['contact_number']; ?>"
                                    readonly>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="right-details">
                <div class="account-image-div">
                    <img src="../profile_pics/ant.png" alt="Account Image" class="account-image">
                </div>
            </div>
        </div>
    </div>
</body>

</html>
