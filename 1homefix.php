<?php
session_start();
include_once 'config.php';

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the latest donation entries
$sql = "SELECT * FROM galangdonasi ORDER BY created_at DESC LIMIT 10"; // Change the limit as needed
$result = $conn->query($sql);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Charity</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">
    <link rel="stylesheet" href="gaya/home.css">
    <style>
        /* Donation entry styling */
        .donation-entry {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p>E-Charity</p>
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
        <?php if ($result->num_rows > 0): ?>
            <?php while($donation = $result->fetch_assoc()): ?>
            <div class="donation-wrapper">
                <div class="donation-entry">
                    <div class="header">
                        <h1><?php echo htmlspecialchars($donation['title']); ?></h1>
                    </div>
                    <div class="form-section">
                        <div class="form-group image-upload">
                            <a href="1listdonasi.php">
                                <img class="donation-image" src="<?php echo htmlspecialchars($donation['image']); ?>" alt="Donation Image">
                            </a>
                        </div>
                        <div class="form-group">
                            <h2>Cerita Penggalangan Donasi</h2>
                            <p><?php echo nl2br(htmlspecialchars($donation['story'])); ?></p>
                        </div>
                    </div>
                    <div class="profile-section">
                        <a href="1showprofilgalang.php?galang_donasi_id=<?php echo htmlspecialchars($donation['id']); ?>">
                            <h2>Penggalang Donasi</h2>
                        </a>
                        <div class="profile">
                            <div class="profile-picture">
                                <a href="1showprofilgalang.php?galang_donasi_id=<?php echo htmlspecialchars($donation['id']); ?>">
                                    <img src="echarity.jpg" alt="Profile Image">
                                </a>
                            </div>
                            <div class="profile-info">
                                <h3><?php echo htmlspecialchars($donation['username']); ?></h3>
                                <p>Identitas Terverifikasi</p>
                            </div>
                        </div>
                    </div>
                    <div class="donation-section">
                        <a href="1listdonasi.php"><h2>Kebutuhan Donasi</h2></a>
                        <div class="donation-categories">
                            <div class="donation-category">
                                <h3>Makanan</h3>
                                <p><?php echo htmlspecialchars($donation['needs_food']); ?></p>
                                <a href="1formdonasi.php?kategori=Makanan"><button class="donate-button">Donasi Sekarang</button></a>
                            </div>
                            <div class="donation-category">
                                <h3>Pakaian</h3>
                                <p><?php echo htmlspecialchars($donation['needs_clothes']); ?></p>
                                <a href="1formdonasi.php?kategori=Pakaian"><button class="donate-button">Donasi Sekarang</button></a>
                            </div>
                            <div class="donation-category">
                                <h3>Obat - Obatan</h3>
                                <p><?php echo htmlspecialchars($donation['needs_medicine']); ?></p>
                                <a href="1formdonasi.php?kategori=Obat-Obatan"><button class="donate-button">Donasi Sekarang</button></a>
                            </div>
                            <div class="donation-category">
                                <h3>Lainnya</h3>
                                <p><?php echo htmlspecialchars($donation['needs_others']); ?></p>
                                <a href="1formdonasi.php?kategori=Lainnya"><button class="donate-button">Donasi Sekarang</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="deadline-section">
                        <h2>Deadline</h2>
                        <p><?php echo htmlspecialchars($donation['deadline']); ?></p>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
        <p>No donations found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
