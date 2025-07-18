<?php
session_start();
require '../config/db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$user_id = $_SESSION['user_id'];
$group_id = intval($_GET['group_id'] ?? 0);

$stmt = $pdo->prepare(
    "SELECT 1 FROM group_members WHERE group_id=? AND user_id=?"
);
$stmt->execute([$group_id, $user_id]);
if (!$stmt->fetchColumn()) {
    echo json_encode([]);
    exit;
}

$notes = $pdo->prepare(
    "SELECT n.id,n.content,n.created_at,n.status,u.name FROM notes n " .
    "JOIN users u ON n.author_id=u.id WHERE n.group_id=? ORDER BY n.created_at DESC"
);
$notes->execute([$group_id]);
echo json_encode($notes->fetchAll());
