<?php
session_start();
header('Content-Type: application/json');
require '../config/db.php';
$user_id = $_SESSION['user_id'];

$data = json_decode(file_get_contents('php://input'), true);
$group   = intval($data['group_id']);
$content = $data['content'];
$id      = isset($data['id']) ? intval($data['id']) : 0;

if ($id>0) {
  // UPDATE
  $stmt = $pdo->prepare("UPDATE notes SET content=?, updated_at=NOW() WHERE id=? AND author_id=?");
  $stmt->execute([$content, $id, $user_id]);
} else {
  // INSERT
  $stmt = $pdo->prepare("INSERT INTO notes (group_id,author_id,content) VALUES (?,?,?)");
  $stmt->execute([$group, $user_id, $content]);
  $id = $pdo->lastInsertId();
}

echo json_encode(['status'=>'ok','id'=>$id]);
