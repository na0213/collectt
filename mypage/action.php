<?php
//action11.php
$connect = new PDO("mysql:host=localhost;dbname=test;charset=utf8;",  'root',  'password' );
if(!$connect){
    echo "データベースに接続できません";
}
 
if( isset($_POST["action"]) )
{
    //問い合わせ　一覧表示
    if($_POST["action"] == "Display"){
        $output = '
            <table class="table table-bordered table-striped table-sm ">
                <tr>
                    <th width="10%" class="text-center">ID</th>
                    <th width="25%">画像</th>
                    <th width="45%">ファイル名</th>
                    <th width="10%" class="text-center">変更</th>
                    <th width="10%" class="text-center">削除</th>
                </tr>
        ';
        $sql = "select * from manhole_image order by id DESC";     
        $stmt = $connect->prepare($sql);
        $stmt->execute(); 
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $path = 'images11/';
            $output .= '
                <tr>
                    <td class="text-center">'.$row["id"].'</td>                    
                    <td>
                        <img src="data:image/jpeg;base64,'.base64_encode(file_get_contents("images11/".$row['name'])).'" class="img-thumbnail" style="width:120px;height:auto">
                    </td>
                    <td class="text-left">'.$row["name"].'</td> 
                    <td class="text-center"><button type="button" name="update" class="btn btn-warning bt-xs update" id="'.$row["id"].'">変更</button></td>
                    <td class="text-center"><button type="button" name="delete" class="btn btn-danger bt-xs delete" id="'.$row["id"].'">削除</button></td>
                </tr>
            ';
        }
        $output .= '</table>';
        echo $output;
    }
    //ここまで問い合わせ　一覧表示
 
    //挿入
    if($_POST["action"] == "insert"){
        $uploaddir = './images11/';
        $uploadfile = $uploaddir . ($_FILES['image']['name']);
        $file = $_FILES["image"]["name"];
        $sql = 'INSERT INTO image_table(name) VALUE (:name)';
        $prepare = $connect->prepare($sql);    
        $prepare->bindValue(':name', $file, PDO::PARAM_STR);
        if( $prepare->execute() and move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile) ){
            echo "画像".$file."を登録しました";
        }else{
            echo "画像".$file."を登録できませんでした";
        }
    }
 
    //更新
    if($_POST["action"] == "update"){
        $uploaddir = './images11/';
        $uploadfile = $uploaddir . ($_FILES['image']['name']);
        $file = $_FILES["image"]["name"];
        $sql = 'UPDATE manhole_image SET name=:name WHERE id=:id'; 
        $prepare = $connect->prepare($sql);    
        $prepare->bindValue(':name', $file, PDO::PARAM_STR);
        $prepare->bindValue(':id', $_POST["image_id"], PDO::PARAM_INT);
        if( $prepare->execute() and move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile) ){
            echo "画像".$file."に変更しました";
        }else{
            echo "画像".$file."に変更できませんでした";
        }
    }
 
    //削除
    if($_POST["action"] == "delete"){
        //$uploaddir = './images11/';
        //$uploadfile = $uploaddir . ($_FILES['image']['name']);
        //$file = addslashes($_FILES["image"]["name"]);
        $sql = 'DELETE FROM manhole_image WHERE id=:id';
        $prepare = $connect->prepare($sql);    
        $prepare->bindValue(':id', $_POST["image_id"], PDO::PARAM_INT);
        if( $prepare->execute() ){
            echo "画像を削除しました";
        }else{
            echo "画像を削除できませんでした";
        }
    }  
 
}
?>