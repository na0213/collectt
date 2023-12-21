<?php
session_start();
require('../connect.php');

if (isset($_POST['id'])) {
    $pdo = db_conn();

    $stmt = $pdo->prepare('DELETE FROM sea WHERE id = ?');
    if ($stmt->execute([$_POST['id']])) {
        echo "削除成功";
    } else {
        echo "削除失敗";
    }
}

header('Location: sea.php');
exit();