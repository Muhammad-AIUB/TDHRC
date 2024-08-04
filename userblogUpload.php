<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start PHP session if none exists
}

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "pirccorg_tdhrcadmin";
$password = "W(=@h}IR&!qv";
$dbname = "pirccorg_tdhrc";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables to store form data
$btitle = $bintro = $bdesc = "";
$btitle_err = $bintro_err = $bdesc_err = "";
$bimag_err = "";

// Default image filename
$default_image = "pexels-pixabay-262508.jpg";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $btitle = trim($_POST["btitle"]);
    $bintro = trim($_POST["bintro"]);
    $bdesc = trim($_POST["bdesc"]);

    // Check if fields are empty
    if (empty($btitle)) {
        $btitle_err = "Please enter a title.";
    }
    if (empty($bintro)) {
        $bintro_err = "Please enter an introduction.";
    }
    if (empty($bdesc)) {
        $bdesc_err = "Please enter a description.";
    }

    // Validate and upload image
    if (!empty($_FILES["bimag"]["name"])) {
        $uploadedFile = uploadImage($_FILES["bimag"]);
        if ($uploadedFile) {
            $bimag = $uploadedFile; // Store the filename in $bimag
        } else {
            $bimag_err = "Failed to upload image.";
        }
    } else {
        $bimag = $default_image; // Use default image if none is uploaded
    }

    // If no errors, insert into database
    if (empty($btitle_err) && empty($bintro_err) && empty($bdesc_err) && empty($bimag_err)) {
        // Prepare SQL statement
        $sql = "INSERT INTO blogs (uid, btitle, bintro, bdesc, bimag) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $_SESSION['uid'], $btitle, $bintro, $bdesc, $bimag);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to success page or do something else (e.g., display success message)
            header("Location: userblogSuccess.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Upload - TDHRC Bangladesh</title>
    <link rel="stylesheet" href="css/blog-upload.css">
</head>
<body>
<?php include 'userdashboard.php'; ?> <!-- Importing sidebar menu -->

<div class="main-content">
    <h2>Welcome, <?php echo $user['fname']; ?></h2>
    <h2>Blog Upload</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="btitle">Blog Title:</label>
            <input type="text" id="btitle" name="btitle" value="<?php echo htmlspecialchars($btitle); ?>" maxlength="100" required>
            <span class="char-count"><span id="btitle-count">0</span>/100 characters</span>
            <span class="error"><?php echo $btitle_err; ?></span>
        </div>
        <div class="form-group">
            <label for="bintro">Introduction:</label>
            <textarea id="bintro" name="bintro" maxlength="500" required><?php echo htmlspecialchars($bintro); ?></textarea>
            <span class="char-count"><span id="bintro-count">0</span>/500 characters</span>
            <span class="error"><?php echo $bintro_err; ?></span>
        </div>
        <div class="form-group">
            <label for="bdesc">Description:</label>
            <textarea id="bdesc" name="bdesc" maxlength="25000" required><?php echo htmlspecialchars($bdesc); ?></textarea>
            <span class="char-count"><span id="bdesc-count">0</span>/25000 characters</span>
            <span class="error"><?php echo $bdesc_err; ?></span>
        </div>
        <div class="form-group">
            <button type="submit">Upload Blog</button>
        </div>
    </form>
</div>

<script>
    // Character counters
    const btitleInput = document.getElementById('btitle');
    const bintroInput = document.getElementById('bintro');
    const bdescInput = document.getElementById('bdesc');

    const btitleCount = document.getElementById('btitle-count');
    const bintroCount = document.getElementById('bintro-count');
    const bdescCount = document.getElementById('bdesc-count');

    btitleInput.addEventListener('input', function() {
        btitleCount.textContent = btitleInput.value.length;
    });

    bintroInput.addEventListener('input', function() {
        bintroCount.textContent = bintroInput.value.length;
    });

    bdescInput.addEventListener('input', function() {
        bdescCount.textContent = bdescInput.value.length;
    });
</script>
</body>
</html>