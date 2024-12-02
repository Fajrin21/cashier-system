<?php
require('fpdf/fpdf.php');

// Ambil data dari URL
$harga = $_GET['harga'];
$berat = $_GET['berat'];
$potongan = $_GET['potongan'];
$bersih = $_GET['bersih'];
$total = $_GET['total'];
$tanggal = $_GET['tanggal'];

// Inisialisasi FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Header - Nama Toko
$pdf->Cell(190, 10, 'UD-Dea', 0, 1, 'C'); // Nama toko
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Data Transaksi Coklat', 0, 1, 'C');
$pdf->Ln(10); // Line break

// Isi Data
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, 'Harga: ', 1, 0);
$pdf->Cell(140, 10, 'Rp ' . number_format($harga, 0, ',', '.'), 1, 1);

$pdf->Cell(50, 10, 'Berat: ', 1, 0);
$pdf->Cell(140, 10, $berat . ' kg', 1, 1);

$pdf->Cell(50, 10, 'Potongan: ', 1, 0);
$pdf->Cell(140, 10, $potongan . ' Kg', 1, 1);

$pdf->Cell(50, 10, 'Bersih: ', 1, 0);
$pdf->Cell(140, 10, $bersih . ' kg', 1, 1);

$pdf->Cell(50, 10, 'Total: ', 1, 0);
$pdf->Cell(140, 10, 'Rp ' . number_format($total, 0, ',', '.'), 1, 1);

$pdf->Cell(50, 10, 'Tanggal Transaksi: ', 1, 0);
$pdf->Cell(140, 10, $tanggal, 1, 1);

// Output PDF
$pdf->Output();
?>