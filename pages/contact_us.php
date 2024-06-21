<?php
session_start();
require "../config/dbconn.php";
require "../crud/verify_status.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - NUBMarketplace</title>
    <link rel="stylesheet" href="../styles/index.css">
</head>
<body>

    <div class="aboutus-container">
    <?php include_once '../components/navbar.php';?>
    </div>

        <div class="contact-img-div">
        <img src="../about_contact_pics/contact-img.png" alt="" class="contact-img">
        </div>

        <div class="contact-h1">
        <h2> Contact Us </h2>
        </div>

        <div class="contact-h2">
        <h3> Visit Us </h3>
        </div>

        <div class="contact-p">
        <p> NU Baliuag  Located in: SM City Baliwag
        Address: Complex, SM Baliwag, Doña Remedios Trinidad Hwy, Baliwag, Bulacan</p>
        </div>

        <div class="contact2-h2">
        <h3> Contact </h3>
        </div>

        <div class="contact2-p2">
        admissions-nubaliwag@nu.edu.ph </br>

0919 081 4635 (Smart) </br>

0927 533 0342 (Globe) </br>

0923 949 5265 (Sun)
        </p>
        </div>


        <div class="contact-rectangle">
        </div>

        </body>
</html>