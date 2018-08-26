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

          //画像アップロード準備
          $tempfile =  $_FILES['image']['tmp_name'];
          $filename =  $_FILES['image']['name'];

          if (is_uploaded_file($tempfile)) {
            if(move_uploaded_file($tempfile,"./images/".$filename)){
              echo $filename."をアップロードしました";
              echo "<br/>";
            }else{
              echo "ファイルをアップデートできません。";
              echo "<br/>";
            }
          }


      //データベース接続
      $dsn = 'mysql:dbname=mybooks;host:localhost;charset=utf8';
      $user ='root';
      $password = '';
      $dbh = new PDO($dsn,$user,$password);
      $dbh->query('SET NAMES utf8');

      //戻った時のカウント
      $_SESSION['visited'] = +1;

      //セッション取得
          $_SESSION['title'] = $_POST['title'];
          $title = $_SESSION['title'];

          $_SESSION['author_no'] = $_POST['author_no'];
          $author_no = $_SESSION['author_no'];

          $company_no = $_POST['company_no'];
          $_SESSION['company_no'] = $_POST['company_no'];

          $category_no = $_POST['category_no'];
          $_SESSION['category_no'] = $_POST['category_no'];

          $_SESSION['class'] = $_POST['class'];
          $class = $_SESSION['class'];

          $_SESSION['image_name'] = $_FILES['image']['name'];
          $image_name = $_SESSION['image_name'];

          $_SESSION['image'] = $_FILES['image'];

          $title = htmlspecialchars($title);
          $author_no = htmlspecialchars($author_no);
          $class = htmlspecialchars($class);
          $image_name = htmlspecialchars($image_name);

          //データベースから取得
          $authors = $dbh->prepare('SELECT * FROM author WHERE author_id=?');
          $authors->execute(array($author_no));
          $author = $authors->fetch();

          $companys = $dbh->prepare('SELECT * FROM company');
          $companys->execute();

          $categorys = $dbh->prepare('SELECT * FROM category');
          $categorys->execute();

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
      while($company = $companys->fetch()){
        foreach ($company_no as $valu) {
          if($company['company_id'] == $valu){
            echo htmlspecialchars($company['company_name']. "  ");
          }
        }
      }
      echo '<br/>';
      echo 'カテゴリー:';
      while($category = $categorys->fetch()){
        foreach ($category_no as $valu) {
          if($category['category_id'] == $valu){
            echo htmlspecialchars($category['category_name']. "  ");
          }
        }
      }

      echo '<br/>';
      echo '分類:';
      echo $class;
      echo '<br/>';
      echo '添付画像:';
      echo $image_name;
      echo '<br/>';
      echo '<br/>';

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

      ?>
</body>
</html>
