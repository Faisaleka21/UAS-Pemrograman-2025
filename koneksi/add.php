<?php
require_once 'conn.php';

// registrasi
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role     = $_POST['role'];

    if (empty($nama) || empty($username) || empty($password) || empty($role)) {
        die("Semua kolom wajib diisi.");
    }

    $sql = "INSERT INTO users (nama, username, password, role) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $nama, $username, $password, $role);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../index.php");
            exit();
        } else {
            echo "Gagal registrasi: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Kesalahan pada query: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Akses tidak valid.";
}
