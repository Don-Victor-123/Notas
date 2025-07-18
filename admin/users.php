<?php
session_start();
require '../config/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role']!=='ADMIN') {
    header('Location: ../auth/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $position = $_POST['position'];
    $stmt = $pdo->prepare(
        "INSERT INTO users(username,password,position,role) VALUES (?,?,?, 'USER')"
    );
    $stmt->execute([$username,$password,$position]);
}

$users = $pdo->query("SELECT id,username,position FROM users")->fetchAll();
include '../templates/header.php';
?>
<h2>Usuarios</h2>
<form method="post">
    <input name="username" placeholder="Usuario" required>
    <input name="password" type="password" placeholder="Contraseña" required>
    <input name="position" placeholder="Cargo">
    <button>Crear</button>
</form>
<table border="1">
    <tr><th>ID</th><th>Usuario</th><th>Cargo</th></tr>
    <?php foreach($users as $u): ?>
    <tr>
        <td><?= $u['id'] ?></td>
        <td><?= htmlspecialchars($u['username']) ?></td>
        <td><?= htmlspecialchars($u['position']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php include '../templates/footer.php'; ?>
