<?php
session_start();
require "../config/dbconn.php";

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
        <p> Welcome to [Company Name], where innovation meets excellence.
At [Company Name], we are passionate about [describe core mission or purpose]. Our journey began with a simple idea: to [describe initial inspiration or founding principle]. Since then, we've grown into a dynamic team dedicated to [describe primary objectives or goals].
Driven by a commitment to [describe key values or principles], we strive to [describe desired impact or outcome]. Our relentless pursuit of quality and creativity fuels everything we do, from [describe key activities or products] to [describe additional contributions or initiatives].
As a company, we believe in [describe broader philosophy or ethos], fostering a culture of [describe desired workplace atmosphere or values]. Our team is comprised of [describe attributes of team members], each bringing unique perspectives and expertise to the table.
Join us on our journey as we continue to [describe vision for the future]. Together, we can [describe desired collective achievement or impact].
Thank you for choosing [Company Name]. 
        </p>
        </div>

        <div class="about-btn">
        <button class="about-btn2">Join Us!</button>
        </div>

        <div class="nub1-img-div">
        <img src="../about_pics/nub1.png" alt="" class="nub1-image">
        </div>

        <div class="nub2-img-div">
        <img src="../about_pics/nub2.png" alt="" class="nub2-image">
        </div>

        <div class="about-rectangle">
        </div>

        </div>
</body>
</html>