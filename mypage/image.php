<?php
session_start();
require('../connect.php');
$pdo = db_conn();

$sql = 'SELECT * FROM manhole_image WHERE image_id = :image_id LIMIT 1';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':image_id', (int)$_GET['id'], PDO::PARAM_INT);
$stmt->execute();
$image = $stmt->fetch();

header('Content-type: ' . $image['image_type']);
echo $image['image_content'];
exit();
?>