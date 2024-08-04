<?php include('topnav.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>TDHRC - Blogs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('visuals/images/gal.jpg'); /* Path to your background image in the "images" folder */
            margin: 0;
            padding: 0;
        }

        #Login-button {
            position: absolute;
            top: 20px;
            right: 10px;
            background-color: #ff6600;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        #Login-button:hover {
            background-color: #ff9933;
        }

        #book-button {
            position: absolute;
            top: 20px;
            right: 80px;
            background-color: #ff6600;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        #book-button:hover {
            background-color: #ff9933;
        }

        /* CSS styles for the gallery */
        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .gallery-item {
            max-width: 23%; /* Adjust the image size as needed */
            margin: 10px;
            text-align: center;
        }

        .gallery-item img {
            width: 100%;
            height: auto;
            cursor: pointer; /* Add cursor pointer to indicate the images are clickable */
        }

        .gallery-item p {
            margin-top: 5px;
            font-size: 16px;
            color: #333;
        }

        /* Styles for the modal (popup) */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            max-width: 80%;
            max-height: 80%;
            overflow: auto;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="gallery">
        <?php
        $servername = "localhost";
        $username = "pirccorg_tdhrcadmin";
        $password = "W(=@h}IR&!qv";
        $dbname = "pirccorg_tdhrc";
        $basePath = "visuals/assets/"; // Adjust the base path as needed

        try {
            $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("SELECT bid, bimag, btitle FROM blogs");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $row) {
                $imagePath = $basePath . $row['bimag'];

                // Check if the image file exists
                if (file_exists($imagePath)) {
                    echo '<div class="gallery-item">';
                    echo '<a href="homeblogdetails.php?bid=' . $row['bid'] . '">';
                    echo '<img src="' . $imagePath . '" alt="Gallery Image">';
                    echo '</a>';
                    echo '<p>' . htmlspecialchars($row['btitle']) . '</p>';
                    echo '</div>';
                } else {
                    echo '<p>Error: Image not found for ID ' . $row['bid'] . '</p>';
                }
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </div>
</body>
</html>
<?php include('footer.php'); ?>