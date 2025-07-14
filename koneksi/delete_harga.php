<?php
require_once 'conn.php'; // koneksi DB

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Sesuaikan nama kolom PK kalau bukan 'id'
    $stmt = $conn->prepare("DELETE FROM commodity_prices WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>
            alert('✅ Data berhasil dihapus!');
            window.location.href = '../admin/harga.php';
        </script>";
    } else {
        echo "<script>
            alert('❌ Gagal menghapus data!');
            window.history.back();
        </script>";
    }

    $stmt->close();
} else {
    echo "<script>
        alert('⚠️ ID tidak ditemukan.');
        window.history.back();
    </script>";
}
?>
