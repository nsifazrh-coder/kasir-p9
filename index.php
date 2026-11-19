<?php
require __DIR__ . '/bootstrap.php';
$products = require __DIR__ . '/data.php';

// ===== Proses form "Tambah" =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $kode = $_POST['kode'] ?? '';
    $qty  = filter_var($_POST['qty'] ?? '', FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1, 'max_range' => 99]]);

    if (is_string($kode) && isset($products[$kode]) && $qty !== false) {
        $_SESSION['cart'][$kode] = ($_SESSION['cart'][$kode] ?? 0) + $qty;
        $_SESSION['flash'] = $products[$kode]['nama'] . ' ditambahkan ke keranjang.';
    }
    redirect('index.php');
}

// ===== Data untuk tampilan =====
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
$jumlahItem = array_sum($_SESSION['cart'] ?? []);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Produk</title>
</head>
<body>
<h1>Daftar Produk</h1>
<p>
    <a href="keranjang.php">Keranjang (<?= $jumlahItem ?>)</a> |
    <a href="login.php">Login Admin</a>
</p>

<?php if ($flash): ?>
    <p style="color:green"><?= e($flash) ?></p>
<?php endif; ?>

<table border="1" cellpadding="6">
    <tr><th>Produk</th><th>Harga</th><th>Aksi</th></tr>
    <?php foreach ($products as $kode => $p): ?>
    <tr>
        <td><?= e($p['nama']) ?></td>
        <td><?= rupiah($p['harga']) ?></td>
        <td>
            <form method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="kode" value="<?= e($kode) ?>">
                <input type="number" name="qty" value="1" min="1" max="99" style="width:60px">
                <button type="submit">Tambah</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>