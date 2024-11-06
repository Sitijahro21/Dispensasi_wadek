<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$query = "SELECT * FROM pengajuan";
$result = $conn->query($query);

$queryDispenHariIni = "SELECT COUNT(*) AS total FROM pengajuan WHERE DATE(tanggal_pengajuan) = CURDATE()";
$resultDispenHariIni = $conn->query($queryDispenHariIni);
$dispenHariIni = $resultDispenHariIni->fetch_assoc()['total'];

$queryDataTerbaru = "SELECT COUNT(*) AS total FROM pengajuan WHERE status = 'pending'";
$resultDataTerbaru = $conn->query($queryDataTerbaru);
$dataTerbaru = $resultDataTerbaru->fetch_assoc()['total'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUDISMA - Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://kit.fontawesome.com/YOUR_KIT_CODE.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding-top: 80px;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            transition: transform 0.3s ease;
        }
        .sidebar h5 {
            text-align: center;
            color: white;
            margin-bottom: 20px;
            margin-top: 40px;
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
        .sidebar.collapsed {
            transform: translateX(-100%);
        }
        .sidebar.collapsed ~ .dashboard-header {
            margin-left: 0; /* Remove left margin when sidebar is collapsed */
            width: 100%; /* Make header full width */
        }

       


        .sidebar.collapsed ~ .main-content {
            margin-left: 0; /* Remove left margin when sidebar is collapsed */
            width: 100%; /* Make main content full width */
        }

        .content-wrapper {
            margin-left: 250px;
            padding-top: 60px;
            transition: margin-left 0.3s ease;
        }
        .content-wrapper.expanded {
            margin-left: 0;
        }
        .dashboard-header {
            width: calc(100% - 250px); /* Set to adjust with sidebar width */
            padding: 120px;
            border-radius: 0;
            background-color: #4472c4;
            margin-left: 0px;
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
        .welcome-card {
    background-color: #ffffff;
    padding: 0px; /* Keep padding at 0 if you want it compact */
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-top: -240px; /* Use a negative margin to pull it up */
    display: flex;
    margin-right: 90px;
    justify-content: space-between;
    position: relative; /* Keep it as relative to maintain flow */
    left: 0; /* Reset left positioning */
    z-index: 1; /* Ensure it stays above other elements */
    width: calc(100% - 40px); /* Full width minus padding */
    transition: all 0.3s ease; /* Smooth transition for width changes */
}

/* Specific adjustments when the sidebar is collapsed */
.sidebar.collapsed ~ .welcome-card {
    margin-left: 0; /* Remove left margin */
    width: calc(100% - 30px); /* Adjust width to fit the container with some padding */
    position: relative; /* Ensure it flows with the document */
    left: 0; /* Reset left position */
    margin-top: -50px; /* Keep negative margin when sidebar is collapsed */
}



        .welcome-card div {
            display: flex;
            flex-direction: column; /* Stack h4 and p vertically */
        }

        .welcome-card h4 {
            margin: 0; /* Remove default margin */
            margin-top: 40px;
            margin-left: 40px;
            font-size: 30px;
            font-weight: bold;
        }

        .welcome-card p {
            margin: 5px 0 0 0; /* Adjust margin for spacing below h4 */
            font-size: 20px;
            margin-left: 40px;
            color: #555; /* Optional: gray text color */
        }
        .info-card {
            color: white;
            padding: 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-grow: 1;
        }
        .info-card-primary {
            background-color: #4a90e2;
        }
        .info-card-warning {
            background-color: #f5a623;
        }
        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        @media (max-width: 768px) {
            .dashboard-header,
            .welcome-card {
                width: 90%;
            }
        }
        #current-date {
            width: 250px; /* Fixed width */
            height: 40px; /* Fixed height */
            display: flex; /* Flexbox layout */
            align-items: center; /* Center vertically */
            justify-content: flex-start; /* Align items to the left */
            padding-left: 10px; /* Padding to position items inside */
            background-color: white; /* Background color */
            color: black; /* Text color */
            border: none; /* Remove border */
            border-radius: 5px; /* Rounded corners */
            gap: 8px; /* Space between icon and text */
            
        }

        #current-date i {
            font-size: 18px; /* Size of the calendar icon */
            color: black; /* Color of the icon */
        }


        .row.mt-4 {
            margin-bottom: 20px;
        }
        .dashboard-header h3 {
            margin: 0;
            font-size: 40px;
            font-weight: bold;
        }

        .dashboard-header small {
            display: block;
            font-size: 17px;
            color: #f8f9fa;
        }
        .welcome-card img {
            width: 180px; /* Set the desired width */
            height: 180px; /* Set the desired height */
             /* Optional: make the image circular */
            object-fit: cover; /* Maintain aspect ratio and crop if needed */
            margin-right: 40px;
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
   <!-- Sidebar -->
    <div class="sidebar bg-light p-3" id="sidebar">
        <h4 class="text-center">SUDISMA</h4>
        <div style="height: 40px;"></div>
        <small class="text-muted ms-2" style="margin-top: 80px;">Menu</small>
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
            <a class="nav-link d-flex align-items-center text-dark" href="list_tanggal.php" style="color: black;">
                <i class="bi bi-file-earmark-text me-2"></i> Tanggal Pengajuan
            </a>
            <a class="nav-link d-flex align-items-center text-dark" href="logout.php" style="color: black;">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </nav>
    </div>


    <!-- Sidebar 
    <div class="sidebar">
        <h5>SUDISMA</h5>
        <a href="#" onclick="openDashboard()">Dashboard</a>
        <a href="#" onclick="openDispensasi()">Dispensasi</a>
        <a href="#" onclick="openAngkatan()">Angkatan</a>
        <a href="#" onclick="openPenyetujuIzin()">Penyetuju Izin</a>
        <a href="#" onclick="openTanggalPengajuan()">Tanggal Pengajuan</a>
    </div> -->

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div>
            <h3>Dashboard</h3>
            <small>Wakil Dekan III Fakultas Sains dan Teknologi</small>
        </div>
        <button class="btn btn-light ml-auto" id="current-date">
            <i class="fas fa-calendar-alt"></i> <span id="date-text"></span>
        </button>



    </div>


        
    <!-- Main content -->
    <div class="main-content" id="content">
        

        <!-- Welcome Card -->
        <div class="welcome-card" id="card">
            <div>
                <h4>Selamat Datang Wakil Dekan III Fakultas Sains dan Teknologi</h4>
                <p>Di Website Aplikasi Surat Izin Dispensasi</p>
            </div>
            <img src="image/image.png" alt="User Image">
        </div>

        <!-- Information Cards -->
        <<!-- Information Cards -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="info-card info-card-primary">
            <div>
                <h5>Dispen Hari ini</h5>
                <h2 id="dispen-hari-ini"><?php echo $dispenHariIni; ?></h2>
            </div>
            <!-- Ikon tanpa tombol -->
            <i class="fas fa-envelope fa-2x" onclick="lihatDispenHariIni()" style="cursor: pointer;"></i>
        </div>
    </div>

    <div class="col-md-6">
        <div class="info-card info-card-warning">
            <div>
                <h5>Data Terbaru</h5>
                <h2 id="data-terbaru"><?php echo $dataTerbaru; ?></h2>
            </div>
            <!-- Ikon tanpa tombol -->
            <i class="fas fa-envelope fa-2x" onclick="lihatDataTerbaru()" style="cursor: pointer;"></i>
        </div>
    </div>
</div>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Action Scripts -->
    <script>
        // Function to display current date in the format "MMM DD, YYYY"
        document.addEventListener('DOMContentLoaded', (event) => {
    const dateTextElement = document.getElementById("date-text");
    const today = new Date();
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    
    // Format date as "Month Day, Year - Month Day, Year"
    const formattedDate = today.toLocaleDateString("en-US", options);
    dateTextElement.textContent = `${formattedDate} - ${formattedDate}`;
});



        // Sidebar navigation functions
        function openDashboard() {
            alert("Navigating to Dashboard...");
        }

        function openDispensasi() {
            alert("Navigating to Dispensasi...");
        }

        function openAngkatan() {
            alert("Navigating to Angkatan...");
        }

        function openPenyetujuIzin() {
            alert("Navigating to Penyetuju Izin...");
        }

        function openTanggalPengajuan() {
            alert("Navigating to Tanggal Pengajuan...");
        }

        // Info card button functions
        function lihatDispenHariIni() {
            window.location.href = 'list_pengajuan.php';
        }

        function lihatDataTerbaru() {
            window.location.href = 'list_pengajuan.php';
        }
        document.getElementById("sidebarToggle").addEventListener("click", function() {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("collapsed");

    const content = document.getElementById("content");
    content.classList.toggle("expanded");

    // Adjust the header based on sidebar visibility
    const dashboardHeader = document.querySelector(".dashboard-header");
    const mainContent = document.querySelector(".main-content");

    if (sidebar.classList.contains("collapsed")) {
        dashboardHeader.style.marginLeft = "0"; // No margin when collapsed
        mainContent.style.marginLeft = "0"; // No margin when collapsed
    } else {
        dashboardHeader.style.marginLeft = "250px"; // Reset to sidebar width
        mainContent.style.marginLeft = "250px"; // Reset to sidebar width
    }

    });
    </script>
</body>
</html>
