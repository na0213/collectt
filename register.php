<?php
session_start();
require('connect.php');

if (!empty($_POST) ) {
    if ($_POST['name'] == "") {
        $error['name'] = 'blank';
    }
    if ($_POST['email'] == "") {
        $error['email'] = 'blank';
    } else {
       $member =  $pdo->prepare('SELECT COUNT(*) AS cnt FROM member WHERE email=?');
       $member->execute(array($_POST['email']));
       $record = $member->fetch();
       if($record['cnt'] > 0) {
        $error['email'] = 'duplicate';
       }
    }
    if ($_POST['password'] == "") {
        $error['password'] = 'blank';
    }
    if (strlen($_POST['password'])<4) {
        $error['password'] = 'length';
    }
    if (empty($error)) {
        $_SESSION['join'] = $_POST;
        header('Location: confirm.php');
        exit();
    }
}
if (isset($_SESSION['join']) && isset($_REQUEST['action']) && ($_REQUEST['action'] == 'rewrite')) {
    $_POST =$_SESSION['join'];
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="utf-8">
   <meta name="robots" content="noindex,nofollow">
   <title>HTMLベーステンプレート</title>

   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <link rel="stylesheet" href="css/reset.css">
   <link rel="stylesheet" href="css/register.css">

</head>
<body>
   <header>
      <h1 class="top-title">
         <a href="top.html">COLLECTERS</a>
      </h1>
      <nav class="pc-nav">
         <ul>
            <li class="about"><a href="#">ABOUT</a></li>
            <li class="collect"><a href="collect.html">COLLECT</a></li>
            <li class="register"><a href="register.php">REGISTER</a></li>
            <li class="login"><a href="login.php">LOGIN</a></li>
         </ul>
      </nav>
      <nav class="sp-nav">
         <ul>
            <li><a href="#">ABOUT</a></li>
            <li><a href="collect.html">COLLECT</a></li>
            <li><a href="register.php">REGISTER</a></li>
            <li><a href="login.php">LOGIN</a></li>
            <li class="close"><span>閉じる</span></li>
         </ul>
      </nav>
      <div id="hamburger">
         <span></span>
      </div>
   </header>
   <div class="main-visual">
   <form action="" method="post" class="registrationform">
        <table class="table_design05">
            <tr>
                <th>nickname</th>
                <td>
                    <input type="text" name="name" class="c-form-text" value="<?php echo $_POST['name']??""; ?>">
                    <?php if (isset($error['name']) && ($error['name'] == "blank")): ?>
                    <p class="error">名前を入力してください</p>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>email</th>
                <td>
                    <input type="text" name="email" class="c-form-text" value="<?php echo $_POST['email']??""; ?>">
                    <?php if (isset($error['email']) && ($error['email'] == "blank")): ?>
                    <p class="error">emailを入力してください</p>
                    <?php endif; ?>
                    <?php if (isset($error['email']) && ($error['email'] == "duplicate")): ?>
                    <p class="error">すでにそのemailは登録されています。</p>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>password</th>
                <td>
                    <input type="password" name="password" class="c-form-text" value="<?php echo $_POST['password']??""; ?>">
                    <?php if (isset($error['password']) && ($error['password'] == "blank")): ?>
                    <p class="error"> パスワードを入力してください</p>
                    <?php endif; ?>
                    <?php if (isset($error['password']) && ($error['password'] == "length")): ?>
                    <p class="error"> 4文字以上で指定してください</p>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
        <div class="confirm">
            <input type="submit" value="確認" class="button">
        </div>
    </form>

   </div>

<!-- jquery が先！必須！必ず！ -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- jqueryを先に読み込んでから作成したものを読み込む -->
<script src="js/main.js"></script>
</body>
</html>
