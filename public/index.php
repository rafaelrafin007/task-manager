<?php declare(strict_types=1);

require __DIR__ . '/../config.php';
require __DIR__ . '/../app/helpers.php';
require __DIR__ . '/../app/csrf.php';
require __DIR__ . '/../app/db.php';
require __DIR__ . '/../app/auth.php';
require __DIR__ . '/../app/task.php';

session_name($config['session_name']);
session_start();

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

function render(string $view, array $vars=[]): void {
  extract($vars);
  require __DIR__ . "/../views/$view.php";
}

require __DIR__ . '/../routes.php';
