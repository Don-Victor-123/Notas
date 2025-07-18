<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role']!=='ADMIN') {
    header('Location: ../auth/login.php');
    exit;
}
include '../templates/header.php';
?>
<h2>Panel Administrador</h2>
<ul>
    <li><a href="users.php">Gestionar Usuarios</a></li>
    <li><a href="groups.php">Gestionar Grupos</a></li>
    <li><a href="members.php">Asignar Usuarios a Grupos</a></li>
</ul>
<?php include '../templates/footer.php'; ?>
