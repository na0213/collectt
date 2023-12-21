<?php
session_start();
require('../connect.php');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="utf-8">
   <meta name="robots" content="noindex,nofollow">
   <title>HTMLベーステンプレート</title>

   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <link rel="stylesheet" href="../css/reset.css">
   <link rel="stylesheet" href="../css/mybook.css">

</head>
<body>
  <header>
      <h1 class="top-title">
         <a href="../top.html">COLLECTERS</a>
      </h1>
      <nav class="pc-nav">
         <ul>
            <li class="about"><a href="#">ABOUT</a></li>
            <li class="collect"><a href="../collect.html">COLLECT</a></li>
            <li class="register"><a href="../register.php">REGISTER</a></li>
            <li class="login"><a href="../login.php">LOGIN</a></li>
         </ul>
      </nav>
      <nav class="sp-nav">
         <ul>
            <li><a href="#">ABOUT</a></li>
            <li><a href="../collect.html">COLLECT</a></li>
            <li><a href="../register.php">REGISTER</a></li>
            <li><a href="../login.php">LOGIN</a></li>
            <li class="close"><span>閉じる</span></li>
         </ul>
      </nav>
      <div id="hamburger">
         <span></span>
      </div>
  </header>

  <div class="main-visual">
      <div class="toptitle">
          <p class="mybook"><span class="mm">F</span>avorite <span class="bb">B</span>OOK</p>
      </div>
  </div>

  <?php
      $stmt = $pdo->prepare("SELECT * FROM book");
      $stmt->execute(); 
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($results): // データが存在する場合
      ?>
    <div class="l-inner">
    <div class="c-cards">
        <?php foreach($results as $result): ?>
            <a href="/" class="c-card c-card--hoverUp">
                <figure class="c-card__img"><img src="<?php echo htmlspecialchars($result['bookimage'], ENT_QUOTES); ?>" alt="Book Image" /></figure>
                <div class="c-card__body">
                    <p class="c-card__text"><?php echo htmlspecialchars($result['bookname'], ENT_QUOTES); ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
    </div>
  <?php
    else: // データが存在しない場合
        echo "<p>登録された本はありません。</p>";
    endif;
    ?>
   


<!-- jquery が先！必須！必ず！ -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- jqueryを先に読み込んでから作成したものを読み込む -->
<!-- <script src="js/main.js"></script> -->
</body>
</html>