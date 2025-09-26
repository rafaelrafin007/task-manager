<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

Dotenv\Dotenv::createImmutable(__DIR__)->safeLoad();

$config = [
  'app_url' => $_ENV['APP_URL'] ?? 'http://localhost:8000',
  'env' => $_ENV['APP_ENV'] ?? 'local',
  'session_name' => $_ENV['SESSION_NAME'] ?? 'tm_sess',
  'db' => [
    'host' => $_ENV['DB_HOST'] ?? '127.0.0.1',
    'port' => (int)($_ENV['DB_PORT'] ?? 3306),
    'name' => $_ENV['DB_NAME'] ?? 'task_manager',
    'user' => $_ENV['DB_USER'] ?? 'root',
    'pass' => $_ENV['DB_PASS'] ?? '',
  ],
];
