<!DOCTYPE html>
<?php
  session_start();
 ?>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>漫画新規登録（登録）</title>
</head>
<body>
  <h2>漫画新規登録（登録）</h2>
  <?php

      //データベースに接続
      $dsn = 'mysql:dbname=mybooks; host:localhost; charset=utf8';
      $user = 'root';
      $password = '';
      $dbh = new PDO($dsn, $user, $password);
      $dbh->query('SET NAMES utf8');

      $title = htmlspecialchars($_SESSION['title']);
      $author_no = htmlspecialchars($_SESSION['author_no']);
      $company_no = htmlspecialchars($_SESSION['company_no']);
      $class = htmlspecialchars($_SESSION['class']);

      //データベースから取得
      $authors = $dbh->prepare('SELECT * FROM author WHERE author_id=?');
      $authors->execute(array($author_no));
      $author = $authors->fetch();

      $companys = $dbh->prepare('SELECT * FROM company WHERE company_id=?');
      $companys->execute(array($company_no));
      $company = $companys->fetch();

//echo_r($GLOBALS);
      echo '【登録が完了しました】';
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
      echo '<br/>';
      echo '<a href="new.php">新規登録画面に戻る</a>';
      echo '<br/>';
      echo '<a href="index.html">TOPに戻る</a>';

      if(!$_SESSION['check']) {
        // データベースに保存
        $sql = 'INSERT INTO book_list (title,author_id,company_id,class,created)
        value (:title,:author_no,:company_no,:class,NOW())';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":title",$title);
        $stmt->bindParam(":author_no",$author_no);
        $stmt->bindParam(":company_no",$company_no);
        $stmt->bindParam(":class",$class);
        $stmt->execute();

        $_SESSION['check'] = true;
      }else{
        echo '<br/>';
        echo '登録済みです';
      }
      //データベース接続解除
      $dbh = null;

      //セッションクリア
      $_SESSION['title'] = '';
      $_SESSION['author_no'] = '';
      $_SESSION['company_no'] = '';
      $_SESSION['class'] = '';

      ?>
</body>
</html>
