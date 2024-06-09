<?php
session_start();
require "../config/dbconn.php";

if (!isset($_SESSION['userID'])) {
    die("User is not logged in");
}

// Database connection details
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = ""; // Default password is empty
$dbname = "numarket";

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get user_id from session
$userID = $_SESSION['userID'];

// Prepare and execute query to fetch user details
$stmt = $mysqli->prepare("SELECT first_name, last_name, sex, email FROM users WHERE userID = ?");
if ($stmt === false) {
    die("Prepare failed: " . $mysqli->error);
}

$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->bind_result($first_name, $last_name, $sex, $email);
$stmt->fetch();
$stmt->close();
$mysqli->close();
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
        <?php include_once '../components/sidebar.php'; ?>
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
                                <input type="text" id="first_name" name="first_name" class="details-input" value="<?php echo htmlspecialchars($first_name); ?>">
                            </div>
                            <div class="row">
                                <input type="text" id="last_name" name="last_name" class="details-input" value="<?php echo htmlspecialchars($last_name); ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="row-1 label-row">
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="row-1 long-row">
                                <input type="email" id="email" name="email" class="details-input" value="<?php echo htmlspecialchars($email); ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="row-1 label-row">
                                <label for="contact_number">Contact Number</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="row-1 long-row">
                                <input type="text" id="contact_number" name="contact_number" class="details-input" value="<?php echo htmlspecialchars($contact_number); ?>">
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
