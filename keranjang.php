<?php
require __DIR__ . '/bootstrap.php';
$products = require __DIR__ . '/data.php';

// ===== Proses tombol "Hapus" =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $kode = $_POST['kode'] ?? '';
    if (is_string($kode)) {
        unset($_SESSION['cart'][$kode]);
    }
    redirect('keranjang.php');
}

$cart  = $_SESSION['cart'] ?? [];
$total = 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang</title>
</head>
<body>
<h1>Keranjang Belanja</h1>
<p><a href="index.php">&larr; Kembali ke produk</a></p>

<?php if (!$cart): ?>
    <p>Keranjang masih kosong.</p>
<?php else: ?>
<table border="1" cellpadding="6">
    <tr><th>Produk</th><th>Harga</th><th>Qty</th><th>Subtotal</th><th>Aksi</th></tr>
    <?php foreach ($cart as $kode => $qty):
        if (!isset($products[$kode])) continue;
        $subtotal = $products[$kode]['harga'] * $qty;
        $total   += $subtotal; ?>
    <tr>
        <td><?= e($products[$kode]['nama']) ?></td>
        <td><?= rupiah($products[$kode]['harga']) ?></td>
        <td><?= $qty ?></td>
        <td><?= rupiah($subtotal) ?></td>
        <td>
            <form method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="kode" value="<?= e((string) $kode) ?>">
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
    <tr><th colspan="3">Total</th><th colspan="2"><?= rupiah($total) ?></th></tr>
</table>
<?php endif; ?>
</body>
</html>