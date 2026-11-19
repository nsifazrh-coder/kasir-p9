<?php
require __DIR__ . '/bootstrap.php';

// Proteksi halaman: hanya untuk admin yang sudah login
if (empty($_SESSION['admin'])) {
    redirect('login.php');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
</head>
<body>
<h1>Dashboard Admin</h1>
<p>Selamat datang, <strong><?= e($_SESSION['admin']) ?></strong>.</p>

<!-- KHUSUS PRAKTIKUM: menampilkan session ID agar terlihat berganti. Hapus di aplikasi nyata. -->
<p>Session ID: <code><?= e(session_id()) ?></code></p>

<p><a href="index.php">Lihat halaman produk</a></p>
</body>
</html>