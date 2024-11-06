<?php
require 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$id = $_GET['id'];
$query = "SELECT * FROM pengajuan WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$pengajuan = $result->fetch_assoc();

if ($pengajuan['status'] != 'disetujui') {
    echo "Surat dispensasi hanya tersedia untuk pengajuan yang disetujui.";
    exit();
}

$dompdf = new Dompdf();
$html = "
    <h1>Surat Dispensasi</h1>
    <p>Nama: {$pengajuan['nama_lengkap']}</p>
    <p>NIM: {$pengajuan['nim']}</p>
    <p>Alasan: {$pengajuan['alasan']}</p>
    <p>Status: {$pengajuan['status']}</p>
";

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Surat_Dispensasi_{$pengajuan['nama_lengkap']}.pdf", ["Attachment" => true]);
?>
