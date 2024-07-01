<?php
session_start();
include_once 'config.php';

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mengambil donasi berdasarkan kategori
$categories = ['Makanan', 'Pakaian', 'Obat - Obatan', 'Lainnya'];
$donations = [];

foreach ($categories as $category) {
    $stmt = $conn->prepare("SELECT * FROM donasi WHERE kategori = ?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
    $donations[$category] = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebutuhan Donasi - E-Charity</title>
    <link rel="stylesheet" href="gaya/listdonasi.css">
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
        <main>
            <section class="donations-section">
                <h2>Hasil Donasi</h2>

                <?php foreach ($categories as $category): ?>
                    <div class="category">
                        <h3><?php echo htmlspecialchars($category); ?></h3>
                                    <?php if (!empty($donations[$category])): ?>
                                        <?php foreach ($donations[$category] as $donation): ?>
                                            <div class="donation-item">
                                                <div class="donation-image">
                                                    <img src="<?php echo htmlspecialchars($donation['gambar']); ?>" alt="Donation Image">
                                                </div>
                                                <div class="donation-details">
                                                    <h4><?php echo htmlspecialchars($donation['nama']); ?></h4>
                                                    <p>Detail: <?php echo htmlspecialchars($donation['detail']); ?></p>
                                                    <p>Jumlah: <?php echo intval($donation['jumlah']); ?></p>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p>No donations in this category.</p>
                                    <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </section>
        </main>
    </div>

</body>
</html>
