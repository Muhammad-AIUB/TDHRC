<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/topnav.css">
</head>
<body>
    <div class="topnav">
        <div class="logo">
            <a href="/index.php"><img src="assets/tdhrc_logo.jpg" alt="Logo"></a>
            <span class="site-name">Tropical Disease Health Research Center</span>
        </div>
        <div class="nav-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="menu nav-menu">
            <a href="/index.php">HOME</a>
            <a href="/aboutus.php">ABOUT US</a>
            <a href="/datarepo.php">DATA REPOSITORY</a>
            <a href="/homeblogs.php">BLOGS</a>
            <a href="/publications.php">PUBLICATIONS</a>
            <a href="/contact.php">CONTACT</a>
            <a href="/donations.php">DONATION</a>
            <a href="/login.php">LOGIN</a>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const navToggle = document.querySelector('.nav-toggle');
            const navMenu = document.querySelector('.nav-menu');

            navToggle.addEventListener('click', function () {
                navMenu.classList.toggle('active');
            });
        });
    </script>
</body>
</html>
