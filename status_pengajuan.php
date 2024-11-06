<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM pengajuan WHERE user_id = '$user_id'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pengajuan Dispensasi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .badge-disetujui { background-color: #28a745; } /* Green */
        .badge-pending { background-color: #fd7e14; } /* Orange */
        .badge-ditolak { background-color: #dc3545; } /* Red */
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
            height: 60px; /* Adjust this value to push content down */
        }
        .table-title {
            font-weight: bold;
            color: #007bff; /* Warna biru */
            font-size: 1.25em; /* Sesuaikan ukuran font jika diperlukan */
        }
        .nav-link {
            padding-left: 10px; /* Menambahkan spasi di kiri link */
            display: flex;
            align-items: center;
            font-size: 1.1em;
        }

        .nav-link i {
            margin-right: 10px; /* Memberikan jarak antara ikon dan teks */
            font-size: 1.2em;
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

<!-- Spacer to push down content -->
<div class="spacer"></div>

<!-- Main Content -->
<div class="container content-wrapper" id="content" style="margin-left: 300px;">
    <div class="card shadow-lg">
    <div class="card-header text-left">
        <h2 class="table-title">Status Pengajuan Dispensasi</h2>
    </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan alasan atau status">
                </div>
            </div>
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Alasan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="pengajuanTable">
                    <?php if ($result->num_rows > 0): ?>
                        <?php $counter = 1; ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $counter++; ?></td>
                                <td><?= $row['tanggal_pengajuan']; ?></td>
                                <td><?= $row['alasan']; ?></td>
                                <td>
                                    <span class="badge 
                                        <?= $row['status'] == 'disetujui' ? 'badge-disetujui' : ($row['status'] == 'pending' ? 'badge-pending' : 'badge-ditolak') ?>">
                                        <?= ucfirst($row['status']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada pengajuan dispensasi.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#pengajuanTable tr');
        rows.forEach(row => {
            let alasan = row.cells[2].textContent.toLowerCase();
            let status = row.cells[3].textContent.toLowerCase();
            row.style.display = (alasan.includes(filter) || status.includes(filter)) ? '' : 'none';
        });
    });

    document.getElementById("sidebarToggle").addEventListener("click", function() {
        document.getElementById("sidebar").classList.toggle("collapsed");
        document.getElementById("content").classList.toggle("expanded");
    });
</script>
</body>
</html>
