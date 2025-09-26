<?php ob_start(); ?>
<div class="row justify-content-center">
  <div class="col-md-4">
    <h4 class="mb-3">Login</h4>
    <?php if (!empty($errors['auth'])): ?>
      <div class="alert alert-danger">Invalid credentials.</div>
    <?php endif; ?>
    <form method="post" action="/login">
      <?= csrf_field() ?>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input name="email" type="email" class="form-control" required maxlength="190">
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input name="password" type="password" class="form-control" required>
      </div>
      <button class="btn btn-primary w-100">Login</button>
    </form>
    <p class="mt-3 small">No account? <a href="/register">Register</a></p>
  </div>
</div>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
