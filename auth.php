<?php
// Mulai session jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Koneksi ke database
require_once 'koneksi/conn.php';

/**
 * Fungsi redirect berdasarkan role
 */
function redirectToRole($role) {
    if ($role === 'admin') {
        header("Location: /uas_web/admin/dashboard.php");
    } elseif ($role === 'petani') {
        header("Location: /uas_web/user/home.php");
    } else {
        header("Location: /uas_web/index.php?error=Role tidak dikenali");
    }
    exit;
}

/**
 * Proses login jika request POST
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $role     = trim($_POST['role'] ?? '');

    if ($username === '' || $password === '' || $role === '') {
        header("Location: index.php?error=Harap isi semua kolom");
        exit;
    }

    // Query mencari user berdasarkan username dan role
    $query = "SELECT * FROM users WHERE username = '$username' AND role = '$role' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query error: " . mysqli_error($conn));
    }

    if ($user = mysqli_fetch_assoc($result)) {
        // Bandingkan password (sederhana — belum pakai hash)
        if ($password === $user['password']) {
            $_SESSION['user'] = $user;
            redirectToRole($user['role']);
        } else {
            header("Location: index.php?error=Password salah");
            exit;
        }
    } else {
        header("Location: index.php?error=User tidak ditemukan");
        exit;
    }
}

/**
 * Fungsi pengecekan login untuk digunakan di halaman lain
 */
function requireLogin($expectedRole) {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== $expectedRole) {
        session_destroy();
        header("Location: /uas_web/index.php?error=Akses ditolak");
        exit;
    }
}
?>
