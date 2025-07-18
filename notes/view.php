<?php
session_start();
require '../config/db.php';
include '../templates/header.php';
?>

<div>
  <h2>Mis notas del día</h2>
  <textarea id="note-editor" placeholder="Escribe tu nota..."></textarea>
</div>

<script src="../public/js/autosave.js"></script>
<?php include '../templates/footer.php' ?>
