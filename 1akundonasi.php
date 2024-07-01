<?php
session_start();
include_once 'config.php';

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get username from session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// Prepare and execute query to fetch donations for the logged-in user
$sql = $conn->prepare("SELECT * FROM donasi WHERE username = ?");
$sql->bind_param("s", $username);
$sql->execute();
$result = $sql->get_result();

// Initialize variable to store query results
$donations = array();

if ($result->num_rows > 0) {
    // Loop through each row in the result set
    while ($row = $result->fetch_assoc()) {
        // Add data to the $donations array
        $donations[] = array(
            'nama' => $row['nama'],
            'gambar' => $row['gambar'], // assuming you store the image path
            'detail' => $row['detail'],
            'jumlah' => $row['jumlah']
        );
    }
}

$sql->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donasi</title>
    <link rel="stylesheet" href="gaya/akundonasi.css">
    <style>
        .nav .logo p {
            font-size: 24px;
            margin: 0;
        }

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

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        .donations-section h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        .category {
            margin-bottom: 40px;
        }

        .category h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .donation-item {
            display: flex;
            align-items: center;
            border: 1px solid #e7e7e7;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }

        .donation-image {
            width: 100px;
            height: 100px;
            overflow: hidden;
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 5px;
            margin-right: 20px;
        }

        .donation-image img {
            width: 100%;
            height: 100%;
            object-fit: contain; /* This will ensure the image scales properly within the box */
        }

        .donation-details h4 {
            margin: 0;
            font-size: 18px;
        }

        .donation-details p {
            margin: 5px 0;
            color: #555;
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
                <h2 id="tab-title">Donasi</h2>
            </div>
            <div class="tab-bar">
                <a href="1akun.php"><button class="tab-button" onclick="openTab(event, 'akun-saya')">Akun Saya</button></a>
                <a href="1akundonasi.php"><button class="tab-button active" onclick="openTab(event, 'donasi')">Donasi</button></a>
                <a href="1profilgalang.php"><button class="tab-button" onclick="openTab(event, 'profil-galang')">Profil Galang Donasi</button></a>
            </div>
            <div id="akun-saya" class="tab-content">
                <h3>Akun Saya</h3>
            </div>
            <div id="donasi" class="tab-content active">
                <?php if (!empty($donations)): ?>
                    <div class="donation-list">
                        <?php foreach ($donations as $donation): ?>
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
                    </div>
                <?php else: ?>
                    <p>Anda belum melakukan donasi.</p>
                <?php endif; ?>
            </div>
            <div id="selesai" class="tab-content">
                <h3>Donasi Selesai</h3>
            </div>
            <div id="dikirim" class="tab-content">
                <h3>Dikirim</h3>
                <p>Content for Dikirim.</p>
            </div>
        </div>
    </div>
    <script>
        function loadFile(event) {
            var image = document.getElementById('output');
            var span = document.querySelector('.image-box span');
            image.src = URL.createObjectURL(event.target.files[0]);
            image.style.display = 'block';
            span.style.display = 'none';
            image.onload = function() {
                URL.revokeObjectURL(image.src) // free memory
            }
        }

        function openTab(event, tabId) {
            var i, tabcontent, tabbuttons;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].classList.remove("active");
            }
            tabbuttons = document.getElementsByClassName("tab-button");
            for (i = 0; i < tabbuttons.length; i++) {
                tabbuttons[i].classList.remove("active");
            }
            document.getElementById(tabId).classList.add("active");
            event.currentTarget.classList.add("active");
            document.getElementById('tab-title').innerText = event.currentTarget.innerText;
        }
    </script>
</body>
</html>
