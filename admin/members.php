<?php
session_start();
require '../config/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role']!=='ADMIN') {
    header('Location: ../auth/login.php');
    exit;
}

// Fetch groups and users for the form
$groups = $pdo->query("SELECT * FROM groups")->fetchAll();
$users  = $pdo->query("SELECT * FROM users WHERE role='USER'")->fetchAll();

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $group_id = intval($_POST['group_id']);
    $user_id  = intval($_POST['user_id']);
    $g = $pdo->prepare("SELECT required_position FROM groups WHERE id=?");
    $g->execute([$group_id]);
    $grp = $g->fetch();
    $u = $pdo->prepare("SELECT position FROM users WHERE id=?");
    $u->execute([$user_id]);
    $usr = $u->fetch();
    $ok = $grp && $usr &&
          ($grp['required_position']===null ||
           $grp['required_position']===$usr['position']);
    if ($ok) {
        $stmt = $pdo->prepare(
            "REPLACE INTO group_members(group_id,user_id) VALUES (?,?)"
        );
        $stmt->execute([$group_id, $user_id]);
        $msg = 'Usuario agregado';
    } else {
        $msg = 'El perfil no cumple los requisitos del grupo';
    }
}

include '../templates/header.php';
?>
<h2>Asignar Usuarios a Grupos</h2>
<?php if(isset($msg)) echo "<p>$msg</p>"; ?>
<form method="post">
    <select name="group_id">
        <?php foreach($groups as $g): ?>
        <option value="<?= $g['id'] ?>">
            <?= htmlspecialchars($g['name']) ?>
        </option>
        <?php endforeach; ?>
    </select>
    <select name="user_id">
        <?php foreach($users as $u): ?>
        <option value="<?= $u['id'] ?>">
            <?= htmlspecialchars($u['username']) ?>
            (<?= htmlspecialchars($u['position']) ?>)
        </option>
        <?php endforeach; ?>
    </select>
    <button>Agregar</button>
</form>
<?php include '../templates/footer.php'; ?>
