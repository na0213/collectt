<?php
session_start();
require('../connect.php');
$pdo = db_conn();
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

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // 画像を取得
    $sql = 'SELECT * FROM manhole_image ORDER BY created_at DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $images = $stmt->fetchAll();
} else {
    // 画像を保存
    if (!empty($_FILES['image']['name'])) {
        $name = $_FILES['image']['name'];
        $type = $_FILES['image']['type'];
        $content = file_get_contents($_FILES['image']['tmp_name']);
        $size = $_FILES['image']['size'];

        $sql = 'INSERT INTO manhole_image(image_name, image_type, image_content, image_size, created_at)
                VALUES (:image_name, :image_type, :image_content, :image_size, now())';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':image_name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':image_type', $type, PDO::PARAM_STR);
        $stmt->bindValue(':image_content', $content, PDO::PARAM_STR);
        $stmt->bindValue(':image_size', $size, PDO::PARAM_INT);
        $stmt->execute();
    }
    header('Location:manhole.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/manhole.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
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
<div class="toptitle">
          <p class="mybook"><span class="mm">M</span>an <span class="bb">h</span>ole</p>
      </div>
<div class="container mt-5">
<div class="col-md-4 pt-4 pl-4">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>画像を選択</label>
                    <input type="file" name="image" required>
                </div>
                <button type="submit" class="btn btn-primary">保存</button>
            </form>
        </div>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 border-right">
            <ul class="list-unstyled">
                <?php for($i = 0; $i < count($images); $i++): ?>
                    <li class="media mt-5">
                        <div class="media">
                        <div class="media-img">
                        <a class="man_img" href="#lightbox" data-toggle="modal" data-slide-to="<?= $i; ?>">
                            <img src="image.php?id=<?= $images[$i]['image_id']; ?>" width="100" height="auto" class="mr-3">
                        </a>
                        </div>
                        <div class="media-body">
                              <a href="javascript:void(0);" 
                               onclick="var ok = confirm('削除しますか？'); if (ok) location.href='delete_m.php?id=<?= $images[$i]['image_id']; ?>'">
                              <i class="far fa-trash-alt"></i></a>
                        </div>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>
    </div>
</div>
<div class="modal carousel slide" id="lightbox" tabindex="-1" role="dialog" data-ride="carousel">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <ol class="carousel-indicators">
            <?php for ($i = 0; $i < count($images); $i++): ?>
                <li data-target="#lightbox" data-slide-to="<?= $i; ?>" <?php if ($i == 0) echo 'class="active"'; ?>></li>
            <?php endfor; ?>
        </ol>

        <div class="carousel-inner">
            <?php for ($i = 0; $i < count($images); $i++): ?>
                <div class="carousel-item <?php if ($i == 0) echo 'active'; ?>">
                    <img src="image.php?id=<?= $images[$i]['image_id']; ?>" class="d-block w-100">
                </div>
            <?php endfor; ?>
        </div>

        <a class="carousel-control-prev" href="#lightbox" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#lightbox" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>