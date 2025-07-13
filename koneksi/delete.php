<?php
require_once 'conn.php'; // pastikan koneksi DB tersedia

// Periksa apakah ID diberikan dan valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Siapkan dan eksekusi query delete
    $stmt = $conn->prepare("DELETE FROM users WHERE id_users = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>
            alert('✅ Data pengguna berhasil dihapus!');
            window.location.href = '../admin/pengguna.php';
        </script>";
    } else {
        echo "<script>
            alert('❌ Gagal menghapus data: " . htmlspecialchars($stmt->error) . "');
            window.history.back();
        </script>";
    }

    $stmt->close();
} else {
    echo "<script>
        alert('⚠️ ID tidak valid!');
        window.history.back();
    </script>";
}
?>
