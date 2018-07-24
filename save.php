<!DOCTYPE html>
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

      //new.html→check.php→save.phpに移動したデータを保存
      //データベースに接続

      $dsn = 'mysql:dbname=mybooks; host:localhost; charset=utf8';
      $user = 'root';
      $password = '';
      $dbh = new PDO($dsn, $user, $password);
      $dbh->query('SET NAMES utf8');

      session_start();
      $title = $_SESSION['title'];
      $author = $_SESSION['author'];
      $company = $_SESSION['company'];

      $title = htmlspecialchars($title);
      $author = htmlspecialchars($author);
      $company = htmlspecialchars($company);
//print_r($GLOBALS);
      print '【登録が完了しました】';
      print '<br/>';
      print 'タイトル:';
      print $title;
      print '<br/>';
      print '著者:';
      print $author;
      print '<br/>';
      print '出版社:';
      print $company;
      print '<br/>';
      print '<br/>';
      print '<a href="new.php">登録画面に戻る</a>';

      if(!$_SESSION['check']) {
        // データベースに保存
        $sql = 'INSERT INTO books (title,author,company)
        value (:title,:author,:company)';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":title",$title);
        $stmt->bindParam(":author",$author);
        $stmt->bindParam(":company",$company);
        $stmt->execute();

        $_SESSION['check'] = true;
      }else{
        print '<br/>';
        print '登録済みです';
      }
      //接続解除
      $dbh = null;

      //セッションクリア
      // session_unset();

      ?>
</body>
</html>
