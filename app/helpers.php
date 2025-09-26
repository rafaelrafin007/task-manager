<?php declare(strict_types=1);

function e(string $v): string { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }
function redirect(string $to): void { header("Location: $to"); exit; }
function json_response(array $data, int $code=200): void {
  http_response_code($code);
  header('Content-Type: application/json');
  echo json_encode($data);
  exit;
}
function validate(array $data, array $rules): array {
  $errors = [];
  foreach ($rules as $field => $rule) {
    $val = trim((string)($data[$field] ?? ''));
    foreach (explode('|', $rule) as $r) {
      if ($r === 'required' && $val === '') $errors[$field][]='required';
      if (str_starts_with($r,'max:') && mb_strlen($val) > (int)substr($r,4)) $errors[$field][]='max';
      if ($r === 'email' && $val !== '' && !filter_var($val, FILTER_VALIDATE_EMAIL)) $errors[$field][]='email';
      if (str_starts_with($r,'min:') && mb_strlen($val) < (int)substr($r,4)) $errors[$field][]='min';
    }
  }
  return $errors;
}
