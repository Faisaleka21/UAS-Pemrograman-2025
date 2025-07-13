<?php
require_once 'conn.php'; // koneksi DB

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $grade_id = $_POST['grade_id'] ?? null;
    $harga    = $_POST['harga'] ?? null;
    $tanggal  = $_POST['tanggal'] ?? null;

    // Validasi input dasar
    if ($grade_id && $harga && $tanggal) {
        // Simpan ke tabel commodity_prices
        $stmt = $conn->prepare("INSERT INTO commodity_prices (grade_id, tanggal, harga) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $grade_id, $tanggal, $harga);

        if ($stmt->execute()) {
            echo "<script>
                alert('✅ Data berhasil disimpan!');
                window.location.href = '../admin/harga.php'; // arahkan kembali ke halaman utama
            </script>";
        } else {
            echo "<script>
                alert('❌ Gagal menyimpan data: " . htmlspecialchars($stmt->error) . "');
                window.history.back();
            </script>";
        }

        $stmt->close();
    } else {
        echo "<script>
            alert('⚠️ Semua field wajib diisi.');
            window.history.back();
        </script>";
    }
}
?>
