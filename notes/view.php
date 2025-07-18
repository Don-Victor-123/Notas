<?php
session_start();
require '../config/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$groups = $pdo->prepare(
    "SELECT g.id,g.name FROM groups g " .
    "JOIN group_members gm ON g.id=gm.group_id " .
    "WHERE gm.user_id=?"
);
$groups->execute([$user_id]);
$groups = $groups->fetchAll();

include '../templates/header.php';
?>
<h2>Mis grupos</h2>
<select id="group-select">
    <?php foreach($groups as $g): ?>
    <option value="<?= $g['id'] ?>"><?= htmlspecialchars($g['name']) ?></option>
    <?php endforeach; ?>
</select>
<div id="notes-list"></div>
<textarea id="note-editor" placeholder="Escribe tu nota..."></textarea>
<script src="../public/js/autosave.js"></script>
<?php include '../templates/footer.php' ?>
