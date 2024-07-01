<?php
session_start(); // Start the session (if not already started)

// Check if the user is logged in and retrieve their username
if (!isset($_SESSION['username'])) {
    die("User not logged in");
}
$logged_in_username = $_SESSION['username'];

include_once 'config.php';

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute SQL statement to fetch user details
$stmt = $conn->prepare("SELECT username, nama, alamat, telephone FROM users WHERE username = ?");
$stmt->bind_param("s", $logged_in_username);
$stmt->execute();
$stmt->bind_result($username, $nama, $alamat, $telephone);
$stmt->fetch();
$stmt->close();
$conn->close();
?>
