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
      $id = htmlspecialchars($_SESSION['id']);

      //データベース接続
      $dsn = 'mysql:dbname=mybooks;host:localhost;charset=utf8';
      $user ='root';
      $password = '';
      $dbh = new PDO($dsn,$user,$password);
      $dbh->query('SET NAMES utf8');

      //データベースから削除
      if(isset($id) && is_numeric($id)){
        $del = $dbh->prepare('DELETE FROM book_list WHERE id=?');
        $abc = $del->execute(array($id));
      }

      //データベース接続解除
      $dbh = null;
      ?>

      <div>
        <p>本を削除しました</p>
        <a href="list.php">一覧に戻る</a><br/>
        <a href="index.html">TOPに戻る</a>
      </div>


</body>
</html>
