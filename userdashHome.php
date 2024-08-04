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

// Handle form submission for data edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['uemail']) && isset($_POST['fname'])) {
    $uemail = $_POST['uemail'];
    $fname = $_POST['fname'];
    $upass = $_POST['upass'];
    $upass_confirm = $_POST['upass_confirm'];

    // Check if passwords match
    if ($upass !== $upass_confirm) {
        $errorMessage = 'Passwords do not match';
    } else {
        // Hash the password if provided
        if (!empty($upass)) {
            $hashedPassword = password_hash($upass, PASSWORD_DEFAULT);

            // Update user information with hashed password
            $stmt = $conn->prepare('UPDATE login SET uemail = :uemail, upass = :upass, fname = :fname WHERE uid = :uid');
            $stmt->execute(['uemail' => $uemail, 'upass' => $hashedPassword, 'fname' => $fname, 'uid' => $_SESSION['uid']]);
        } else {
            // Update user information without changing password
            $stmt = $conn->prepare('UPDATE login SET uemail = :uemail, fname = :fname WHERE uid = :uid');
            $stmt->execute(['uemail' => $uemail, 'fname' => $fname, 'uid' => $_SESSION['uid']]);
        }

        // Optionally, you can redirect or show a success message
        // header('Location: dashboard.php');
        // exit;
        $errorMessage = 'User information updated successfully';
    }
}

// Fetch user data from database
$stmt = $conn->prepare('SELECT * FROM login WHERE uid = :uid');
$stmt->execute(['uid' => $_SESSION['uid']]);
$user = $stmt->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
        }
        .sidebar {
            width: 200px;
            background-color: #333;
            color: white;
            height: 100vh;
            padding: 15px;
        }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            margin: 5px 0;
        }
        .sidebar a:hover {
            background-color: #575757;
        }
        .content {
            flex: 1;
            padding: 15px;
        }
        .edit-form {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 15px;
            width: 300px;
        }
        .edit-form label {
            display: block;
            margin-bottom: 5px;
        }
        .edit-form input[type="text"], .edit-form input[type="email"], .edit-form input[type="password"] {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
        }
        .edit-form button {
            padding: 8px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .edit-form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
    <?php include 'userdashboard.php'; ?> <!-- Importing sidebar menu -->
        <div class="content">
        <h2>Welcome, <?php echo $user['fname']; ?></h2>
        <h2>CURRENT INFORMATION</h2>
            <p>Full Name: <?php echo $user['fname']; ?></p>
            <p>Email: <?php echo $user['uemail']; ?></p>

            <div class="edit-form">
                <h3>Edit & Update Information</h3>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div>
                        <label for="fname">Full Name:</label>
                        <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($user['fname']); ?>" required>
                    </div>
                    <div>
                        <label for="uemail">Email:</label>
                        <input type="email" id="uemail" name="uemail" value="<?php echo htmlspecialchars($user['uemail']); ?>" required>
                    </div>
                    <div>
                        <label for="upass">New Password:</label>
                        <input type="password" id="upass" name="upass">
                    </div>
                    <div>
                        <label for="upass_confirm">Confirm Password:</label>
                        <input type="password" id="upass_confirm" name="upass_confirm">
                    </div>
                    <button type="submit">Save Changes</button>
                </form>
            </div>
            <p style="color:red;"><?php echo htmlspecialchars($errorMessage); ?></p>
        </div>
    </div>
</body>
</html>