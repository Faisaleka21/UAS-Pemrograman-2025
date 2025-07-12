<?php
include '../koneksi.php';

// Ambil ID komoditas untuk "Beras"
$id_komoditas = 1; // asumsi ID 1 untuk Beras

// Ambil semua grade beras
$query_grade = "SELECT id, nama_grade FROM grades WHERE commodity_id = $id_komoditas";
$result_grade = mysqli_query($conn, $query_grade);

$grade_data = [];
while ($grade = mysqli_fetch_assoc($result_grade)) {
    $grade_id = $grade['id'];

    // Ambil data 7 hari terakhir untuk chart
    $query_chart = "
        SELECT tanggal, harga FROM commodity_prices
        WHERE grade_id = $grade_id
        ORDER BY tanggal DESC
        LIMIT 7
    ";
    $res_chart = mysqli_query($conn, $query_chart);
    $chart_data = [];
    while ($row = mysqli_fetch_assoc($res_chart)) {
        $chart_data[] = $row;
    }

    // Balik data agar urut ASC by tanggal
    $chart_data = array_reverse($chart_data);

    // Ambil semua histori harga untuk tabel
    $query_histori = "
        SELECT tanggal, harga FROM commodity_prices
        WHERE grade_id = $grade_id
        ORDER BY tanggal DESC
    ";
    $res_histori = mysqli_query($conn, $query_histori);
    $histori_data = [];
    while ($row = mysqli_fetch_assoc($res_histori)) {
        $histori_data[] = $row;
    }

    $grade_data[] = [
        'id' => $grade_id,
        'nama_grade' => $grade['nama_grade'],
        'chart_data' => $chart_data,
        'histori_data' => $histori_data
    ];
}
?>
