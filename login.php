<?php
session_start();
require('connect.php');
 
// ★ポイント1★
if (!empty($_POST)) {
    if (($_POST['email'] != '') && ($_POST['password'] != '')) {
        $login = $pdo->prepare('SELECT * FROM member WHERE email=?');
        $login->execute(array($_POST['email']));
        $member=$login->fetch();
	// 認証
        if ($member != false && password_verify($_POST['password'],$member['password'])) {
            $_SESSION['id'] = $member['id'];
            $_SESSION['time'] =time();
            header('Location: index.php');
            exit();
        } else {
            $error['login']='failed';
        } 
    } else {
        $error['login'] ='blank';
    }
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
   <link rel="stylesheet" href="css/login.css">

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
	 <form action='' method="post">
	 	<table class="table_design05">
            <tr>
                <th>email</th>
                <td>
					<input type="text" name="email" class="c-form-text" 
					value="<?php echo htmlspecialchars($_POST['email']??"", ENT_QUOTES); ?>">
					<?php if (isset($error['login']) && ($error['login'] =='blank')): ?>
					<p class="error">メールとパスワードを入力してください</p>
					<?php endif; ?>

					<?php if (isset($error['login']) && $error['login'] =='failed'): ?>
					<p class="error">メールかパスワードが間違っています</p>
					<?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>password</th>
                <td>
					<input type="password" name="password" class="c-form-text" 
					value="<?php echo htmlspecialchars($_POST['password']??"", ENT_QUOTES); ?>">
                </td>
            </tr>
        </table>

		<div class="scroll">
			<div class="determin">
				<input type="submit" value="ログイン" class="button-log">
			</div>
			<div class="confirm">
				<a href="register.php" class="button">ユーザ登録</a>
			</div>
		</div>
	 </form>
   </div>

<!-- jquery が先！必須！必ず！ -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- jqueryを先に読み込んでから作成したものを読み込む -->
<script src="js/main.js"></script>
</body>
</html>