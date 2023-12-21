<?php

try {
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root', ''); //root全権限がある
  } catch (PDOException $e) {
    exit('DBConnectError:' . $e->getMessage());
  }

function db_conn() {
  try {
      $db_name = 'gs_db'; //データベース名
      $db_id   = 'root'; //アカウント名
      $db_pw   = ''; //パスワード：MAMPは'root'
      $db_host = 'localhost'; //DBホスト
      //return = この外でも関数を使えるようにするということ
      return $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
  } catch (PDOException $e) {
      exit('DB Connection Error:' . $e->getMessage());
  }
}
