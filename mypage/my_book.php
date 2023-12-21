<?php
session_start();
require('../connect.php');

// ★ポイント1★
if (isset($_SESSION['id']) && ($_SESSION['time'] + 3600 > time())) {
    $_SESSION['time'] = time();

    $members = $pdo->prepare('SELECT * FROM member WHERE id=?');
    $members->execute(array($_SESSION['id']));
    $member = $members->fetch();

    // ログインしているユーザーのIDに基づいてbookテーブルからデータを取得
    $stmt = $pdo->prepare("SELECT * FROM book WHERE user_id = ?");
    $stmt->execute([$member['id']]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="../css/mybook.css">
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
        <div class="title-flex">
            <p class="mybook-regi"><a href="new_book.php">登録</a></p>
        </div>
        <?php if ($results) : ?>
            <div class="l-inner">
            <div class="c-cards">
                <?php foreach ($results as $result) : ?>
                    <a href="/" class="c-card c-card--hoverUp">
                        <figure class="c-card__img"><img src="<?php echo htmlspecialchars($result['bookimage'], ENT_QUOTES); ?>" alt="Book Image" /></figure>
                        <div class="c-card__body">
                            <p class="c-card__text"><?php echo htmlspecialchars($result['bookname'], ENT_QUOTES); ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
            </div>
        <?php else : ?>
            <p>登録された本はありません。</p>
        <?php endif; ?>

    </div>
</body>

</html>