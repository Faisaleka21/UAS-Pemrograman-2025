<?php
require_once '../koneksi/conn.php';
require_once '../auth.php';
requireLogin('petani');

// Ambil ID komoditas untuk "Beras"
$commodity_query = mysqli_query($conn, "SELECT id FROM commodities WHERE nama = 'Beras' LIMIT 1");
$commodity = mysqli_fetch_assoc($commodity_query);
$commodity_id = $commodity['id'];

// Ambil semua grade untuk komoditas Beras
$grade_query = mysqli_query($conn, "SELECT id, nama_grade FROM grades WHERE commodity_id = $commodity_id");
$grades = [];
while ($row = mysqli_fetch_assoc($grade_query)) {
  $grades[] = $row;
}

// Ambil data harga 7 hari terakhir & histori semua data per grade
$data_chart = [];
$data_table = [];
foreach ($grades as $grade) {
  $grade_id = $grade['id'];

  // Harga 7 hari terakhir (untuk chart)
  $chart_query = mysqli_query($conn, "
    SELECT tanggal, harga FROM commodity_prices
    WHERE grade_id = $grade_id
    ORDER BY tanggal DESC
    LIMIT 7
  ");
  $data_chart[$grade_id] = array_reverse(mysqli_fetch_all($chart_query, MYSQLI_ASSOC));

  // Seluruh histori harga (untuk tabel)
  $table_query = mysqli_query($conn, "
    SELECT tanggal, harga FROM commodity_prices
    WHERE grade_id = $grade_id
    ORDER BY tanggal DESC
  ");
  $data_table[$grade_id] = mysqli_fetch_all($table_query, MYSQLI_ASSOC);
}

// Kirim ke template
$komoditas_nama = "Beras";
include 'template_komoditas.php';
