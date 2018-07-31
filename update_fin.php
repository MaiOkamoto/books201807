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

      $_SESSION['title'] = $_POST['title'];
      $_SESSION['author_no'] = $_POST['author_no'];
      $_SESSION['company_no'] = $_POST['company_no'];
      $_SESSION['class'] = $_POST['class'];

      var_dump($_POST['title']);
      var_dump($_POST['author_no']);
      var_dump($_POST['company_no']);
      var_dump($_POST['class']);


      $id =  htmlspecialchars($_SESSION['id']);
      $title = htmlspecialchars($_SESSION['title']);
      $author_no = htmlspecialchars($_SESSION['author_no']);
      $company_no = htmlspecialchars($_SESSION['company_no']);
      $class = htmlspecialchars($_SESSION['class']);

      //データベース接続
      $dsn = 'mysql:dbname=mybooks;host:localhost;charset=utf8';
      $user ='root';
      $password = '';
      $dbh = new PDO($dsn,$user,$password);
      $dbh->query('SET NAMES utf8');

      //データベースを更新
      $sql = 'UPDATE book_list SET (title,author_id,company_id,class)
      value (:title,:author_no,:company_no,:class) WHERE id=$id';
      $stmt = $dbh->prepare($sql);
      $stmt->bindParam(":id",$id);
      $stmt->bindParam(":title",$title);
      $stmt->bindParam(":author_no",$author_no);
      $stmt->bindParam(":company_no",$company_no);
      $stmt->bindParam(":class",$class);
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
