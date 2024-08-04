<?php
// Start session
session_start();

// Database connection
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

// Handle form submission for registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['uemail']) && isset($_POST['upass']) && isset($_POST['fname'])) {
    $uemail = $_POST['uemail'];
    $upass = $_POST['upass'];
    $fname = $_POST['fname'];
    $upass_confirm = $_POST['upass_confirm'];

    if ($upass !== $upass_confirm) {
        $errorMessage = 'Passwords do not match';
    } else {
        // Hash the password
        $hashedPassword = password_hash($upass, PASSWORD_DEFAULT);

        // Check if email already exists
        $stmt = $conn->prepare('SELECT uid FROM login WHERE uemail = :uemail');
        $stmt->execute(['uemail' => $uemail]);
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            $errorMessage = 'Email already exists';
        } else {
            // Insert new user into database
            $stmt = $conn->prepare('INSERT INTO login (uemail, upass, fname) VALUES (:uemail, :upass, :fname)');
            $stmt->execute(['uemail' => $uemail, 'upass' => $hashedPassword, 'fname' => $fname]);

            // Optionally, you can redirect to login page after successful registration
            header('Location: login.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="css/register.css">
    <script>
        function validateForm() {
            const upass = document.getElementById('upass').value;
            const upassConfirm = document.getElementById('upass_confirm').value;
            if (upass !== upassConfirm) {
                document.getElementById('error-message').textContent = 'Passwords do not match';
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <form method="POST" onsubmit="return validateForm()">
            <label for="fname">Full Name:</label>
            <input type="text" id="fname" name="fname" required>
            <label for="uemail">Email:</label>
            <input type="email" id="uemail" name="uemail" required>
            <label for="upass">Password:</label>
            <input type="password" id="upass" name="upass" required>
            <label for="upass_confirm">Confirm Password:</label>
            <input type="password" id="upass_confirm" name="upass_confirm" required>
            <button type="submit">Register</button>
            <center>
            <a href="/tdhrc.org/index.php">Back to Homepage</a>
            </center>
        </form>
        <span id="error-message" style="color:red;"><?php echo $errorMessage; ?></span>
    </div>
</body>
</html>
