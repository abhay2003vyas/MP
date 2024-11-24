<?php
session_start();

// Check if user is logged in
$showProfile = isset($_SESSION['user_id']);

// Check if the user clicked logout
if (isset($_GET['logout'])) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session.
    session_destroy();

    // Redirect to the login page
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<!-- Created By CodingNepal - www.codingnepalweb.com -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sticky Navigation Bar | CodingNepal</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
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
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#complaints">Complaints</a></li>
                <?php if ($showProfile): ?>
                    <li><a href="cms/user/profile.php">My Profile</a></li>
                <?php else: ?>
                    <li><a href="signup.php"><button class="signin-button">Sign Up</button></a></li>
                <?php endif; ?>
                <?php if ($showProfile): ?>
                    <li><a href="?logout=true">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
            <div class="icon menu-btn">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>
    <div class="carousel" id="home">
        <div class="carousel-inner">
            <div class="carousel-item">
                <img src="img/image1.jpg" alt="Image 1">
            </div>
            <div class="carousel-item">
                <img src="img/image2.jpg" alt="Image 2">
            </div>
            <div class="carousel-item">
                <img src="img/image3.jpg" alt="Image 3">
            </div>
        </div>
    </div>
    <div class="about" id="about">
        <div class="content reveal">
            <div class="title">How Does BIT Maintenance Management Software Benefit Our College?</div>
            <p>A BIT Maintenance Management Software (BIT MMS) streamlines your college's maintenance by centralizing
                data,
                automating workflows, and facilitating communication. This translates to faster response times, reduced
                downtime, and improved equipment lifespans, ultimately saving your college time, money, and resources.
            </p>
            <p>BIT MMS promotes safety by facilitating compliance with regulations and documenting safety procedures. It
                even streamlines accident reporting, allowing for better incident prevention. In short, BIT MMS empowers
                your college to move from reactive repairs to proactive maintenance, creating a more efficient,
                cost-effective, and safe learning environment for everyone.</p>
        </div>
    </div>
    <div class="about reveal" id="complaints">
        <h4>Register a Complaint ?</h4>
    </div>
    <div class="card-list reveal">

        <a href="computer.php" class="card-item reveal">
            <img src="img/image4.jpg" alt="Card Image">
            <span class="developer">Type 1</span>
            <h3>A "Computer" related complaints.</h3>
            <div class="arrow">
                <i class="fas fa-arrow-right card-icon"></i>
            </div>
        </a>
        <a href="furniture.php" class="card-item reveal">
            <img src="img/image5.jpg" alt="Card Image">
            <span class="designer">Type 2</span>
            <h3>A "Furniture" related complaints.</h3>
            <div class="arrow">
                <i class="fas fa-arrow-right card-icon"></i>
            </div>
        </a>
        <a href="electric.php" class="card-item reveal">
            <img src="img/image6.jpg" alt="Card Image">
            <span class="editor">Type 3</span>
            <h3>An "Electrical" related complaints.</h3>
            <div class="arrow">
                <i class="fas fa-arrow-right card-icon"></i>
            </div>
        </a>

    </div>

    <footer class="footer">
        <p>&copy; 2024 BIT Service. All rights reserved.</p>
        <div class="footer-links">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
            <a href="#">Contact Us</a>
        </div>
    </footer>
    <script type="text/javascript" src="script.js"></script>
</body>

</html>
