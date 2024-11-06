<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$user_role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Dashboard</h2>
    <a href="form_pengajuan.php">Ajukan Dispensasi</a> | <a href="status_pengajuan.php">Cek Status Pengajuan</a>
</body>
</html>
