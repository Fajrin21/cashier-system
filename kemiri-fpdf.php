<?php
require('fpdf/fpdf.php');

// Ambil data dari URL
$harga = $_GET['harga'];
$berat = $_GET['berat'];
$total = $_GET['total'];
$tanggal = $_GET['tanggal'];

// Inisialisasi FPDF
$pdf = new FPDF('P', 'mm', array(58, 90)); // Ukuran kertas thermal 58mm x panjang dinamis
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Header - Nama Toko
$pdf->Cell(0, 5, 'UD-Dea', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 5, 'Data Transaksi Kemiri', 0, 1, 'C');
$pdf->Ln(5); // Line break

// Isi Data
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(25, 5, 'Harga: ', 0, 0);
$pdf->Cell(0, 5, 'Rp ' . number_format($harga, 0, ',', '.'), 0, 1);

$pdf->Cell(25, 5, 'Berat: ', 0, 0);
$pdf->Cell(0, 5, $berat . ' kg', 0, 1);

$pdf->Cell(25, 5, 'Total: ', 0, 0);
$pdf->Cell(0, 5, 'Rp ' . number_format($total, 0, ',', '.'), 0, 1);

$pdf->Cell(25, 5, 'Tanggal: ', 0, 0);
$pdf->Cell(0, 5, $tanggal, 0, 1);

// Footer (opsional)
$pdf->Ln(10);
$pdf->Cell(0, 5, 'Terima Kasih!', 0, 1, 'C');

// Output PDF
$pdf->Output();
?>