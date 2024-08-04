<?php
// Start session
session_start();

$servername = "localhost";
$username = "pirccorg_tdhrcadmin";
$password = "W(=@h}IR&!qv";
$dbname = "pirccorg_tdhrc";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

$errorMessage = '';

// Handle form submission for login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['uemail']) && isset($_POST['upass'])) {
    $uemail = $_POST['uemail'];
    $upass = $_POST['upass'];

    $stmt = $conn->prepare('SELECT uid, uemail, upass, fname FROM login WHERE uemail = :uemail');
    $stmt->execute(['uemail' => $uemail]);
    $user = $stmt->fetch();

    if ($user && password_verify($upass, $user['upass'])) {
        // Store user details in session
        $_SESSION['uid'] = $user['uid'];
        $_SESSION['uemail'] = $user['uemail'];
        $_SESSION['fname'] = $user['fname'];

        // Redirect to dashboard or any protected page
        header('Location: userdashHome.php');
        exit;
    } else {
        $errorMessage = 'Invalid email or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <divdiv class="login-container">
        <h2>Login</h2>
        <form method="POST">
            <label for="uemail">Email:</label>
            <input type="email" id="uemail" name="uemail" required>
            <label for="upass">Password:</label>
            <input type="password" id="upass" name="upass" required>
            <button type="submit">Login</button>
            <center>
            <a href="/index.php">Back to Homepage</a>
            </center>
            
        </form>
        <span style="color:red;"><?php echo $errorMessage; ?></span>
    </div>
</body>
</html>
