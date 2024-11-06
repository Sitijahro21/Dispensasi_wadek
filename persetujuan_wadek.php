<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Wakil Dekan III') {
    header('Location: login.php');
    exit();
}

include 'db.php';

// Sertakan file PHPMailer
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Fungsi untuk mengirim email konfirmasi
function sendApprovalEmail($email, $nama_lengkap) {
    $mail = new PHPMailer(true);
    try {
        // Konfigurasi SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Alamat SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'adriansyahsumitra@gmail.com'; // Alamat email Anda
        $mail->Password = 'kivu njcw rcam nkwl'; // Kata sandi email Anda
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->SMTPDebug = 3; // Gunakan level debug 3 atau 4 untuk output lebih terperinci

        // Pengaturan penerima
        $mail->setFrom('adriansyahsumitra@gmail.com', 'Wakil Dekan III');
        $mail->addAddress($email);

        // Konten email
        $mail->isHTML(true);
        $mail->Subject = "Konfirmasi Persetujuan Pengajuan Dispensasi";
        $mail->Body = "Halo $nama_lengkap,<br><br>Pengajuan dispensasi Anda telah disetujui. Anda dapat mengunduh surat dispensasi di akun Anda.<br><br>Terima kasih.";

        $mail->send();
        echo "Email berhasil dikirim.";
    } catch (Exception $e) {
        echo "Email gagal dikirim. Error: {$mail->ErrorInfo}";
    }
}

// Cek apakah tombol "Setuju" atau "Tolak" diklik
if (isset($_POST['approve']) || isset($_POST['reject'])) {
    $status = isset($_POST['approve']) ? 'disetujui' : 'ditolak';
    $id = $_POST['id'];
    
    // Update status di database
    $query = "UPDATE persetujuan SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    // Jika disetujui, kirimkan email konfirmasi
    if ($status == 'disetujui') {
        $email = $_POST['email'];
        $nama_lengkap = $_POST['nama_lengkap'];
        sendApprovalEmail($email, $nama_lengkap);
    }

    // Redirect ulang halaman untuk menghindari pengiriman ulang form
    header("Location: detail_pengajuan.php?id=$id");
    exit();
}

// Pastikan ID pengajuan ada di URL dan valid
if (!isset($_GET['id'])) {
    echo "ID pengajuan tidak ditemukan.";
    exit();
}

$id = $_GET['id'];
$query = "SELECT * FROM pengajuan WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$pengajuan = $result->fetch_assoc();

if (!$pengajuan) {
    echo "Pengajuan tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUDISMA - Dispensasi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #a3c1e0;
        }
        .sidebar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            transition: transform 0.3s ease;
        }
        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            margin-top: 150px;
            min-height: calc(100vh - 56px); 
        }
        .status.pending {
            color: orange;
        }
        .status.approved {
            color: green;
        }
        .status.rejected {
            color: red;
        }
        .main-content {
            margin-left: -200px;
            padding: 20px;
            margin-top: 150px; /* Adjust for dashboard header */
            min-height: calc(100vh - 56px); 
        }
        .btn.approve {
            background-color: green;
            color: white;
        }
        .btn.reject {
            background-color: red;
            color: white;
        }
        .card {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
        }
        .back-button {
            display: block;
            margin-top: 20px;
            text-align: center;
        }
        /* Gaya untuk ikon lampiran */
.fas.fa-file-alt {
    color: #343a40; /* Warna ikon dokumen */
    cursor: pointer;
}

/* Gaya status badge */
.status-badge {
    padding: 5px 10px;
    font-size: 0.8em;
    border-radius: 15px;
    color: white;
    display: inline-block;
    font-weight: bold;
}

.status-belum-diproses {
    background-color: orange;
}

.status-disetujui {
    background-color: green;
}

.status-ditolak {
    background-color: red;
}

/* Gaya tombol aksi */
.btn-success {
    background-color: green;
    border-color: green;
    font-size: 0.9em;
}

.btn-danger {
    background-color: red;
    border-color: red;
    font-size: 0.9em;
}
/* CSS untuk mengatur layout data dispensasi */
.data-list {
    display: flex;
    flex-direction: column;
    gap: 10px; /* Memberikan jarak antara setiap item */
}

.data-list p {
    display: flex;
    justify-content: space-between;
    margin: 0;
}

.data-list p strong {
    width: 40%; /* Menentukan lebar label di sisi kiri */
}

.data-list p span, .data-list p a {
    width: 60%; /* Menentukan lebar nilai di sisi kanan */
}

    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
        <button class="btn me-3" id="sidebarToggle" style="background-color: transparent; border: none;">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand text-black" href="#">SUDISMA</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <!-- Tambahkan menu lain di sini jika diperlukan -->
            </ul>
        </div>
    </div>
</nav>


    <!-- Sidebar -->
    <div class="sidebar bg-light p-3" id="sidebar">
        <h4 class="text-center">SUDISMA</h4>
        <div style="height: 40px;"></div>
        <small class="text-muted ms-2">Menu</small>
        <nav class="nav flex-column mt-2">
            <a class="nav-link active d-flex align-items-center text-dark" href="dashboard_wadek.php" style="color: black;">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
            <a class="nav-link d-flex align-items-center text-dark" href="persetujuan_wadek.php" style="color: black;">
                <i class="bi bi-file-earmark-text me-2"></i> Dispensasi
            </a>
            <a class="nav-link d-flex align-items-center text-dark" href="angkatan_wadek.php" style="color: black;">
                <i class="bi bi-file-earmark-text me-2"></i> Angkatan
            </a>
            <a class="nav-link d-flex align-items-center text-dark" href="list_dosen.php" style="color: black;">
                <i class="bi bi-file-earmark-text me-2"></i> Dosen Penyetuju
            </a>
            <a class="nav-link d-flex align-items-center text-dark" href="tanggal_wadek.php" style="color: black;">
                <i class="bi bi-file-earmark-text me-2"></i> Tanggal Pengajuan
            </a>
            <a class="nav-link d-flex align-items-center text-dark" href="logout.php" style="color: black;">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </nav>
    </div>

    <div class="main-content">
        <div class="container">
            <div class="card shadow-sm border-0">
                <h3 class="card-title text-center mb-3">List Data Dispensasi</h3>
                <div class="card-body">
    <div class="data-list">
        <p><strong>Nama:</strong> <span><?= htmlspecialchars($pengajuan['nama_lengkap']); ?></span></p>
        <p><strong>NIM:</strong> <span><?= htmlspecialchars($pengajuan['nim']); ?></span></p>
        <p><strong>Angkatan:</strong> <span><?= htmlspecialchars($pengajuan['angkatan']); ?></span></p>
        <p><strong>Tanggal Pengajuan:</strong> <span><?= htmlspecialchars($pengajuan['tanggal_pengajuan']); ?></span></p>
        <p><strong>Alasan:</strong> <span><?= htmlspecialchars($pengajuan['alasan']); ?></span></p>
        <p><strong>Email:</strong> <span><?= htmlspecialchars($pengajuan['email']); ?></span></p>
        <p><strong>Lampiran Dokumen:</strong> 
            <span><?= $pengajuan['dokumen_lampiran'] ? '<a href="uploads/'.$pengajuan['dokumen_lampiran'].'" target="_blank"><i class="fas fa-file-alt fa-lg"></i></a>' : 'Tidak ada'; ?></span>
        </p>
        <p><strong>Status:</strong> 
            <span class="status-badge 
                <?= $pengajuan['status'] == '' ? 'status-belum-diproses' : 
                    ($pengajuan['status'] == 'disetujui' ? 'status-disetujui' : 'status-ditolak'); ?>">
                <?= $pengajuan['status'] == '' ? 'Belum diproses' : htmlspecialchars($pengajuan['status']); ?>
            </span>
        </p>
        
    
    </div>

    <!-- Form untuk Setuju / Tolak -->
    <p><strong>Aksi:</strong>
        <form method="post" class="d-inline">
            <input type="hidden" name="id" value="<?= $pengajuan['id']; ?>">
            <input type="hidden" name="email" value="<?= $pengajuan['email']; ?>">
            <input type="hidden" name="nama_lengkap" value="<?= $pengajuan['nama_lengkap']; ?>">
            <button type="submit" name="approve" class="btn btn-success btn-sm mx-1">Setuju</button>
            <button type="submit" name="reject" class="btn btn-danger btn-sm">Tidak</button>
        </form>
    </p>
</div>

                
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('d-none');
        });
    </script>
</body>
</html>
