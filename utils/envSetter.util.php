<?php
require BASE_PATH . '/vendor/autoload.php';

$envFile = BASE_PATH . '/.env';
if (file_exists($envFile)) {
    $dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
    $dotenv->load();
}

// MongoDB config
$mongoConfig = [
    'uri' => $_ENV['MONGO_URI'],
    'db' => $_ENV['MONGO_DB']
];

// PostgreSQL config
$pgConfig = [
    'host' => $_ENV['PG_HOST'],
    'port' => $_ENV['PG_PORT'],
    'db' => $_ENV['PG_DB'],
    'user' => $_ENV['PG_USER'],
    'pass' => $_ENV['PG_PASS']
];

return [
    'mongoConfig' => $mongoConfig,
    'pgConfig' => $pgConfig,
];
