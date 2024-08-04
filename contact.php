<?php
// Database connection parameters
$servername = "localhost";
$username = "pirccorg_tdhrcadmin";
$password = "W(=@h}IR&!qv";
$dbname = "pirccorg_tdhrc";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input data
function sanitize_input($data) {
    global $conn;
    $data = htmlspecialchars(trim($data));
    return $conn->real_escape_string($data);
}

// Function to validate email format
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to validate phone number format
function validate_phone($phone) {
    // Check if the phone number is numeric and starts with '01'
    return (strlen($phone) == 11 && substr($phone, 0, 2) == '01' && is_numeric($phone));
}

// Handling form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $phone = sanitize_input($_POST['phone']);
    $subject = sanitize_input($_POST['subject']);
    $message_text = sanitize_input($_POST['message']);

    // Validate phone number
    if (!validate_phone($phone)) {
        $message = "<p class='error-message'>Invalid phone number format. Must be 11 digits starting with '01'.</p>";
    } elseif (!validate_email($email)) {
        $message = "<p class='error-message'>Invalid email format</p>";
    } else {
        // Prepare and execute the database query
        $stmt = $conn->prepare("INSERT INTO contactus (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message_text);

        if ($stmt->execute()) {
            $message = "<p class='success-message'>Message sent successfully!</p>";
        } else {
            $message = "<p class='error-message'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }
}
?>

<?php include('topnav.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TDHRC - Contact us</title>
    <link rel="stylesheet" href="css/contact.css">
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9; /* Example background color */
        }

        /* Banner styles */
        .banner {
            position: relative;
            text-align: center;
            margin-bottom: 20px;
        }

        .banner img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .banner-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 24px;
            font-weight: bold;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 10px;
            text-align: center; /* Center text horizontally within the banner */
        }

        /* Container for the contact form */
        .contact-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            max-width: 1400px; /* Adjusted max-width for larger container */
            width: 100%;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin: 20px auto;
            height: auto; /* Allow container to adjust height on smaller screens */
            padding: 20px;
            box-sizing: border-box;
        }

        /* Left column (contact form or iframe) */
        .left-column, .right-column {
            flex: 1;
            min-width: 300px;
            margin: 10px;
            padding: 20px;
            box-sizing: border-box;
        }

        /* Specific styles for the right column */
        .right-column {
            background-color: #f8f8f8;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            box-sizing: border-box;
        }

        .right-column h2 {
            margin-top: 0;
            text-align: center; /* Center align the heading on mobile */
        }

        .right-column p {
            margin: 10px 0;
        }

        /* Styles for form elements */
        .contact-form {
            display: flex;
            flex-direction: column;
        }

        .contact-form label {
            margin: 10px 0 5px;
            font-weight: bold;
        }

        .contact-form input,
        .contact-form textarea {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        .contact-form textarea {
            resize: vertical; /* Allow textarea to be resized vertically */
        }

        .contact-form button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .contact-form button:hover {
            background-color: #45a049;
        }

        /* Responsive design for smaller screens */
        @media (max-width: 768px) {
            .contact-container {
                flex-direction: column;
                height: auto; /* Allow container to adjust height on smaller screens */
            }

            .left-column, .right-column {
                flex: 1;
            }

            .right-column {
                padding: 20px; /* Reduce padding on smaller screens */
            }
        }

        /* Additional styles specific to embedded iframes */
        iframe {
            max-width: 100%; /* Make sure the embedded iframe is responsive */
            height: 100%; /* Ensure the iframe fills its container */
        }

        /* Message styles */
        .error-message {
            color: red;
            font-weight: bold;
        }

        .success-message {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Banner -->
    <div class="banner">
        <img src="assets/ContactHero.jpg" alt="Banner Image">
        <div class="banner-text">CONTACT US</div>
    </div>

    <div class="contact-container">
        <div class="left-column">
            <h2>Contact Form</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="contact-form">
                <label for="name">Name</label>
                <input type="text" id="name" placeholder="John Doe" name="name" required>

                <label for="email">Email</label>
                <input type="email" id="email" placeholder="john@gmail.com" name="email" required>

                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" placeholder="017XXXXXXXX" pattern="01[0-9]{9}" title="Enter 11 digits starting with '01'" required>

                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" required>

                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" required></textarea>

                <button type="submit">Submit</button>
            </form>
            <div class="message-container">
                <?php echo $message; ?>
            </div>
        </div>
        <div class="right-column">
            <h2>Contact Details</h2>
            <p><strong>House:</strong><br> House no - 105, 24-Agamasi lane, Bongshal, Dhaka-1100</p>
            <p><strong>Cell:</strong><br> +8801757818973; +8801608723720</p>
            <p><strong>Email:</strong><br> support@tdhrc.org</p>
        </div>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
