<?php
session_start();
require '../config/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role']!=='ADMIN') {
    header('Location: ../auth/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $name = $_POST['name'];
    $pos  = $_POST['position'];
    $stmt = $pdo->prepare(
        "INSERT INTO groups(name, required_position, created_by) VALUES (?,?,?)"
    );
    $stmt->execute([$name, $pos, $_SESSION['user_id']]);
}

$groups = $pdo->query("SELECT * FROM groups")->fetchAll();
include '../templates/header.php';
?>
<h2>Grupos</h2>
<form method="post">
    <input name="name" placeholder="Nombre" required>
    <input name="position" placeholder="Cargo requerido">
    <button>Crear</button>
</form>
<table border="1">
    <tr><th>ID</th><th>Nombre</th><th>Cargo requerido</th></tr>
    <?php foreach($groups as $g): ?>
    <tr>
        <td><?= $g['id'] ?></td>
        <td><?= htmlspecialchars($g['name']) ?></td>
        <td><?= htmlspecialchars($g['required_position']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php include '../templates/footer.php'; ?>
