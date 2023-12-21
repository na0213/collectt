<?php
session_start();
require('../connect.php');
$pdo = db_conn();

$sql = 'DELETE FROM manhole_image WHERE image_id = :image_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':image_id', (int)$_GET['id'], PDO::PARAM_INT);
$stmt->execute();

header('Location: manhole.php');
exit();