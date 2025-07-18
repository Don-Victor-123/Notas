let noteId = null;
const textarea = document.getElementById('note-editor');
const groupSelect = document.getElementById('group-select');
const notesList = document.getElementById('notes-list');
let timer;

function esc(str){
  return str.replace(/[&<>]/g, s => ({'&':'&amp;','<':'&lt;','>':'&gt;'}[s]));
}

function saveNote(id, content, status){
  const payload = {group_id: groupSelect.value, content, id, status};
  return fetch('../notes/save.php', {
    method: 'POST',
    headers:{'Content-Type':'application/json'},
    body: JSON.stringify(payload)
  }).then(r=>r.json());
}

function renderNotes(notes){
  notesList.innerHTML='';
  notes.forEach(n=>{
    const div=document.createElement('div');
    div.className='note';
    div.dataset.id=n.id;
    div.dataset.status=n.status;
    div.innerHTML=`<div class="note-meta">${esc(n.name)} - ${n.created_at} - <span class="note-status">${n.status}</span><span class="note-menu">\u22ee</span></div>`+
      `<div class="note-content">${esc(n.content)}</div>`;
    notesList.appendChild(div);
  });
}

function loadNotes(){
  fetch('../notes/fetch.php?group_id='+groupSelect.value)
    .then(r=>r.json())
    .then(renderNotes);
}

groupSelect.addEventListener('change',()=>{
  noteId=null;
  textarea.value='';
  loadNotes();
});

textarea.addEventListener('input', ()=>{
  clearTimeout(timer);
  timer=setTimeout(()=>{
    saveNote(noteId, textarea.value, 'Pendiente').then(d=>{
      noteId=d.id;
      loadNotes();
    });
  },500);
});

notesList.addEventListener('click', e=>{
  if(e.target.classList.contains('note-menu')){
    const note=e.target.closest('.note');
    const menu=document.createElement('div');
    menu.className='popup';
    menu.innerHTML=`<button class="edit">Editar</button> <select class="status">
      <option>Pendiente</option><option>En Proceso</option><option>Realizado</option>
    </select>`;
    note.appendChild(menu);
    menu.querySelector('.status').value=note.dataset.status;
    menu.querySelector('.edit').onclick=()=>{
      const cont=note.querySelector('.note-content');
      const ta=document.createElement('textarea');
      ta.value=cont.textContent;
      note.replaceChild(ta, cont);
      ta.focus();
      ta.addEventListener('blur',()=>{
        saveNote(note.dataset.id, ta.value, note.dataset.status).then(loadNotes);
      },{once:true});
      menu.remove();
    };
    menu.querySelector('.status').onchange=ev=>{
      note.dataset.status=ev.target.value;
      saveNote(note.dataset.id, note.querySelector('.note-content').textContent, ev.target.value)
        .then(()=>{loadNotes();});
      menu.remove();
    };
  }
});

loadNotes();
