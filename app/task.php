<?php declare(strict_types=1);

function task_index(): void {
  $u = auth_user();
  $uid = $u['id'];
  $pdo = db();
  $stmt = $pdo->prepare('SELECT id,title,is_complete FROM tasks WHERE user_id=? ORDER BY created_at DESC');
  $stmt->execute([$uid]);
  $tasks = $stmt->fetchAll();
  render('tasks_index', ['tasks'=>$tasks]);
}

function task_create(): void {
  $u = auth_user();
  $uid = $u['id'];

  $errors = validate($_POST, ['title'=>'required|max:150']);
  if ($errors) { redirect('/tasks'); return; }

  $title = trim((string)($_POST['title'] ?? ''));
  $pdo = db();
  $pdo->prepare('INSERT INTO tasks(user_id,title) VALUES (?,?)')->execute([$uid,$title]);

  if (is_ajax()) {
    $id = (int)$pdo->lastInsertId();
    json_response(['ok'=>true,'id'=>$id,'title'=>$title,'is_complete'=>0]);
    return;
  }
  redirect('/tasks');
}

function task_update(): void {
  $u = auth_user();
  $uid = $u['id'];
  $id = (int)($_POST['id'] ?? 0);
  $title = trim((string)($_POST['title'] ?? ''));

  if ($id<=0 || $title==='') { json_response(['ok'=>false],422); return; }

  $pdo = db();
  $pdo->prepare('UPDATE tasks SET title=? WHERE id=? AND user_id=?')->execute([$title,$id,$uid]);

  if (is_ajax()) { json_response(['ok'=>true]); return; }
  redirect('/tasks');
}

function task_delete(): void {
  $u = auth_user();
  $uid = $u['id'];
  $id = (int)($_POST['id'] ?? 0);

  if ($id<=0) { json_response(['ok'=>false],422); return; }

  $pdo = db();
  $pdo->prepare('DELETE FROM tasks WHERE id=? AND user_id=?')->execute([$id,$uid]);

  if (is_ajax()) { json_response(['ok'=>true]); return; }
  redirect('/tasks');
}

function task_toggle(): void {
  $u = auth_user();
  $uid = $u['id'];
  $id = (int)($_POST['id'] ?? 0);

  if ($id<=0) { json_response(['ok'=>false],422); return; }

  $pdo = db();
  $pdo->prepare('UPDATE tasks SET is_complete = 1 - is_complete WHERE id=? AND user_id=?')->execute([$id,$uid]);

  if (is_ajax()) { json_response(['ok'=>true]); return; }
  redirect('/tasks');
}

function is_ajax(): bool {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) || (($_SERVER['HTTP_ACCEPT'] ?? '') === 'application/json');
}
