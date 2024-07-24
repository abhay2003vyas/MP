<?php
require 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        $email_pattern = '/^[a-zA-Z0-9._%+-]+@bitwardha\.ac\.in$/';
        if (!preg_match($email_pattern, $email)) {
            $error_message = "Please enter a valid email address ending with @bitwardha.ac.in.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                $error_message = "Error: " . $sql . "<br>" . $conn->error;
            }

            $stmt->close();
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page | BIT Service</title>
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
            width: 400px;
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

        .input-group input {
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
            background-color: #00bcd4;
        }

        .toggle-link {
            text-align: center;
            cursor: pointer;
            color: #00bcd4;
            margin-top: 10px;
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
                <li><a href="login.php"><button class="signin-button">Sign In</button></a></li>
            </ul>
            <div class="icon menu-btn">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>
    <div class="login-container">
        <div class="form-container">
            <form class="signup-form" action="signup.php" method="POST" onsubmit="return validateEmail()">
                <h2>Sign Up</h2>
                <?php if (isset($error_message)): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php endif; ?>
                <div class="input-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="input-group">
                    <label for="confirm-password">Confirm Password:</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                </div>
                <button type="submit">Sign Up</button>
            </form>
            <div class="toggle-link">
                <a href="login.php">Already have an account? Login</a>
            </div>
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
        function validateEmail() {
            const emailInput = document.getElementById('email');
            const emailPattern = /^[a-zA-Z0-9._%+-]+@bitwardha\.ac\.in$/;

            if (!emailPattern.test(emailInput.value)) {
                alert('Please enter a valid email address ending with @bitwardha.ac.in');
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }
    </script>
</body>

</html>
