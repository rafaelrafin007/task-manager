<?php declare(strict_types=1);

function auth_user(): ?array { return $_SESSION['user'] ?? null; }

function auth_handle_register(): void {
  $errors = validate($_POST, [
    'name' => 'required|max:100',
    'email' => 'required|email|max:190',
    'password' => 'required|min:8'
  ]);
  if ($errors) { render('auth_register', ['errors'=>$errors]); return; }

  $name = trim((string)$_POST['name']);
  $email = strtolower(trim((string)$_POST['email']));
  $pass = (string)$_POST['password'];

  $pdo = db();
  $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
  $stmt->execute([$email]);
  if ($stmt->fetch()) { render('auth_register', ['errors'=>['email'=>['taken']]]); return; }

  $hash = password_hash($pass, PASSWORD_DEFAULT);
  $pdo->prepare('INSERT INTO users(name,email,password_hash) VALUES (?,?,?)')->execute([$name,$email,$hash]);

  $_SESSION = [];
  session_regenerate_id(true);
  $_SESSION['user'] = ['id'=>(int)$pdo->lastInsertId(),'name'=>$name,'email'=>$email];
  redirect('/tasks');
}

function auth_handle_login(): void {
  $errors = validate($_POST, [
    'email' => 'required|email|max:190',
    'password' => 'required'
  ]);
  if ($errors) { render('auth_login', ['errors'=>$errors]); return; }

  $email = strtolower(trim((string)$_POST['email']));
  $pass = (string)$_POST['password'];

  $pdo = db();
  $stmt = $pdo->prepare('SELECT id,name,email,password_hash FROM users WHERE email = ? LIMIT 1');
  $stmt->execute([$email]);
  $u = $stmt->fetch();
  if (!$u || !password_verify($pass, $u['password_hash'])) {
    render('auth_login', ['errors'=>['auth'=>['invalid']]]);
    return;
  }

  $_SESSION = [];
  session_regenerate_id(true);
  $_SESSION['user'] = ['id'=>(int)$u['id'],'name'=>$u['name'],'email'=>$u['email']];
  redirect('/tasks');
}

function auth_handle_logout(): void {
  $_SESSION = [];
  if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time()-42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
  }
  session_destroy();
  redirect('/login');
}
