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
      $_SESSION['id'] = $_POST['id'];
      $id = $_SESSION['id'];

      $_SESSION['title'] = $_POST['title'];
      $title = $_SESSION['title'];

      $id = htmlspecialchars($id);
      $title = htmlspecialchars($title);

      //データベース接続
      $dsn = 'mysql:dbname=mybooks;host:localhost;charset=utf8';
      $user ='root';
      $password = '';
      $dbh = new PDO($dsn,$user,$password);
      $dbh->query('SET NAMES utf8');

      //データベースを更新
      $sql = 'UPDATE INTO book_list (title)
      value (:title) WHERE id=:id';
      $stmt = $dbh->prepare($sql);
      $stmt->bindParam(":title",$title);
      $stmt->bindParam(":id",$id);
      $stmt->execute();

      $book = $dbh->prepare('UPDATE book_list SET title=? WHERE id=?');
      $book->execute(array($title, $id));

      //データベース接続解除
      $dbh = null;
      ?>

      <div>
        <p>内容を変更しました</p>
        <a href="list.php">一覧に戻る</a>
      </div>


</body>
</html>
