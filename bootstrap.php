<?php
declare(strict_types=1);

// 1. Pengaturan session yang aman (WAJIB sebelum session_start)
ini_set('session.use_strict_mode', '1');
session_set_cookie_params([
    'lifetime' => 0,          // cookie hilang saat browser ditutup
    'path'     => '/',
    'httponly' => true,       // cookie tidak bisa dibaca JavaScript
    'secure'   => false,      // ubah ke true jika memakai HTTPS
    'samesite' => 'Lax',      // cookie tidak ikut pada POST dari situs lain
]);

// 2. Mulai session
session_start();
require __DIR__ . '/csrf.php';   // <-- BARIS BARU

// 3. Fungsi bantu
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function rupiah(int $angka): string
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}