<?php
// Start the session
session_start();

// Database configuration
include_once 'config.php';

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM sign_in WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Password is correct, start a new session
            $_SESSION['username'] = $username;

            // Redirect to the home page
            header("Location: 1homefix.php");
            exit();
        } else {
            $error_message = 'Incorrect password.';
        }
    } else {
        $error_message = 'No account found with that username.';
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Login</header>
            <?php
            if (!empty($error_message)) {
                echo '<p style="color:red;">' . htmlspecialchars($error_message) . '</p>';
            }
            ?>
            <form action="index.php" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>
                <div class="field">
                    <input type="submit" class="btn" value="Login">
                </div>
                <div class="links">
                    Don't have an account? <a href="register.html">Sign Up Here</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
