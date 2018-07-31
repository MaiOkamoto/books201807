<!DOCTYPE html>
<?php
    session_start();
 ?>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>漫画新規登録（確認）</title>
</head>
<body>
  <h2>漫画新規登録（確認）</h2>
  <?php

      //データベース接続
      $dsn = 'mysql:dbname=mybooks;host:localhost;charset=utf8';
      $user ='root';
      $password = '';
      $dbh = new PDO($dsn,$user,$password);
      $dbh->query('SET NAMES utf8');

      //セッション取得
          $_SESSION['title'] = $_POST['title'];
          $title = $_SESSION['title'];

          $_SESSION['author_no'] = $_POST['author_no'];
          $author_no = $_SESSION['author_no'];

          $_SESSION['company_no'] = $_POST['company_no'];
          $company_no = $_SESSION['company_no'];

          $_SESSION['class'] = $_POST['class'];
          $class = $_SESSION['class'];

          $title = htmlspecialchars($title);
          $author_no = htmlspecialchars($author_no);
          $company_no = htmlspecialchars($company_no);
          $class = htmlspecialchars($class);

          //データベースから取得
          $authors = $dbh->prepare('SELECT * FROM author WHERE author_id=?');
          $authors->execute(array($author_no));
          $author = $authors->fetch();

          $companys = $dbh->prepare('SELECT * FROM company WHERE company_id=?');
          $companys->execute(array($company_no));
          $company = $companys->fetch();

      //データベース接続解除
      $dbh = null;

      echo '<br/>';
      echo 'タイトル:';
      echo $title;
      echo '<br/>';
      echo '著者:';
      echo $author['author_name'];
      echo '<br/>';
      echo '出版社:';
      echo $company['company_name'];
      echo '<br/>';
      echo '分類:';
      echo $class;
      echo '<br/>';


      if($title == '' || $author_no == '' || $company_no == '' || $class == ''){
        echo '<form method="post" action="new.php">';
        echo '<button type="submit">戻る</button>';
        echo '</form>';
      }else{
        echo '<form method="post" action="new.php">';
        echo '<button type="submit">戻る</button>';
        echo '</form>';
        echo '<br/>';

        echo '<form method="post" action="save.php">';

        // echo '<input name="title" type="hidden" value="'.$title.'">';
        // echo '<input name="author" type="hidden"  value="'.$author.'">';
        // echo '<input name="company" type="hidden" value="'.$company.'">';
;
        echo '<button type="submit">登録</button>';
        echo '</form>';
      }

      ?>
</body>
</html>
