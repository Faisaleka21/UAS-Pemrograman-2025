<?php
require_once 'conn.php'; // koneksi ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    // Ambil data dari form
    $id       = $_POST['id'];
    $name     = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role     = $_POST['role'];

    // Validasi sederhana
    if ($id && $name && $username && $password && $role) {

        // Buat query
        $query = "UPDATE users SET nama = ?, username = ?, password = ?, role = ? WHERE id_users = ?";
        $stmt = $conn->prepare($query);

        // ✅ Tambahkan pengecekan apakah prepare berhasil
        if (!$stmt) {
            die("❌ Gagal mempersiapkan query: " . $conn->error);
        }

        // Bind dan eksekusi
        $stmt->bind_param("ssssi", $name, $username, $password, $role, $id);

        if ($stmt->execute()) {
            echo "<script>
                alert('✅ Data pengguna berhasil diperbarui!');
                window.location.href = '../admin/pengguna.php';
            </script>";
        } else {
            echo "<script>
                alert('❌ Gagal mengupdate data: " . htmlspecialchars($stmt->error) . "');
                window.history.back();
            </script>";
        }

        $stmt->close();
    } else {
        echo "<script>
            alert('⚠️ Semua kolom harus diisi.');
            window.history.back();
        </script>";
    }
}
?>
