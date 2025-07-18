<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: ../auth/login.php');
  exit;
}

$role = $_SESSION['role'];
if ($role==='ADMIN') {
  header('Location: ../admin/users.php');
} else {
  header('Location: ../notes/view.php');
}
