<!DOCTYPE html>
<html lang="en">
<head>
    <title>TDHRC - BLOG Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('../visuals/images/gal.jpg'); /* Path to your background image in the "images" folder */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center; /* Center align text */
        }

        .gallery-details {
            max-width: 800px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent background */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            position: relative; /* Added for positioning the back button */
        }

        .back-button {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .gallery-details img {
            width: 100%;
            height: auto;
            margin-bottom: 20px;
            border-radius: 10px; /* Optional: rounded corners for the image */
        }

        .gallery-details h2, .gallery-details p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="gallery-details">
        <a href="javascript:history.back()" class="back-button">Back</a>
        <?php
        $servername = "localhost";
        $username = "pirccorg_tdhrcadmin";
        $password = "W(=@h}IR&!qv";
        $dbname = "pirccorg_tdhrc";
        $basePath = "/visuals/assets/"; // Adjust the base path as needed

        try {
            $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if 'bid' parameter is provided in the URL
            if (isset($_GET['bid'])) {
                $bid = $_GET['bid'];
                
                // Prepare SQL statement to fetch blog details by 'bid'
                $stmt = $pdo->prepare("SELECT bid, btitle, bintro, bdesc, bimag FROM blogs WHERE bid = :bid");
                $stmt->bindParam(':bid', $bid, PDO::PARAM_INT);
                $stmt->execute();

                $details = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($details) {
                    // Display blog details
                    echo '<img src="' . $basePath . $details['bimag'] . '" alt="Gallery Image" class="gallery-image">';
                    echo '<h2 style="text-align: center;">' . htmlspecialchars($details['btitle']) . '</h2>';
                    echo '<p style="text-align: justify;">' . htmlspecialchars($details['bintro']) . '</p>';
                    echo '<p style="text-align: justify;">' . htmlspecialchars($details['bdesc']) . '</p>';
                } else {
                    // No blog found for the provided 'bid'
                    echo 'Image details not found for ID ' . $bid;
                }
            } else {
                // 'bid' parameter is not provided in the URL
                echo 'ID not provided in the URL.';
            }

        } catch (PDOException $e) {
            // Catch any PDO errors and display the message
            echo "Error: " . $e->getMessage();
        }
        ?>
    </div>
</body>
</html>
