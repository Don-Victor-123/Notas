let noteId = null;
const textarea = document.getElementById('note-editor');
const groupSelect = document.getElementById('group-select');
const notesList = document.getElementById('notes-list');
let timer;

function loadNotes() {
  fetch('../notes/fetch.php?group_id=' + groupSelect.value)
    .then(r => r.json())
    .then(notes => {
      notesList.innerHTML = notes.map(n => `<p>${n.content}</p>`).join('');
    });
}

groupSelect.addEventListener('change', () => {
  noteId = null;
  textarea.value = '';
  loadNotes();
});

textarea.addEventListener('input', () => {
  clearTimeout(timer);
  timer = setTimeout(() => {
    const payload = {
      group_id: groupSelect.value,
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
      noteId = data.id;
      loadNotes();
    });
  }, 500);
});

loadNotes();
