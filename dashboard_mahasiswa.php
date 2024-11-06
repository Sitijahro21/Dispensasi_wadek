<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa - SUDISMA</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .custom-bg {
            background-color: #5393F3;
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
        .spacer {
            height: 60px;
        }
        .table-title {
            font-weight: bold;
            color: #007bff;
            font-size: 1.25em;
        }
        .nav-link {
            padding-left: 10px;
            display: flex;
            align-items: center;
            font-size: 1.1em;
        }

        .nav-link i {
            margin-right: 10px;
            font-size: 1.2em;
        }
        .main-content {
            margin-left: 80px;
            padding: 20px;
            margin-top: 80px; /* Adjusted for header */
            min-height: calc(100vh - 56px);
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 2rem;
            flex: 1;
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
        }
        .card-text {
            color: #555;
            font-size: 1.1rem;
        }
        .btn {
            font-size: 1.1rem;
            padding: 0.75rem 1.5rem;
            border-radius: 30px;
            transition: background-color 0.3s ease;
        }
        .btn-primary {
            background-color: #5393F3;
            border: none;
        }
        .btn-primary:hover {
            background-color: #4571c4;
        }
        .btn-info {
            background-color: #17a2b8;
            border: none;
        }
        .btn-info:hover {
            background-color: #138496;
        }
    </style>
</head>
<body>
   <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <button class="btn me-3" id="sidebarToggle" style="background-color: transparent; border: none;">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>
            <a class="navbar-brand text-dark" href="#">SUDISMA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav"></div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar bg-light p-3 shadow-lg" id="sidebar">
        <h4 class="text-center">SUDISMA</h4>
        <div style="height: 40px;"></div>
        <small class="text-muted ms-2">Menu</small>
        <nav class="nav flex-column mt-2">
            <a class="nav-link active d-flex align-items-center text-dark" href="dashboard_mahasiswa.php">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
            <a class="nav-link d-flex align-items-center text-dark" href="status_pengajuan.php">
                <i class="bi bi-file-earmark-text me-2"></i> Status Pengajuan
            </a>
            <a class="nav-link d-flex align-items-center text-dark" href="logout.php">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </nav>
    </div>

    <!-- Spacer to push down content -->
    <div class="spacer"></div>

    <!-- Dashboard Content -->
    <div class="main-content" id="content">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 mb-4 text-center">
                    <h2 class="display-4">Selamat Datang, Mahasiswa!</h2>
                    <p class="lead">Selamat datang di dashboard pengajuan surat dispensasi.</p>
                </div>
            </div>

            <!-- Dashboard Cards -->
            <!-- Dashboard Cards -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm" style="height: 100%;">
                        <div class="card-body text-center">
                            <h5 class="card-title">Ajukan Dispensasi</h5>
                            <p class="card-text">Ajukan surat dispensasi untuk kebutuhan Anda dengan mudah.</p>
                            <a href="form_pengajuan.php" class="btn btn-primary">Ajukan Sekarang</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm" style="height: 100%; background-color: #e0f7fa;">
                        <div class="card-body text-center">
                            <h5 class="card-title">Cek Status Pengajuan</h5>
                            <p class="card-text">Lihat status pengajuan surat dispensasi Anda.</p>
                            <a href="status_pengajuan.php" class="btn btn-info">Lihat Status</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Footer -->
    <footer class="bg-light text-center py-3 mt-5">
        <p class="mb-0">© 2024 SUDISMA - Surat Dispensasi Mahasiswa. All Rights Reserved.</p>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("sidebarToggle").addEventListener("click", function() {
            document.getElementById("sidebar").classList.toggle("collapsed");
            document.getElementById("content").classList.toggle("expanded");
        });
    </script>
</body>
</html>
