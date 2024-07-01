<?php
session_start();
include_once 'config.php';

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mendapatkan ID galang donasi dari URL atau parameter GET
$galang_donasi_id = isset($_GET['galang_donasi_id']) ? $_GET['galang_donasi_id'] : '';

// Debugging: Output the value of $galang_donasi_id


if ($galang_donasi_id) {
    // Initialize the $donations array
    $donations = array();

    // Query untuk mendapatkan informasi galang donasi beserta informasi penggalang donasi (users) dan days_left
    $sql = "SELECT gd.id, gd.image, gd.title, gd.username AS galang_username, u.nama, u.alamat, u.telephone,
                   DATEDIFF(gd.deadline, CURDATE()) AS days_left
            FROM galangdonasi gd
            LEFT JOIN users u ON gd.username = u.username
            WHERE gd.id = '$galang_donasi_id'";

    

    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            // Mendapatkan data galang donasi
            while ($row = $result->fetch_assoc()) {
                $donations[] = array(
                    'id' => $row['id'],
                    'image' => $row['image'],
                    'title' => $row['title'],
                    'galang_username' => $row['galang_username'],
                    'nama' => $row['nama'],
                    'alamat' => $row['alamat'],
                    'telephone' => $row['telephone'],
                    'days_left' => $row['days_left']
                );
            }
        } else {
            echo "Galang donasi tidak ditemukan.";
        }
    } else {
        echo "Query Error: " . $conn->error;
    }
} else {
    echo "Galang donasi ID tidak ditemukan. ID yang diberikan: " . htmlspecialchars($galang_donasi_id);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Charity</title>
    <link rel="stylesheet" href="gaya/profilgalang.css">
</head>
<body>
    <div class="nav">
        <div class="logo">
            <a href="1homefix.php"><p>E-Charity</p></a>
        </div>

        <div class="right-links">
            <a href="1akun.php"><button class="btn">Akun Saya</button></a>
        </div>
    </div>
    <div class="container">
        <div class="content">
            <div class="profile-section">
                <h2>Penggalang Donasi</h2>
                <?php if (!empty($donations)): ?>
                    <?php foreach ($donations as $donation): ?>
                    <div class="profile-info">
                        <div class="profile-img">
                            <img src="echarity.jpg" alt="Profile Image">
                        </div>
                        <div class="profile-details">
                            <h3><?php echo htmlspecialchars($donation['galang_username']); ?></h3>
                            <p>Nama: <?php echo htmlspecialchars($donation['nama']); ?></p>
                            <p>Alamat: <?php echo htmlspecialchars($donation['alamat']); ?></p>
                            <p>Telepon: <?php echo htmlspecialchars($donation['telephone']); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Data tidak tersedia.</p>
                <?php endif; ?>
            </div>

            <div class="about-section">
                <h2>Tentang Penggalang</h2>
                <p>Isi Deskripsi Penggalang Donasi</p>
            </div>

            <div class="supported-donations-section">
                <h2>Galang Donasi Didukung</h2>
                <?php if (!empty($donations)): ?>
                    <?php foreach ($donations as $donation): ?>
                    <div class="donation-card">
                        <div class="donation-img">
                            <img src="<?php echo htmlspecialchars($donation['image']); ?>" alt="Donation Image">
                        </div>
                        <div class="donation-details">
                            <h3><?php echo htmlspecialchars($donation['title']); ?></h3>
                            <p><?php echo htmlspecialchars($donation['galang_username']); ?></p>
                            <p>Sisa Hari: <?php echo intval($donation['days_left']); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Data tidak tersedia.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
