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

      //チェックボックスの配列確認
      if(is_array($_SESSION['company_no'])){
        $company_no = implode(',', $_SESSION['company_no']);
      }else{
        $company_no = $_SESSION['company_no'];
      }

      if(is_array($_SESSION['category_no'])){
        $category_no = implode(',', $_SESSION['category_no']);
      }else{
        $category_no = $_SESSION['category_no'];
      }


      $class = htmlspecialchars($_SESSION['class']);

      $image_url = "./images/".$_SESSION['image_name'];
      $image_url = htmlspecialchars($image_url);

      //データベースから取得
      $authors = $dbh->prepare('SELECT * FROM author WHERE author_id=?');
      $authors->execute(array($author_no));
      $author = $authors->fetch();

      $companys = $dbh->prepare('SELECT * FROM company');
      $companys->execute();
      $companylist = $companys->fetchAll(PDO::FETCH_ASSOC);

      $categorys = $dbh->prepare('SELECT * FROM category');
      $categorys->execute();
      $categorylist = $categorys->fetchAll(PDO::FETCH_ASSOC);

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
    foreach($companylist as $company){
        foreach($_SESSION['company_no'] as $valu) {
          if($company['company_id'] == $valu){
            echo $company['company_name'],"  ";
          }
        }
      }

      echo '<br/>';
      echo 'カテゴリー:';
      // var_dump($category_no);
      foreach($categorylist as $category){
        foreach($_SESSION['category_no'] as $valu) {
          if($category['category_id'] == $valu){
            echo $category['category_name'], " ";
          }
        }
      }
      echo '<br/>';
      echo '分類:';
      echo $class;
      echo '<br/>';
      echo '添付画像:';
      echo $image_url;
      echo '<br/>';
      echo '<br/>';
      echo '<a href="new.php">新規登録画面に戻る</a>';
      echo '<br/>';
      echo '<a href="index.html">TOPに戻る</a>';

      if(!$_SESSION['check']) {
        // データベースに保存
        $sql = 'INSERT INTO book_list (title,author_id,company_id,category_id,class,image,created)
        value (:title,:author_no,:company_no,:category_no,:class,:image,NOW())';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":title",$title);
        $stmt->bindParam(":author_no",$author_no);
        $stmt->bindParam(":company_no",$company_no);
        $stmt->bindParam(":category_no",$category_no);
        $stmt->bindParam(":class",$class);
        $stmt->bindParam(":image",$image_url);
        $stmt->execute();

        $_SESSION['check'] = true;

        //セッションクリア
        $_SESSION['title'] = '';
        $_SESSION['author_no'] = '';
        $_SESSION['company_no'] = '';
        $_SESSION['category_no'] = '';
        $_SESSION['class'] = '';
        $_SESSION['image'] = '';
      }else{
        echo '<br/>';
        echo '登録済みです';
      }
      //データベース接続解除
      $dbh = null;



      ?>
</body>
</html>
