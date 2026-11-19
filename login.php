<?php
require __DIR__ . '/bootstrap.php';
$users = require __DIR__ . '/users.php';

// Jika sudah login, langsung ke halaman admin
if (!empty($_SESSION['admin'])) {
    redirect('admin.php');
}

$error    = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = is_string($_POST['username'] ?? null) ? trim($_POST['username']) : '';
    $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';

    $hash = $users[$username] ?? null;

    if ($hash !== null && password_verify($password, $hash)) {
        session_regenerate_id(true);      // ganti session ID: cegah session fixation
        $_SESSION['admin'] = $username;
        redirect('admin.php');
    }

    $error = 'Username atau password salah.'; // pesan sengaja dibuat umum
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
</head>
<body>
<h1>Login Admin</h1>
<p><a href="index.php">&larr; Kembali ke produk</a></p>

<?php if ($error): ?>
    <p style="color:red"><?= e($error) ?></p>
<?php endif; ?>

<form method="post">
    <p>
        <label>Username<br>
            <input type="text" name="username" value="<?= e($username) ?>" required>
        </label>
    </p>
    <p>
        <label>Password<br>
            <input type="password" name="password" required>
        </label>
    </p>
    <button type="submit">Masuk</button>
</form>
</body>
</html>