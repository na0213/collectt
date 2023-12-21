<?php
$seapoint   = $_POST['seapoint'];
$id = $_POST['id'];

//2. DB接続します
require('../connect.php');
$pdo = db_conn();

//３．データ登録SQL作成

// UPDATE テーブル名 SET 更新対象1=:更新データ ,更新対象2=:更新データ2,... WHERE id = 対象ID;
$stmt = $pdo->prepare('UPDATE sea SET seapoint = :seapoint where id = :id; ');

// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':seapoint', $seapoint, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status === false) {
    //*** function化する！******\
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    header('Location: sea.php');
    exit();
}
