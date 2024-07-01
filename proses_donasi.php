<?php
session_start();
include_once 'config.php';

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$galang_donasi_id = $_POST['galang_donasi_id'];
$nama_barang = $_POST['item_name'];
$detail = $_POST['details'];
$jumlah = $_POST['amount'];
$kategori = $_POST['kategori'];
$username = $_POST['username'];

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is an actual image or fake image
$check = getimagesize($_FILES["image"]["tmp_name"]);
if ($check !== false) {
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    $gambar = $target_file;
} else {
    $gambar = NULL;
}

// Check if galang_donasi_id exists in galangdonasi table
$check_id_sql = "SELECT id FROM galangdonasi WHERE id = '$galang_donasi_id'";
$result = $conn->query($check_id_sql);

if ($result->num_rows > 0) {
    // Insert into database
    $sql = "INSERT INTO donasi (galang_donasi_id, nama, gambar, detail, jumlah, kategori, username)
            VALUES ('$galang_donasi_id', '$nama_barang', '$gambar', '$detail', '$jumlah', '$kategori', '$username')";

    if ($conn->query($sql) === TRUE) {
        echo "Donasi berhasil ditambahkan!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Error: galang_donasi_id tidak ditemukan.";
}

$conn->close();

header("Location: 1homefix.php"); // Replace with your actual form page URL
exit();
?>
