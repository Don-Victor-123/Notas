<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD']==='POST') {
  $u = $_POST['username'];
  $p = $_POST['password'];

  $stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
  $stmt->execute([$u]);
  $user = $stmt->fetch();
  if ($user && password_verify($p, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role']    = $user['role'];
    header('Location: ../public/index.php');
    exit;
  } else {
    $error = "Credenciales inválidas";
  }
}
include '../templates/header.php';
?>
<form method="post">
  <input name="username" placeholder="Usuario" required>
  <input name="password" type="password" placeholder="Contraseña" required>
  <button>Entrar</button>
  <?= isset($error) ? "<p>$error</p>" : "" ?>
</form>
<?php include '../templates/footer.php' ?>
