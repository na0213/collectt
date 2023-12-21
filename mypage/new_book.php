<?php
session_start();
require('../connect.php');
 
// ★ポイント1★
if (isset($_SESSION['id']) && ($_SESSION['time'] + 3600 > time())) {
    $_SESSION['time'] = time();
 
    $members=$pdo->prepare('SELECT * FROM member WHERE id=?');
    $members->execute(array($_SESSION['id']));
    $member=$members->fetch();
} else {
    header('Location: ../login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/book.css">
</head>
<body>
    <header>
      <h1 class="top-title">
         <a href="../top.html">COLLECTERS</a>
      </h1>
      <nav class="pc-nav">
         <ul>
            <li class="about"><a href="../index.php">My Page</a></li>
            <li class="collect"><a href="../collect.html">COLLECT</a></li>
            <li class="login"><?php echo htmlspecialchars($member['name'], ENT_QUOTES); ?>さん<br>
                <a href="../login.php">LOGOUT</a>
            </li>
         </ul>
      </nav>
      <nav class="sp-nav">
         <ul>
            <li><a href="../index.php">My Page</a></li>
            <li><a href="../collect.html">COLLECT</a></li>
            <li><?php echo htmlspecialchars($member['name'], ENT_QUOTES); ?></li>
            <li class="close"><span>閉じる</span></li>
         </ul>
      </nav>
      <div id="hamburger">
         <span></span>
      </div>
   </header>
    <div class="main-visual">
    <p class="booktop"><a href="my_book.php">My BOOKへ</a></p>
      <div class="toptitle">
          <p class="mybook"><span class="mm">N</span>ew <span class="bb">B</span>OOK</p>
      </div>
    </div>
    <div class="search">
        <p class="booktitle">SERCH</p>
        <p>
        <input type="text" id="formText" name="myFormText" class="c-form-text" placeholder="書類タイトルを入力" aria-label="books" aria-describedby="basic-addon1">
        </p>
        <button id="btn" class="btn btn-primary my-2">SERCH</button>
        <p>
        </p>
    </div>


  <div id="bookItem" class="album py-5 bg-light"></div>


<!-- jquery が先！必須！必ず！ -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- jqueryを先に読み込んでから作成したものを読み込む -->
<script src="../js/book.js"></script>
</body>
</html>