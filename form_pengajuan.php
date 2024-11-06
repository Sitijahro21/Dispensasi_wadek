<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $nim = $_POST['nim'];
    $angkatan = $_POST['angkatan'];
    $jurusan = $_POST['jurusan'];
    $alasan = $_POST['alasan'];
    $tanggal_pengajuan = $_POST['tanggal_pengajuan'];
    $email = $_POST['email'];

    if (isset($_FILES['dokumen_lampiran']) && $_FILES['dokumen_lampiran']['error'] === UPLOAD_ERR_OK) {
        $lampiran_nama = $_FILES['dokumen_lampiran']['name'];
        $lampiran_tmp = $_FILES['dokumen_lampiran']['tmp_name'];
        $upload_dir = 'uploads/' . $lampiran_nama;
        move_uploaded_file($lampiran_tmp, $upload_dir);
    } else {
        $lampiran_nama = null;
    }

    $query = "INSERT INTO pengajuan (user_id, nama_lengkap, nim, angkatan, jurusan, alasan, tanggal_pengajuan, email, dokumen_lampiran) 
    VALUES ('$user_id', '$nama_lengkap', '$nim', '$angkatan', '$jurusan', '$alasan', '$tanggal_pengajuan', '$email', '$lampiran_nama')";

    if ($conn->query($query) === TRUE) {
        header('Location: status_pengajuan.php');
        exit();
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengajuan Dispensasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .custom-bg {
            background-color: #5393F3; /* Customize this color as desired */
        }
        .sidebar {
            background-color: #f8f9fa;
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 60px;
            transition: transform 0.3s ease;
            transform: translateX(0);
            z-index: 1;
        }
        .sidebar.collapsed {
            transform: translateX(-100%);
        }
        .content-wrapper {
            margin-left: 250px;
            padding-top: 60px;
            transition: margin-left 0.3s ease;
        }
        .content-wrapper.expanded {
            margin-left: 0;
        }
        .navbar {
            background-color: #ffff;
            color: black;
            z-index: 2;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <!-- Icon Hamburger -->
            <!-- Icon Hamburger -->
            <button class="btn me-3" id="sidebarToggle" style="background-color: transparent; border: none;">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>

            <a class="navbar-brand text-dark" href="#">SUDISMA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
   <!-- Sidebar -->
    <div class="sidebar bg-light p-3 shadow-lg" id="sidebar">
        <h4 class="text-center">SUDISMA</h4>
        <div style="height: 40px;"></div>
        <small class="text-muted ms-2">Menu</small>
        <nav class="nav flex-column mt-2">
            <a class="nav-link active d-flex align-items-center text-dark" href="dashboard_mahasiswa.php" style="color: black;">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
            <a class="nav-link d-flex align-items-center text-dark" href="status_pengajuan.php" style="color: black;">
                <i class="bi bi-file-earmark-text me-2"></i> Status Pengajuan
            </a>
            <a class="nav-link d-flex align-items-center text-dark" href="logout.php" style="color: black;">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </nav>
    </div>



    <!-- Main Content -->
    <div class="content-wrapper custom-bg d-flex justify-content-center align-items-center" id="content">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Form Pengajuan Dispensasi</h2>
                    <form id="dispensasiForm" method="POST" action="" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap Mahasiswa</label>
                            <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label for="nim" class="form-label">Nomor Induk Mahasiswa (NIM)</label>
                            <input type="text" name="nim" class="form-control" placeholder="Nomor Induk Mahasiswa (NIM)" required>
                        </div>
                        <div class="mb-3">
                            <label for="angkatan" class="form-label">Angkatan</label>
                            <input type="text" name="angkatan" class="form-control" placeholder="Angkatan" required>
                        </div>
                        <div class="mb-3">
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <select name="jurusan" class="form-select" required>
                                <option value="">Pilih Jurusan</option>
                                <option value="Teknik Informatika">Teknik Informatika</option>
                                <option value="Teknik Elektro">Teknik Elektro</option>
                                <option value="Biologi">Biologi</option>
                                <option value="Fisika">Fisika</option>
                                <option value="Kimia">Kimia</option>
                                <option value="Agroteknologi">Agroteknologi</option>
                                <option value="Matematika">Matematika</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="alasan" class="form-label">Alasan Pengajuan</label>
                            <textarea name="alasan" class="form-control" placeholder="Alasan Pengajuan" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan</label>
                            <input type="date" name="tanggal_pengajuan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="dokumen_lampiran" class="form-label">Lampiran Dokumen</label>
                            <input type="file" name="dokumen_lampiran" class="form-control" placeholder="Email" required>
                        </div>
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#confirmModal">Simpan Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5>Apakah Data yang kamu Isi sudah benar?</h5>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-success" id="confirmButton">Ya, Data sudah benar</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        document.getElementById("confirmButton").addEventListener("click", function() {
            document.getElementById("dispensasiForm").submit(); // Mengirim form setelah konfirmasi
        });
        document.getElementById("sidebarToggle").addEventListener("click", function() {
            document.getElementById("sidebar").classList.toggle("collapsed");
            document.getElementById("content").classList.toggle("expanded");
        });
    </script>
</body>
</html>
