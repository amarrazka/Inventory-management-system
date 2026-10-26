<?php
// Dimuat di setiap halaman: mulai session, set bahasa, sediakan helper
session_start();

// Bahasa default: Indonesia
if (!isset($_SESSION['lang']) || !in_array($_SESSION['lang'], ['id', 'en'], true)) {
    $_SESSION['lang'] = 'id';
}
$GLOBALS['LANG'] = require __DIR__ . '/../lang/' . $_SESSION['lang'] . '.php';

// Ambil teks terjemahan
function t(string $key): string {
    return $GLOBALS['LANG'][$key] ?? $key;
}

// Escape output (cegah XSS)
function e($str): string {
    return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

// Proteksi halaman: wajib login
function require_login(): void {
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

// CSRF token
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}
function csrf_valid(?string $token): bool {
    return !empty($_SESSION['csrf']) && is_string($token) && hash_equals($_SESSION['csrf'], $token);
}

// Flash message
function flash_set(string $type, string $msg): void { $_SESSION['flash'] = [$type, $msg]; }
function flash_get(): ?array {
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $f;
}
