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
$bimag = "";

// Fetch all blogs for the dropdown
$blogs = [];
$sql = "SELECT bid, btitle FROM blogs";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $blogs[] = $row;
    }
}

// Fetch the existing blog details if a bid is selected
if (isset($_GET['bid'])) {
    $bid = $_GET['bid'];

    // Prepare SQL statement to fetch blog details by 'bid'
    $stmt = $conn->prepare("SELECT btitle, bintro, bdesc, bimag FROM blogs WHERE bid = ?");
    $stmt->bind_param("i", $bid);
    $stmt->execute();
    $stmt->bind_result($btitle, $bintro, $bdesc, $bimag);
    $stmt->fetch();
    $stmt->close();
}

// Function to upload image and return the filename
function uploadImage($file) {
    $targetDir = "C:/xampp/htdocs/tdhrc.org/visuals/assets/";
    $fileName = basename($file["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Check if file is an actual image
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        return "";
    }

    // Check file size
    if ($file["size"] > 500000) { // 500KB limit
        return "";
    }

    // Allow only certain file formats
    $allowedTypes = array("jpg", "jpeg", "png", "gif");
    if (!in_array($fileType, $allowedTypes)) {
        return "";
    }

    // Upload file to server
    if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
        return $fileName; // Return the filename
    } else {
        return "";
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        // Validate and sanitize input
        $btitle = trim($_POST["btitle"]);
        $bintro = trim($_POST["bintro"]);
        $bdesc = trim($_POST["bdesc"]);
        $bid = $_POST["bid"];

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
        }

        // If no errors, update the database
        if (empty($btitle_err) && empty($bintro_err) && empty($bdesc_err) && empty($bimag_err)) {
            // Prepare SQL statement
            if (!empty($uploadedFile)) {
                $sql = "UPDATE blogs SET btitle = ?, bintro = ?, bdesc = ?, bimag = ? WHERE bid = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssi", $btitle, $bintro, $bdesc, $bimag, $bid);
            } else {
                $sql = "UPDATE blogs SET btitle = ?, bintro = ?, bdesc = ? WHERE bid = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssi", $btitle, $bintro, $bdesc, $bid);
            }

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
    } elseif (isset($_POST['delete'])) {
        // Handle delete request
        $bid = $_POST['bid'];
        $sql = "DELETE FROM blogs WHERE bid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $bid);

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
    <title>Edit Blog - TDHRC Bangladesh</title>
    <link rel="stylesheet" href="css/edit-blog.css">
</head>
<body>
    <?php include 'userdashboard.php'; ?>

    <div class="main-content">
    <h2>Welcome, <?php echo $user['fname']; ?></h2>
        <h2>Edit Blog</h2>
        
        <!-- Form to select blog -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
            <div class="form-group">
                <label for="bid">Select Blog to Edit:</label>
                <select name="bid" id="bid" onchange="this.form.submit()">
                    <option value="">--Select Blog--</option>
                    <?php foreach ($blogs as $blog): ?>
                        <option value="<?php echo $blog['bid']; ?>" <?php if (isset($bid) && $bid == $blog['bid']) echo 'selected'; ?>>
                            <?php echo $blog['bid'] . " - " . htmlspecialchars($blog['btitle']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <!-- Form to edit selected blog -->
        <?php if (isset($bid)): ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?bid=" . $bid; ?>" method="post" enctype="multipart/form-data">
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
                    <label for="bimag">Blog Image:</label>
                    <input type="file" id="bimag" name="bimag" accept="image/*">
                    <span class="error"><?php echo $bimag_err; ?></span>
                </div>
                <div class="form-group">
                    <button type="submit" name="update">Update Blog</button>
                </div>
                <div class="form-group">
                    <input type="hidden" name="bid" value="<?php echo $bid; ?>">
                    <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this blog?');">Delete Blog</button>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <!-- JavaScript for character counters -->
    <script>
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

        // Initialize counts on page load
        document.addEventListener('DOMContentLoaded', function() {
            btitleCount.textContent = btitleInput.value.length;
            bintroCount.textContent = bintroInput.value.length;
            bdescCount.textContent = bdescInput.value.length;
        });
    </script>
</body>
</html>