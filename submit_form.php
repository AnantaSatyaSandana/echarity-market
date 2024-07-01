<?php
session_start(); // Start the session to access session variables

// Include database configuration
include_once 'config.php';

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the username is set in the session
if (!isset($_SESSION['username'])) {
    die("User not logged in.");
}

// Handle file upload
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO galangdonasi (image, title, story, needs_food, needs_clothes, needs_medicine, needs_others, deadline, username) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $image, $title, $story, $needs_food, $needs_clothes, $needs_medicine, $needs_others, $deadline, $username);

    // Set parameters and execute
    $image = $target_file;
    $title = $_POST['title'];
    $story = $_POST['story'];
    $needs_food = $_POST['needs_food'];
    $needs_clothes = $_POST['needs_clothes'];
    $needs_medicine = $_POST['needs_medicine'];
    $needs_others = $_POST['needs_others'];
    $deadline = $_POST['deadline'];
    $username = $_SESSION['username']; // Retrieve username from session

    $stmt->execute();

    // Redirect to home page
    header("Location: 1homefix.php");
    exit();
} else {
    echo "Sorry, there was an error uploading your file.";
}

$stmt->close();
$conn->close();
?>
