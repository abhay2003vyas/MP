<?php
require 'connect.php';
session_start();

$error_message = "";
$success_message = "";
$showProfile = isset($_SESSION['user_id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect user to login page
        header("Location: login.php?redirect=electric.php");
        exit();
    }

    $instrument_no = $_POST['instrument_no'];
    $department = $_POST['department'];
    $location = $_POST['location'];
    $name = $_POST['name'];
    $branch = $_POST['branch'];
    $prn_no = $_POST['prn_no'];
    $complaint_description = $_POST['complaint_description'];

    // Insert complaint details into database
    $sql = "INSERT INTO electric (instrument_no, department, location, name, branch, prn_no, complaint_description) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssssss", $instrument_no, $department, $location, $name, $branch, $prn_no, $complaint_description);
        if ($stmt->execute()) {
            $success_message = "Complaint submitted successfully.";
        } else {
            $error_message = "Failed to submit complaint. Please try again.";
        }
        $stmt->close();
    } else {
        $error_message = "Failed to prepare the SQL statement.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Complaint | BIT Service</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        .login-container {
            padding: 200px 100px 150px 100px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            width: 600px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
        }

        .input-group input,
        .input-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: green;
        }
        @media (max-width: 768px) {
            .login-container {
                padding: 100px 20px 50px 20px;
            }

            .form-container {
                width: 100%;
                padding: 15px;
                border: none;
                box-shadow: none;
            }
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 10px;
            }

            .form-container h2 {
                font-size: 1.5em;
                margin-bottom: 15px;
            }

            .input-group input,
            .input-group textarea {
                padding: 8px;
                font-size: 0.9em;
            }

            .form-container button {
                padding: 8px;
                font-size: 0.9em;
            }
        }
    </style>
</head>

<body>
<nav class="navbar">
    <div class="content">
        <div class="logo">
            <a href="#">BIT <span>service</span></a>
        </div>
        <ul class="menu-list">
            <div class="icon cancel-btn">
                <i class="fas fa-times"></i>
            </div>
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php#about">About</a></li>
            <li><a href="index.php#complaints">Complaints</a></li>
            <?php if ($showProfile): ?>
                <li><a href="profile.php">My Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="signup.php"><button class="signin-button">Sign Up</button></a></li>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
        <div class="icon menu-btn">
            <i class="fas fa-bars"></i>
        </div>
    </div>
</nav>
<div class="login-container">
    <div class="form-container">
        <form class="login-form" action="electric.php" method="POST" onsubmit="return checkLoginStatus()">
            <h2>Electrical Instrument Complaint</h2>
            <?php if (!empty($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php elseif (!empty($success_message)): ?>
                <p style="color: green;"><?php echo $success_message; ?></p>
            <?php endif; ?>
            <div class="input-group">
                <label for="instrument_no">Instrument No:</label>
                <input type="text" id="instrument_no" name="instrument_no" required>
            </div>
            <div class="input-group">
                <label for="department">Department:</label>
                <input type="text" id="department" name="department" required>
            </div>
            <div class="input-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" required>
            </div>
            <h2>Student Details</h2>
            <div class="input-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="input-group">
                <label for="branch">Branch:</label>
                <input type="text" id="branch" name="branch" required>
            </div>
            <div class="input-group">
                <label for="prn_no">PRN No.:</label>
                <input type="text" id="prn_no" name="prn_no" required>
            </div>
            <div class="input-group">
                <label for="complaint_description">Complaint Description:</label>
                <textarea id="complaint_description" name="complaint_description" required></textarea>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</div>
<footer class="footer">
    <p>&copy; 2024 BIT Service. All rights reserved.</p>
    <div class="footer-links">
        <a href="#">Privacy Policy</a>
        <a href="#">Terms of Service</a>
        <a href="#">Contact Us</a>
    </div>
</footer>
<script>
    function checkLoginStatus() {
        <?php if (!isset($_SESSION['user_id'])): ?>
            alert("Please log in to submit a complaint.");
            window.location.href = "login.php?redirect=electric.php";
            return false;
        <?php endif; ?>
        return true;
    }
    document.addEventListener('DOMContentLoaded', function() {
        // Function to parse URL parameters
        function getUrlParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }

        // Fill form fields with data from QR code if available
        var qrData = getUrlParameter('qrdata');
        if (qrData) {
            try {
                var decodedData = JSON.parse(qrData);
                // Autofill form fields
                document.getElementById('instrument_no').value = decodedData['Instrument no'] || '';
                document.getElementById('department').value = decodedData.Department || '';
                document.getElementById('location').value = decodedData.Location || '';
            } catch (error) {
                console.error('Error parsing JSON data:', error);
            }
        }
    });
</script>
<script type="text/javascript" src="script.js"></script>
</body>

</html>
