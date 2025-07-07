<?php

declare(strict_types=1);
require_once BASE_PATH . '/bootstrap.php';
require_once VENDOR_PATH . 'autoload.php';
require_once UTILS_PATH . 'auth.util.php';
require_once UTILS_PATH . 'envSetter.util.php';

Auth::init();

$host = 'host.docker.internal';
$port = $pgConfig['port'];
$user = $pgConfig['user'];
$pass = $pgConfig['pass'];
$db = $pgConfig['db'];

$dsn = "pgsql:host={$host};port={$port};dbname={$db}";
$pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$action = $_REQUEST['action'] ?? null;

if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameInput = trim($_POST['username'] ?? '');
    $passwordInput = trim($_POST['password'] ?? '');

    if (Auth::login($pdo, $usernameInput, $passwordInput)) {
        $user = Auth::user();
        error_log("[auth.handler.php] Login successful for user_id={$user['id']}");
        header('Location: /pages/login/index.php'); // Redirect to dashboard or another page
        exit;
    } else {
        error_log("[auth.handler.php] Login failed for username='{$usernameInput}'");
        header('Location: /index.php?error=Invalid%20Credentials');
        exit;
    }
} elseif ($action === 'logout') {
    Auth::init();
    Auth::logout();
    header('Location: /index.php');
    exit;
}
