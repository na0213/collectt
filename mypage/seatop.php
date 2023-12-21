<?php
session_start();
require('../connect.php');

if (isset($_SESSION['id']) && ($_SESSION['time'] + 3600 > time())) {
    $_SESSION['time'] = time();

    $members = $pdo->prepare('SELECT * FROM member WHERE id=?');
    $members->execute(array($_SESSION['id']));
    $member = $members->fetch();

    // ログインしているユーザーのIDに基づいてbookテーブルからデータを取得
    $stmt = $pdo->prepare("SELECT * FROM sea WHERE user_id = ?");
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
    <link rel="stylesheet" href="../css/sea.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bodytop">
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

    <div class="main-visual-sea">
    <div class="title-flex">
        <p class="sea-regi"><a class="seacolor" href="sea.php">登録</a></p>
    </div>
    <!-- <form action="seasave.php" method="post" class="favoritesea"> -->
        <table class="table_design05">
            <tr>
                <th class="table-title">ビーチ</th>
                <th class="table-title">エリア</th>
                <th class="table-title">ポイント</th>
                <th class="table-title">削除</th>
            </tr>
            <?php if ($results) : ?>
                <?php foreach ($results as $result) : ?>
                <tr>
                    <td>
                        <p class="c-card__text"><?php echo htmlspecialchars($result['seaname'], ENT_QUOTES); ?></p>
                    </td>
                    <td>
                        <p class="c-card__text"><?php echo htmlspecialchars($result['prefecture'], ENT_QUOTES); ?></p>
                    </td>
                    <td>
                    <form action="update.php" method="post">
                        <p class="c-card__text">
                            <textarea name="seapoint" class="c-form-text" rows="10"><?php echo htmlspecialchars($result['seapoint'], ENT_QUOTES); ?></textarea>
                            <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                            <button type="submit"><i class="fa-regular fa-square-check"></i></button>
                        </p>
                    </form>
                    </td>
                    <td class="delete_b">
                    <form action="delete.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                        <button type="submit"><i class="fa-solid fa-trash"></i></button>
                    </form>
                    </td>
                <?php endforeach; ?>
                </tr>
            <?php else : ?>
            <p>登録されたビーチはありません。</p>
            <?php endif; ?>
        </table>
    <!-- </form> -->
   </div>
</body>

</html>