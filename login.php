<?php
require 'connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, password FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "No user found with that username or email.";
    }

    $stmt->close();
}
if (isset($_GET['redirect'])) {
    $_SESSION['redirect'] = $_GET['redirect'];
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page | BIT Service</title>
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
        @media (max-width: 768px) {
            .login-container {
                padding: 100px 20px 150px 20px;
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
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php">My Profile</a></li>
                    <li><a href="login.php?logout=true">Logout</a></li>
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
            <form class="login-form" action="login.php" method="POST">
                <h2>Login</h2>
                <?php if (isset($error_message)): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php endif; ?>
                <div class="input-group">
                    <label for="username">Username or Email:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
            <div class="toggle-link">
                <a href="signup.php">Don't have an account? Sign Up</a>
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
    <script type="text/javascript" src="script.js"></script>
</body>

</html>