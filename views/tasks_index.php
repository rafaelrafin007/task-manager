// views/tasks_index.php
<?php ob_start(); ?>
<div class="row">
  <div class="col-lg-8 mx-auto">
    <h4 class="mb-3">Your Tasks</h4>
    <form id="create-form" method="post" action="/tasks/create" class="row g-2 mb-3">
      <?= csrf_field() ?>
      <div class="col-8">
        <input name="title" class="form-control" placeholder="Task title" required maxlength="150">
      </div>
      <div class="col-4 d-grid">
        <button class="btn btn-primary">Add</button>
      </div>
    </form>
    <ul id="task-list" class="list-group">
      <?php foreach (($tasks ?? []) as $t): ?>
        <li class="list-group-item d-flex align-items-center justify-content-between" data-id="<?= (int)$t['id'] ?>">
          <div class="d-flex align-items-center">
            <input class="form-check-input me-2 toggle" type="checkbox" <?= $t['is_complete'] ? 'checked' : '' ?>>
            <span class="<?= $t['is_complete'] ? 'text-decoration-line-through text-muted' : '' ?> task-title">
              <?= e($t['title']) ?>
            </span>
          </div>
          <div class="btn-group">
            <button class="btn btn-sm btn-outline-secondary edit">Edit</button>
            <button class="btn btn-sm btn-outline-danger delete">Delete</button>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
