<?php
session_start();
require('connect.php');
 
// ★ポイント1★
if (isset($_SESSION['id']) && ($_SESSION['time'] + 3600 > time())) {
    $_SESSION['time'] = time();
 
    $members=$pdo->prepare('SELECT * FROM member WHERE id=?');
    $members->execute(array($_SESSION['id']));
    $member=$members->fetch();
} else {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <header>
      <h1 class="top-title">
         <a href="top.html">COLLECTERS</a>
      </h1>
      <nav class="pc-nav">
         <ul>
            <li class="about"><a href="index.php">My Page</a></li>
            <li class="collect"><a href="collect.html">COLLECT</a></li>
            <li class="login"><?php echo htmlspecialchars($member['name'], ENT_QUOTES); ?>さん<br>
                <a href="login.php">LOGOUT</a>
            </li>
         </ul>
      </nav>
      <nav class="sp-nav">
         <ul>
            <li><a href="index.php">My Page</a></li>
            <li><a href="collect.html">COLLECT</a></li>
            <li><?php echo htmlspecialchars($member['name'], ENT_QUOTES); ?></li>
            <li class="close"><span>閉じる</span></li>
         </ul>
      </nav>
      <div id="hamburger">
         <span></span>
      </div>
   </header>
   <div class="main-visual">
    <div class="l-inner">
        <div class="c-cards">
          <a href="mypage/my_book.php" class="c-card c-card--hoverUp">
            <figure class="c-card__img"><img src="img/book.png" loading="lazy" width="360" height="240" alt="浅葱色" /></figure>
            <div class="c-card__body">
              <p class="c-card__text">本</p>
              <time class="c-card__time" datetime="2022-01-03"> お気に入りの本 </time>
            </div> </a>
          <a href="mypage/manhole.php" class="c-card c-card--hoverUp">
            <figure class="c-card__img"><img src="img/manhole.png" loading="lazy" width="360" height="240" alt="支子色" /></figure>
            <div class="c-card__body">
              <p class="c-card__text">マンホール</p>
              <time class="c-card__time" datetime="2022-01-03"> レアマンホールを探せ </time>
            </div> </a>
          <a href="/" class="c-card c-card--hoverUp">
            <figure class="c-card__img"><img src="img/stamp.png" loading="lazy" width="360" height="240" alt="鴇色" /></figure>
            <div class="c-card__body">
              <p class="c-card__text">切手</p>
              <time class="c-card__time" datetime="2022-01-03"> 切手収集癖 </time>
            </div> </a>
          <a href="mypage/seatop.php" class="c-card c-card--hoverUp">
            <figure class="c-card__img"><img src="img/seatop.png" loading="lazy" width="360" height="240" alt="浅葱色" /></figure>
            <div class="c-card__body">
              <p class="c-card__text">ビーチ</p>
              <time class="c-card__time" datetime="2022-01-03"> 海の世界 </time>
            </div> </a>
        </div>
    
      </div>
   </div>

</body>
</html>