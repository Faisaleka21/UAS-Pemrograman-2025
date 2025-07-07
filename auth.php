<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Koneksi ke database umum
$conn = mysqli_connect("localhost", "root", "", "petani");

function redirectToRole($role) {
    if ($role === 'admin') {
        header("Location: /uas_web/admin/dashboard.php");
    } elseif ($role === 'users') {
        header("Location: /uas_web/user/home.php");
    } else {
        header("Location: /uas_web/index.php?error=Role tidak dikenali");
    }
    exit;
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $role     = $_POST['role'] ?? '';

    $query = "SELECT * FROM users WHERE username='$username' AND role='$role' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query error: " . mysqli_error($conn));
    }

    if ($user = mysqli_fetch_assoc($result)) {
        // Tanpa hash (hanya cocokkan teks biasa)
        if ($password === $user['password']) {
            $_SESSION['user'] = $user;
            redirectToRole($user['role']);
        } else {
            header("Location: ../index.php?error=Password salah");
            exit;
        }
    } else {
        header("Location: ../index.php?error=User tidak ditemukan");
        exit;
    }
}



// Untuk halaman lain: cek login
function requireLogin($expectedRole) {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== $expectedRole) {
        session_destroy();
        header("Location: /uas_web/index.php?error=Akses ditolak");
        exit;
    }
}
//perlu logout dlu setelah masuk
?>
