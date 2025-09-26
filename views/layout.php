// views/layout.php
<?php ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Task Manager</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <meta name="csrf-token" content="<?= e(csrf_token()) ?>">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="/tasks">Tasks</a>
    <div class="ms-auto">
      <?php if (!empty($_SESSION['user'])): ?>
        <form method="post" action="/logout" class="d-inline">
          <?= csrf_field() ?>
          <button class="btn btn-sm btn-outline-light">Logout</button>
        </form>
      <?php else: ?>
        <a href="/login" class="btn btn-sm btn-outline-light">Login</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<main class="container py-4">
  <?= $content ?? '' ?>
</main>
<script src="/assets/js/app.js"></script>
</body>
</html>
