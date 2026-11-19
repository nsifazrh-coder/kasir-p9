<?php
// Ambil token dari session; buat baru jika belum ada
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Hasilkan input tersembunyi untuk disisipkan di form
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

// Periksa token kiriman form; hentikan jika tidak cocok
function csrf_verify(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || !hash_equals(csrf_token(), $token)) {
        http_response_code(403);
        exit('403 - Permintaan ditolak: token CSRF tidak valid.');
    }
}