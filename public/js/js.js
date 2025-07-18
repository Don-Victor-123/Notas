let noteId = null;
const textarea = document.getElementById('note-editor');
let timer;

textarea.addEventListener('input', () => {
  clearTimeout(timer);
  timer = setTimeout(() => {
    const payload = {
      group_id: /* tu grupo activo, p.ej. 1 */,
      content: textarea.value,
      id: noteId
    };
    fetch('../notes/save.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    })
    .then(r => r.json())
    .then(data => {
      noteId = data.id; // guardamos el ID tras crear
    });
  }, 500);
});
