<?php ob_start(); ?>
<div class="row justify-content-center">
  <div class="col-md-4">
    <h4 class="mb-3">Register</h4>
    <?php if (!empty($errors)): ?>
      <div class="alert alert-warning">Please fix the highlighted fields.</div>
    <?php endif; ?>
    <form method="post" action="/register">
      <?= csrf_field() ?>
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input name="name" class="form-control <?= isset($errors['name'])?'is-invalid':'' ?>" required maxlength="100">
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input name="email" type="email" class="form-control <?= isset($errors['email'])?'is-invalid':'' ?>" required maxlength="190">
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input name="password" type="password" class="form-control <?= isset($errors['password'])?'is-invalid':'' ?>" required minlength="8">
      </div>
      <button class="btn btn-success w-100">Create account</button>
    </form>
    <p class="mt-3 small"><a href="/login">Back to login</a></p>
  </div>
</div>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
