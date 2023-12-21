<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require('connect.php');
// ★ポイント1★
if (!isset($_SESSION['join'])) {
    header ('Location: register.php');
    exit();
}
// ★ポイント2★
$hash = password_hash($_SESSION['join']['password'], PASSWORD_BCRYPT);
// ★ポイント3★
if (!empty($_POST)) {
    $statement = $pdo->prepare('INSERT INTO member SET name=?, email=?, password=?');
    $statement->execute(array(
        $_SESSION['join']['name'],
        $_SESSION['join']['email'],
        $hash));
    unset($_SESSION['join']);
    header('Location: login.php');
    exit();
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
   <link rel="stylesheet" href="css/confirm.css">

</head>
<body>
   <div class="main-visual">
	<form action="" method="post">
	<input type="hidden" name="action" value="submit">

        <table class="table_design05">
            <tr>
                <th>name</th>
                <td>
                    <span class="check"><?php echo (htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES)); ?></span>
                </td>
            </tr>
            <tr>
                <th>email</th>
                <td>
					<span class="check"><?php echo (htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES)); ?></span>
                </td>
            </tr>
            <tr>
                <th>password</th>
                <td>
					<span class="check">* * * * * *</span>
                </td>
            </tr>
        </table>
		<div class="scroll">
			<div class="determin">
			<input type="button" onclick="event.preventDefault();location.href='register.php?action=rewrite'" value="修正する" name="rewrite" class="button-log">
			</div>
			<div class="confirm">
				<input type="submit" value="登録" name="registration" class="button">
			</div>
		</div>
    </form>
   </div>

</body>
</html>

