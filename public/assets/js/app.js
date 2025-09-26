// public/assets/js/app.js
(function () {
  const token = document.querySelector('meta[name="csrf-token"]')?.content;

  // Create
  const form = document.getElementById('create-form');
  if (form) {
    form.addEventListener('submit', async (e) => {
      if (!window.fetch) return; // fallback to normal POST
      e.preventDefault();
      const fd = new FormData(form);
      const res = await fetch('/tasks/create', {
        method: 'POST',
        headers: {'X-CSRF-Token': token, 'X-Requested-With':'fetch'},
        body: fd
      });
      if (!res.ok) return location.reload();
      const data = await res.json();
      const li = document.createElement('li');
      li.className = 'list-group-item d-flex align-items-center justify-content-between';
      li.dataset.id = data.id;
      li.innerHTML = `
        <div class="d-flex align-items-center">
          <input class="form-check-input me-2 toggle" type="checkbox">
          <span class="task-title">${escapeHtml(data.title)}</span>
        </div>
        <div class="btn-group">
          <button class="btn btn-sm btn-outline-secondary edit">Edit</button>
          <button class="btn btn-sm btn-outline-danger delete">Delete</button>
        </div>`;
      document.getElementById('task-list').prepend(li);
      form.reset();
    });
  }

  // Delegate toggle/edit/delete
  const list = document.getElementById('task-list');
  if (list) {
    list.addEventListener('click', async (e) => {
      const li = e.target.closest('li[data-id]');
      if (!li) return;
      const id = li.dataset.id;

      if (e.target.classList.contains('toggle')) {
        await fetch('/tasks/toggle', reqBody({id}));
        li.querySelector('.task-title').classList.toggle('text-decoration-line-through');
        li.querySelector('.task-title').classList.toggle('text-muted');
      }

      if (e.target.classList.contains('delete')) {
        const ok = confirm('Delete this task?');
        if (!ok) return;
        await fetch('/tasks/delete', reqBody({id}));
        li.remove();
      }

      if (e.target.classList.contains('edit')) {
        const span = li.querySelector('.task-title');
        const current = span.textContent.trim();
        const next = prompt('Edit task title:', current);
        if (!next || next === current) return;
        await fetch('/tasks/update', reqBody({id, title: next}));
        span.textContent = next;
      }
    });
  }

  function reqBody(obj) {
    const fd = new FormData();
    for (const k in obj) fd.append(k, obj[k]);
    return {method:'POST', headers:{'X-CSRF-Token': token, 'X-Requested-With':'fetch'}, body: fd};
  }

  function escapeHtml(s) {
    return s.replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m]));
  }
})();
