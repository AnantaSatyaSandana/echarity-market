<?php
session_start();

if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit();
}

include_once 'config.php';

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$loggedInUser = $_SESSION['username'];

// Fetch user details from users table
$userDetailsSql = "SELECT nama, alamat, telephone FROM users WHERE username='$loggedInUser'";
$userDetailsResult = $conn->query($userDetailsSql);

$userDetails = [];
if ($userDetailsResult->num_rows > 0) {
    $userDetails = $userDetailsResult->fetch_assoc();
    $userDetails['nama'] = !empty($userDetails['nama']) ? $userDetails['nama'] : '-';
    $userDetails['alamat'] = !empty($userDetails['alamat']) ? $userDetails['alamat'] : '-';
    $userDetails['telephone'] = !empty($userDetails['telephone']) ? $userDetails['telephone'] : '-';
} else {
    $userDetails = ['nama' => '-', 'alamat' => '-', 'telephone' => '-'];
}

// Fetch donations from galangdonasi table
$sql = "SELECT *, DATEDIFF(deadline, CURDATE()) AS days_left FROM galangdonasi WHERE username='$loggedInUser'";
$result = $conn->query($sql);

$donations = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $donations[] = $row;
    }
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
                <div class="profile-info">
                    <div class="profile-img">
                        <img src="echarity.jpg" alt="Profile Image">
                    </div>
                    <div class="profile-details">
                        <h3><?php echo htmlspecialchars($loggedInUser); ?></h3>
                        <p>Nama: <?php echo htmlspecialchars($userDetails['nama']); ?></p>
                        <p>Alamat: <?php echo htmlspecialchars($userDetails['alamat']); ?></p>
                        <p>Telepon: <?php echo htmlspecialchars($userDetails['telephone']); ?></p>
                    </div>
                </div>
            </div>
            <div class="supported-donations-section">
                <h2>Galang Donasi Didukung</h2>
                <?php foreach ($donations as $donation): ?>
                <a href="1listdonasibarang.php?id=<?php echo urlencode($donation['id']); ?>">
                    <div class="donation-card">
                        <div class="donation-img">
                            <img src="<?php echo htmlspecialchars($donation['image']); ?>" alt="Donation Image">
                        </div>
                        <div class="donation-details">
                            <h3><?php echo htmlspecialchars($donation['title']); ?></h3>
                            <p>Penggalang: <?php echo htmlspecialchars($donation['username']); ?></p>
                            <p>Sisa Hari: <?php echo intval($donation['days_left']); ?></p>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
