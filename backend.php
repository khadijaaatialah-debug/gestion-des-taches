<?php
require_once __DIR__ . '/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'new') {
        $title = trim($_POST['title'] ?? '');
        if ($title !== '') {
            $stmt = $pdo->prepare("INSERT INTO todo (title) VALUES (?)");
            $stmt->execute([$title]);
        }
    } elseif ($action === 'toggle') {
        $id = (int)($_POST['id'] ?? 0);
        $stmt = $pdo->prepare("UPDATE todo SET done = 1 - done WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        $stmt = $pdo->prepare("DELETE FROM todo WHERE id = ?");
        $stmt->execute([$id]);
    }
    header("Location: index.php");
    exit;
}
$taches = $pdo->query("SELECT * FROM todo ORDER BY created_at DESC")->fetchAll();
