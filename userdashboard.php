<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start PHP session if none exists
}

include 'dbconn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Menu</h2>
            <a href="userdashHome.php">Home</a> <!-- Link to dashHome.php -->
            <a href="userblogUpload.php">Blog Creation</a> <!-- Link to BlogUpload.php -->
            <a href="userblogEdit.php">Blog Edit</a> <!-- Link to BlogUpload.php -->
            <a href="userconHistory.php">Contact History</a> <!-- Link to BlogUpload.php -->
            <a href="logout.php">Logout</a> <!-- Direct link to logout page -->
        </div>
        <div class="content">
            <!-- Content will be placed here -->
        </div>
    </div>
</body>
</html>