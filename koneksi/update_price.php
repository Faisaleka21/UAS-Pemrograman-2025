<?php
require_once 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $grade_id = $_POST['grade_id'];
    $harga = $_POST['harga'];
    $tanggal = $_POST['tanggal'];

    if ($id && $grade_id && $harga && $tanggal) {
        $stmt = $conn->prepare("UPDATE commodity_prices SET grade_id = ?, harga = ?, tanggal = ? WHERE id = ?");
        if (!$stmt) {
            die("Query error: " . $conn->error);
        }

        $stmt->bind_param("iisi", $grade_id, $harga, $tanggal, $id);

        if ($stmt->execute()) {
            echo "<script>alert('✅ Data berhasil diperbarui!'); window.location.href = '../admin/harga.php';</script>";
        } else {
            echo "<script>alert('❌ Gagal update: " . $stmt->error . "'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('⚠️ Semua field wajib diisi.'); window.history.back();</script>";
    }
}
?>
