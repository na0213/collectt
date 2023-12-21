<?php
session_start();
require('../connect.php');

// POSTリクエストのデータを受け取る
$input = json_decode(file_get_contents('php://input'), true);

$title = $input['title'];
$image = $input['image'];
$userId = $_SESSION['id'];

try {
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root', '');
    $stmt = $pdo->prepare("INSERT INTO book (bookname, bookimage, user_id) VALUES (?, ?, ?)");
    $stmt->execute([$title, $image, $userId]);

    echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
