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


      //データベースから取得
      // $books = $dbh->query('SELECT * FROM book_list ORDER BY id');
      $books = $dbh->query('SELECT *
                            FROM book_list
                            LEFT JOIN author
                            ON book_list.author_id = author.author_id
                            LEFT JOIN company
                            ON book_list.company_id = company.company_id');

      //データベース接続解除
      $dbh = null;
    ?>

      <div>
      <?php while($book = $books->fetch()): ?>
      <p>
      ●<?php echo($book['title']); ?><br/>
      ー<?php echo($book['author_name']); ?><br/>
      ー<?php echo($book['company_name']); ?>
      </p>
      <a href="update.php?id=<?php echo($book['id']); ?>">編集</a>
      <a href="delete.php?id=<?php echo($book['id']); ?>">削除</a>
      <?php endwhile; ?>
      <br/>
      <br/>
      <a href="index.html">TOPに戻る</a>
      </div>


</body>
</html>
