<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../public/css/styles.css">
<title>Notas</title>
</head>
<body>
<nav>
<a href="../auth/logout.php">Salir</a>
<?php if(isset($_SESSION['role']) && $_SESSION['role']==='ADMIN'): ?> |
<a href="../admin/index.php">Admin</a>
<?php endif; ?>
</nav>
