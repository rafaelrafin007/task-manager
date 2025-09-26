<?php declare(strict_types=1);

function csrf_token(): string {
  if (empty($_SESSION['_csrf'])) $_SESSION['_csrf'] = bin2hex(random_bytes(32));
  return $_SESSION['_csrf'];
}
function csrf_verify(?string $t): bool {
  return is_string($t) && isset($_SESSION['_csrf']) && hash_equals($_SESSION['_csrf'], $t);
}
function csrf_field(): string {
  return '<input type="hidden" name="_token" value="'.e(csrf_token()).'">';
}
function require_post_csrf(): void {
  $token = $_POST['_token'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
  if (!csrf_verify($token)) { http_response_code(419); exit('CSRF failed'); }
}
