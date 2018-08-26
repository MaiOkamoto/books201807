<!DOCTYPE html>
<?php
  session_start();
 ?>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>所有漫画一覧</title>
</head>
<body>
  <h2>所有漫画一覧</h2>
  <?php
  //画像アップロード準備
    if(!empty($_FILES['image']['name'])){

      $tempfile =  $_FILES['image']['tmp_name'];
      $filename =  $_FILES['image']['name'];

      echo "<pre>";
      var_dump($tempfile);
      echo "</pre>";

      if (is_uploaded_file($tempfile)) {
        if(move_uploaded_file($tempfile,"./images/".$filename)){
          echo $filename."をアップロードしました";
          echo "<br/>";
        }else{
          echo "画像はアップロードしていません。";
          echo "<br/>";
        }
      }
    }

     //変数格納
      $id =  htmlspecialchars($_SESSION['id']);
      $title = htmlspecialchars($_POST['title']);
      $author_no = htmlspecialchars($_POST['author_no']);
      $class = htmlspecialchars($_POST['class']);

      //チェックボックスの配列確認
      if(is_array($_POST['company_no'])){
        $company_no = htmlspecialchars(implode(",", $_POST['company_no']));
      }else{
        $company_no = htmlspecialchars($_POST['company_no']);
      }

      if(is_array($_POST['category_no'])){
        $category_no =  htmlspecialchars(implode(",", $_POST['category_no']));
      }else{
        $category_no = htmlspecialchars($_POST['$category_no']);
      }


      //データベース接続
      $dsn = 'mysql:dbname=mybooks;host:localhost;charset=utf8';
      $user ='root';
      $password = '';
      $dbh = new PDO($dsn,$user,$password);
      $dbh->query('SET NAMES utf8');

      $books = $dbh->prepare('SELECT *
                            FROM book_list
                            LEFT JOIN author
                            ON book_list.author_id = author.author_id
                            WHERE id=?');
      $books->execute(array($_SESSION['id']));
      $book = $books->fetch();


      if(!empty($_FILES['image']['name'])){
        $image = "./images/".$_FILES['image']['name'];
      }else{
        $image = $book['image'];
      }

      //データベースを更新
      $sql = 'UPDATE book_list SET title=:title, author_id=:author_no, company_id=:company_no, category_id=:category_no, class=:class, image=:image WHERE id=:id';
      $stmt = $dbh->prepare($sql);
      $stmt->bindParam(":id",$id);
      $stmt->bindParam(":title",$title);
      $stmt->bindParam(":author_no",$author_no);
      $stmt->bindParam(":company_no",$company_no);
      $stmt->bindParam(":category_no",$category_no);
      $stmt->bindParam(":class",$class);
      $stmt->bindParam(":image",$image);
      $stmt->execute();


      //データベース接続解除
      $dbh = null;
      ?>

      <div>
        <p>内容を変更しました</p>
        <a href="list.php">一覧に戻る</a>
      </div>


</body>
</html>
