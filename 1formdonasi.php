<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Charity</title>
    <link rel="stylesheet" href="gaya/formdonasi.css">
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
            <div class="form-header">
                <a href="1homefix.php"><button class="back-button">&larr;</button></a>
                <h2 id="tab-title">Berikan Donasi</h2>
            </div>

            <?php
            session_start();
            // Ambil kategori dari URL jika tersedia
            $kategori = isset($_GET['kategori']) ? htmlspecialchars($_GET['kategori']) : '';
            // Ambil username dari sesi jika tersedia
            $username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '';
            ?>

            <form class="donation-form" action="proses_donasi.php" method="post" enctype="multipart/form-data">
                <label for="image">Gambar</label>
                <div class="input-box image-box">
                    <input type="file" id="image" name="image" accept="image/*" onchange="loadFile(event)">
                    <img id="output" src="#" alt="Image Preview" style="display:none; width: 100px; height: 100px;"/>
                    <span>Add Image</span>
                </div>

                <label for="item-name">Nama Barang</label>
                <div class="input-box">
                    <input type="text" id="item-name" name="item_name" required>
                </div>

                <label for="details">Detail</label>
                <div class="input-box">
                    <input type="text" id="details" name="details" required>
                </div>

                <label for="amount">Jumlah</label>
                <div class="input-box">
                    <input type="number" id="amount" name="amount" required>
                </div>

                <!-- Input untuk menyimpan kategori -->
                <input type="hidden" name="kategori" value="<?php echo $kategori; ?>">
                
                <!-- Input untuk menyimpan username dari sesi -->
                <input type="hidden" name="username" value="<?php echo $username; ?>">

                <!-- Input untuk menyimpan ID galang donasi -->
                <input type="hidden" name="galang_donasi_id" value="ID_GALANG_DONASI">
                <button type="submit" class="donate-button">Donasi Sekarang</button>
            </form>
        </div>
    </div>
    <script>
        function loadFile(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.style.display = 'block';
        }
    </script>
</body>
</html>
