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

      //データベース接続
      $dsn = 'mysql:dbname=mybooks;host:localhost;charset=utf8';
      $user ='root';
      $password = '';
      $dbh = new PDO($dsn,$user,$password);
      $dbh->query('SET NAMES utf8');

      //セッション取得
      $_SESSION['id'] = $_POST['id'];
      // $id = $_SESSION['id'];

      //データベースから取得
      $books = $dbh->prepare('SELECT * FROM book_list WHERE id=?');
      $books->execute(array($_SESSION['id']));
      $book = $books->fetch();

      //データベース接続解除
      $dbh = null;
      ?>

      <div>
        <p>『<?php echo($book['title']); ?>』</p>
        <p>本当に削除しますか？</p>
        <form action="delete_fin.php" method="post">
          <button type="submit">削除</button>
        </form>
        <form action="list.php" method="post">
          <button type="submit">戻る</button>
        </form>


      </div>


</body>
</html>
