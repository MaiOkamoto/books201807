<!DOCTYPE html>
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
      $sql = 'SELECT * FROM books WHERE 1';
      $stmt = $dbh->prepare($sql);
      $stmt->execute();

      //結果データを表示
      while(1){
          $rec = $stmt->fetch(PDO::FETCH_ASSOC);
          if($rec == false){
              break;
          }
          print $rec['title'];
          print '&nbsp;';
          print $rec['author'];
          print '&nbsp;';
          print $rec['company'];
          print '<br/>';
      }

      $dbh = null;

      ?>
</body>
</html>
