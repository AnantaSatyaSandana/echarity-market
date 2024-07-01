<?php
session_start();
// Database configuration
include_once 'config.php';

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Charity</title>
    <link rel="stylesheet" href="gaya/akun.css">
    <style>
        .nav .right-links {
            display: flex;
            align-items: center;
        }

        .nav .right-links span {
            margin-right: 10px;
        }

        .nav .right-links .btn {
            margin-left: 10px;
            padding: 5px 10px;
        }
    </style>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <a href="1homefix.php"><p>E-Charity</p></a>
        </div>

        <div class="right-links">
            <?php
            if (isset($_SESSION['username'])) {
                echo '<span>Welcome, ' . htmlspecialchars($_SESSION['username']) . '</span>';
                echo '<a href="1akun.php"><button class="btn">Akun Saya</button></a>';
                echo '<a href="logout.php"><button class="btn">Logout</button></a>';
            } else {
                echo '<a href="index.php"><button class="btn">Login</button></a>';
            }
            ?>
        </div>
    </div>
    <div class="container">
        <div class="content">
            <div class="form-header">
                <a href="1homefix.php"><button class="back-button">&larr;</button></a>
                <h2 id="tab-title">Akun Saya</h2>
            </div>
            <div class="tab-bar">
                <a href="1akun.php"><button class="tab-button active" onclick="openTab(event, 'akun-saya')">Akun Saya</button></a>
                <a href="1akundonasi.php"><button class="tab-button" onclick="openTab(event, 'donasi')">Donasi</button></a>
                <a href="1profilgalang.php"><button class="tab-button" onclick="openTab(event, 'profil-galang')">Profil Galang Donasi</button></a>
            </div>
            <?php
            if (isset($_SESSION['message'])) {
                $message_type = isset($_SESSION['message_type']) ? $_SESSION['message_type'] : 'info';
                $message_class = '';
                if ($message_type === 'success') {
                    $message_class = 'success-message';
                } elseif ($message_type === 'error') {
                    $message_class = 'error-message';
                }
                echo '<div class="message ' . $message_class . '">' . $_SESSION['message'] . '</div>';
                unset($_SESSION['message']); // Clear the message after displaying
                unset($_SESSION['message_type']);
            }
            ?>
        
            <div id="akun-saya" class="tab-content active">
                <form class="user-form" action="save_user.php" method="post">
                    <!-- Your form fields -->
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" required>
                
                    <label for="alamat">Alamat</label>
                    <input type="text" id="alamat" name="alamat" required>
                
                    <label for="telephone">No. Telepon</label>
                    <input type="tel" id="telephone" name="telephone" required>
                
                    <button type="submit" class="save-button">Simpan</button>
                </form>
                
                
                <div class="join-link">
                    <p>Mau Galang Donasi? <a href="1homegalang.html">Bergabung Disini</a></p>
                </div>
            </div>
            <div id="donasi" class="tab-content">
                <h3>Donasi</h3>
                <p>Content for Donasi.</p>
            </div>
            <div id="dikirim" class="tab-content">
                <h3>Dikirim</h3>
                <p>Content for Dikirim.</p>
            </div>
            <div id="selesai" class="tab-content">
                <h3>Selesai</h3>
                <p>Content for Selesai.</p>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
