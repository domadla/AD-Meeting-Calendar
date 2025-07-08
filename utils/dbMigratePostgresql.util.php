<?php

declare(strict_types=1);

// 1) Composer autoload
require 'vendor/autoload.php';

// 2) Composer bootstrap
require 'bootstrap.php';

// 3) envSetter
require_once UTILS_PATH . '/envSetter.util.php';

echo "✅ Connected to PostgreSQL.\n";

// ——— Connect to PostgreSQL ———
$dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['db']}";
$pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$tables = ['meeting_users', 'tasks', 'meetings', 'users'];

echo "⬇️ Dropping old tables…\n";
foreach ($tables as $table) {
    // Use IF EXISTS so it won’t error if the table is already gone
    $pdo->exec("DROP TABLE IF EXISTS {$table} CASCADE;");
}

// ——— Apply schemas before truncating ———
echo "📦 Applying schema files...\n";
$schemaFiles = [
    'database/user.model.sql',
    'database/meeting.model.sql',
    'database/meeting_user.model.sql',
    'database/task.model.sql'
];

foreach ($schemaFiles as $file) {
    echo "📄 Applying $file...\n";
    $sql = file_get_contents($file);
    if ($sql === false) {
        throw new RuntimeException("❌ Could not read $file");
    }
    $pdo->exec($sql);
}

echo "🔁 Truncating tables…\n";
foreach ($tables as $table) {
    $pdo->exec("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE;");
}

echo "✅ PostgreSQL migration complete.\n";
