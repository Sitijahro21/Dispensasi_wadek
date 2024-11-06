<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$query = "SELECT DISTINCT tanggal_pengajuan FROM pengajuan";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUDISMA - Tanggal Pengajuan</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
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
        .sidebar h5 {
            text-align: center;
            color: white;
            margin-bottom: 20px;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 16px;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .dashboard-header {
            width: calc(100% - 250px); /* Set to adjust with sidebar width */
            padding: 120px;
            border-radius: 0;
            background-color: #4472c4;
            color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
            margin-left: 250px; /* Offset by sidebar width */
            justify-content: space-between;
            display: flex;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            margin-top: 150px; /* Adjust for dashboard header */
            min-height: calc(100vh - 56px); 
        }
        .status-badge {
            padding: 3px 8px; /* Mengurangi padding badge status */
            font-size: 0.8em;
        }
        .status-belum-diproses {
            background-color: orange;
            color: white;
        }
        .status-diterima {
            background-color: green;
            color: white;
        }
        .status-ditolak {
            background-color: red;
            color: white;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        .btn-custom {
            padding: 3px 5px; /* Mengecilkan ukuran tombol aksi */
            font-size: 0.85em;
            border-radius: 3px;
        }
        .table-container {
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table thead th {
            background-color: #a3c1e0;
            color: black !important;;
            font-size: 0.9em; /* Menyesuaikan ukuran font header tabel */
        }
        .table th, .table td {
            font-size: 0.85em; /* Mengecilkan ukuran font */
            padding: 8px; /* Mengurangi padding untuk membuat tabel lebih ringkas */
            text-align: center;
        }
        .table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }
        .main-content {
            margin-left: 20px;
            padding: 20px;
            margin-top: 20px; /* Adjust for dashboard header */
            min-height: calc(100vh - 56px); 
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

        .header-title {
            font-size: 1.5em;
            color: #007bff;
            font-weight: bold;
            text-align: left;
            margin-bottom: 15px;
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
            <ul class="navbar-nav ml-auto"></ul>
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
            <a class="nav-link d-flex align-items-center text-dark" href="list_angkatan.php" style="color: black;">
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

    <div class="main-content" id="content">
        <div class="container mt-5">
            <div class="table-container">
                <div class="header-title">List Tanggal Pengajuan</div>
                <div class="table-responsive">
                    <table id="dispensasiTable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal Pengajuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row['tanggal_pengajuan']); ?></td> <!-- Display tanggal pengajuan directly in a table cell -->
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dispensasiTable').DataTable({
            "pagingType": "simple_numbers",
            "lengthMenu": [10, 25, 50, 100],
            "language": {
                "search": "Search:",
                "lengthMenu": "Show _MENU_ entries",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "paginate": {
                    "previous": "Previous",
                    "next": "Next"
                }
            },
            "columnDefs": [
                { "orderable": false, "targets": 0 }
            ]
        });
    });

    document.getElementById("sidebarToggle").addEventListener("click", function() {
        document.getElementById("sidebar").classList.toggle("collapsed");
        document.getElementById("content").classList.toggle("expanded");
    });
</script>

</body>
</html>
