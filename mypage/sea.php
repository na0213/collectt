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
    <link rel="stylesheet" href="../css/sea.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

    <div class="new_seatop">
        <p class="seatop"><a href="seatop.php">BEACH TOP</a></p>
        <div class="toptitle">
          <p class="mysea"><span class="mm">N</span>ew <span class="ss">B</span>each</p>
        </div>
    </div>
    <div class="main-visual">
    <form action="seasave.php" method="post" class="registrationform">
        <table class="table_design05">
            <p class="comment">好きなビーチを登録しよう！</p>
            <tr>
                <th>ビーチ名</th>
                <td>
                    <input type="text" name="seaname" class="c-form-text" value="<?php echo $_POST['seaname']??""; ?>">
                    <?php if (isset($error['seaname']) && ($error['seaname'] == "blank")): ?>
                    <p class="error">種類を入力してください</p>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>県名</th>
                <td>
                    <input type="text" name="prefecture" class="c-form-text" value="<?php echo $_POST['prefecture']??""; ?>">
                    <?php if (isset($error['prefecture']) && ($error['prefecture'] == "blank")): ?>
                    <p class="error">種類を入力してください</p>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>ポイント</th>
                <td>
                    <textarea name="seapoint" class="c-form-text" rows="10" value="<?php echo $_POST['seapoint']??""; ?>"></textarea>
                    <?php if (isset($error['seapoint']) && ($error['seapoint'] == "blank")): ?>
                    <p class="error">コメントを入力してください</p>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
        <div class="confirm">
            <input type="submit" value="登録" class="button">
        </div>
        </form>
   </div>

   
</body>

</html>