<?php
$servername = "localhost";
$username = "pirccorg_tdhrcadmin";
$password = "W(=@h}IR&!qv";
$dbname = "pirccorg_tdhrc";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check session status
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Start PHP session if none exists
    }

    // Fetch user information if session variable is set
    if (isset($_SESSION['uid'])) {
        $uid = $_SESSION['uid'];
        $sql = "SELECT * FROM login WHERE uid=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$uid]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists
        if (!$user) {
            echo "User not found.";
            exit();
        }
        $stmt->closeCursor(); // Close cursor after fetch
    } else {
        echo "User not logged in.";
        exit();
    }
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}
?>
