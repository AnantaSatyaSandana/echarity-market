<?php
session_start();
include_once 'config.php';

$conn = new mysqli($servername, $db_username, $db_password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch donation data for each category
$categories = ["Makanan", "Pakaian", "Obat - Obatan", "Lainnya"];
$donations = [];

foreach ($categories as $category) {
    $sql = "SELECT nama, jumlah, username FROM donasi WHERE kategori = '$category' ORDER BY created_at DESC LIMIT 2";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $donations[$category][] = $row;
        }
    }
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
                <h2>Kebutuhan Donasi</h2>

                <?php foreach ($categories as $category): ?>
                    <div class="category">
                        <h3><?php echo htmlspecialchars($category); ?></h3>
                        <?php if (!empty($donations[$category])): ?>
                            <?php foreach ($donations[$category] as $index => $donation): ?>
                                <?php if ($index < 2): ?>
                                    <p><strong><?php echo htmlspecialchars($donation['username']); ?></strong> Memberikan <?php echo htmlspecialchars($donation['nama']); ?> sebanyak <strong><?php echo intval($donation['jumlah']); ?></strong>.</p>
                                    <?php endif; ?>
                            <?php endforeach; ?>
                            <a href="1formdonasi.php"><button class="cta-btn">Donasi Sekarang</button></a>
                        <?php else: ?>
                            <p>No donations in this category.</p>
                            <a href="1formdonasi.php"><button class="cta-btn">Donasi Sekarang</button></a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

            </section>
        </main>
    </div>
</body>
</html>
