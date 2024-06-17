<?php
session_start();
require "../config/dbconn.php";

if (!isset($_SESSION['userID'])) {
    header("Location: ../pages/index.php");
    exit;
} else {
    $userID = $_SESSION['userID'];
    
    $sql = "SELECT verify_status FROM users WHERE userID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $userID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $vStatus);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        if ($vStatus == 0) {
            header("Location: ../pages/index.php");
            exit;
        }
    } else {
        echo "Error preparing the SQL statement.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - NUBMarketplace</title>
    <link rel="stylesheet" href="../styles/index.css">
</head>
<body>
    <div class="aboutus-container">
    <?php include_once '../components/navbar.php';?>
    </div>

    <div class="about-container">

    <div class="about-h1">
        <h1> About Us </h1>
        </div>
        <div class="about-h2">
        <h2> NUBMarketplace </h2>
        </div>

        <div class="about-desc">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3854.579631302055!2d120.89017737415661!3d14.960495468165991!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3396fffe81226745%3A0xd61662a7648edf6b!2sSM%20Baliwag%2C%20Do%C3%B1a%20Remedios%20Trinidad%20Hwy%2C%20Pagala%2C%20Baliwag%2C%203006%20Bulacan!5e0!3m2!1sen!2sph!4v1718559983499!5m2!1sen!2sph" 
            width="450" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        
        <div class="about-btn">
        <a href="../pages/customer_dashboard.php">
        <button class="about-btn2">Back to Home Page</button>
        </a>
        </div>

        <div class="nub1-img-div">
        <img src="../about_contact_pics/about-img.png" alt="" class="nub1-image">
        </div>

        <div class="nub2-img-div">
        <img src="../about_contact_pics/about-img2.png" alt="" class="nub2-image">
        </div>

        <div class="about-rectangle">
        </div>

        </div>
</body>
</html>