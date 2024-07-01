<?php
session_start(); // Start the session (if not already started)

include_once 'config.php';

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check if the user is logged in and retrieve their username
if (!isset($_SESSION['username'])) {
    die("User not logged in");
}
$logged_in_username = $_SESSION['username'];


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind SQL statement
$stmt = $conn->prepare("INSERT INTO users (username, nama, alamat, telephone) VALUES (?, ?, ?, ?) 
                        ON DUPLICATE KEY UPDATE nama = VALUES(nama), alamat = VALUES(alamat), telephone = VALUES(telephone)");
$stmt->bind_param("ssss", $logged_in_username, $nama, $alamat, $telephone);

// Set parameters and execute
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$telephone = $_POST['telephone'];

if ($stmt->execute()) {
    $_SESSION['message'] = "Data telah tersimpan";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Error: " . $stmt->error;
    $_SESSION['message_type'] = "error";
}

$stmt->close();
$conn->close();

// Redirect back to the form page
header("Location: 1akun.php"); // Replace with your actual form page URL
exit();
?>
