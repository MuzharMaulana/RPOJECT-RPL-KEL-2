<?php
session_start(); // Mulai sesi

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Jika sudah login, tampilkan dashboard
include 'config.php'; // Pastikan ini termasuk sebelum query database

// Ambil semua kategori dari database untuk dropdown
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

// Ambil catatan
$notesResult = $conn->query("SELECT notes.*, categories.nama_kategori FROM notes LEFT JOIN categories ON notes.kategori_id = categories.id ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Catatan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"> <!-- Ikon Font Awesome -->
    <style>
        body {
            background-color: #f4f4f4;
        }
        .sidebar {
            height: 100vh;
            padding: 20px;
            background-color: #343a40;
            position: fixed;
        }
        .sidebar h2 {
            color: white;
            font-size: 1.5rem;
            margin-bottom: 30px;
        }
        .sidebar ul {
            padding: 0;
            list-style-type: none;
        }
        .sidebar ul li {
            margin: 15px 0;
        }
        .sidebar ul li a {
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            display: block;
            transition: background-color 0.3s;
        }
        .sidebar ul li a:hover {
            background-color: #4d4957;
        }
        .content {
            margin-left: 250px; /* Space for the sidebar */
            padding: 30px;
        }
        .card-category {
            border: 1px solid #007bff;
            border-radius: 10px;
            transition: transform 0.2s;
            margin: 10px 0;
        }
        .card-category:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }
        .btn-custom {
            border-radius: 25px;
        }
        .note-card {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar float-left">
        <h2>Menu</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="add_note.php">Tambah Catatan</a></li>
            <li><a href="logout.php">Keluar</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content float-right" style="width: calc(100% - 250px);">
        <h2 class="mt-4">Selamat Datang di Dashboard Catatan</h2>
        <p class="lead">Pilih kategori untuk melihat catatan Anda:</p>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card card-category">
                    <div class="card-body text-center">
                        <h5 class="card-title">Kuliah</h5>
                        <p class="card-text">Lihat semua catatan kuliah Anda.</p>
                        <a href="kuliah.php" class="btn btn-primary btn-custom">Lihat Kategori</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-category">
                    <div class="card-body text-center">
                        <h5 class="card-title">Kantor</h5>
                        <p class="card-text">Lihat semua catatan kantor Anda.</p>
                        <a href="kantor.php" class="btn btn-primary btn-custom">Lihat Kategori</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-category">
                    <div class="card-body text-center">
                        <h5 class="card-title">Pribadi</h5>
                        <p class="card-text">Lihat semua catatan pribadi Anda.</p>
                        <a href="pribadi.php" class="btn btn-primary btn-custom">Lihat Kategori</a>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="mt-4">Catatan Terakhir:</h4>
        <div id="savedNotes">
            <?php if ($notesResult && $notesResult->num_rows > 0): ?>
                <?php while ($note = $notesResult->fetch_assoc()): ?>
                    <div class="card note-card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $note['judul']; ?></h5>
                            <p class="card-text"><?php echo $note['catatan']; ?></p>
                            <p><strong>Kategori:</strong> <?php echo $note['nama_kategori']; ?></p>
                            <p><strong>Tanggal:</strong> <?php echo $note['tanggal']; ?></p>
                            <div class="d-flex justify-content-between">
                                <a href="edit_note.php?id=<?php echo $note['id']; ?>" class="btn btn-warning btn-custom">Edit</a>
                                <a href="hapus_note.php?id=<?php echo $note['id']; ?>" class="btn btn-danger btn-custom">Hapus</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="alert alert-warning" role="alert">
                    Tidak ada catatan ditemukan.
                </div>
            <?php endif; ?>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>