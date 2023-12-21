<?php
session_start();
require('../connect.php');

// POSTリクエストのデータを受け取る
// $input = json_decode(file_get_contents('php://input'), true);

$seaname = $_POST['seaname'];
$prefecture = $_POST['prefecture'];
$seapoint = $_POST['seapoint'];
$userId = $_SESSION['id'];

try {
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root', '');
    $stmt = $pdo->prepare("INSERT INTO sea (seaname, prefecture, seapoint, user_id, date) VALUES (?, ?, ?, ?, sysdate())");
    $stmt->execute([$seaname, $prefecture, $seapoint, $userId]);

    header('Location: sea.php');
    exit();
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}


