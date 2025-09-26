<?php
declare(strict_types=1);

$u = auth_user();

/* Home */
if ($path === '/') return redirect($u ? '/tasks' : '/login');

/* Auth */
if ($path === '/login' && $method==='GET') return render('auth_login');
if ($path === '/login' && $method==='POST') { require_post_csrf(); return auth_handle_login(); }
if ($path === '/register' && $method==='GET') return render('auth_register');
if ($path === '/register' && $method==='POST') { require_post_csrf(); return auth_handle_register(); }
if ($path === '/logout' && $method==='POST') { require_post_csrf(); return auth_handle_logout(); }

/* Guard */
if (!$u) return redirect('/login');

/* Tasks */
if ($path === '/tasks' && $method==='GET') return task_index();
if ($path === '/tasks/create' && $method==='POST') { require_post_csrf(); return task_create(); }
if ($path === '/tasks/update' && $method==='POST') { require_post_csrf(); return task_update(); }
if ($path === '/tasks/delete' && $method==='POST') { require_post_csrf(); return task_delete(); }
if ($path === '/tasks/toggle' && $method==='POST') { require_post_csrf(); return task_toggle(); }

/* 404 */
http_response_code(404); echo 'Not Found';
