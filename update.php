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
      // $id = $_GET['id'];
      $_SESSION['id'] = $_POST['id'];

      $books = $dbh->prepare('SELECT *
                            FROM book_list
                            LEFT JOIN author
                            ON book_list.author_id = author.author_id
                            WHERE id=?');
      $books->execute(array($_SESSION['id']));
      $book = $books->fetch();

      $authors = $dbh->prepare('SELECT * FROM author');
      $authors->execute();

      $companys = $dbh->prepare('SELECT * FROM company');
      $companys->execute();
      $companylist = $companys->fetchAll(PDO::FETCH_ASSOC);

      $categorys = $dbh->prepare('SELECT * FROM category');
      $categorys->execute();
      $categorylist = $categorys->fetchAll(PDO::FETCH_ASSOC);

      //データベース接続解除
      $dbh = null;
      ?>

      <div>
        <form action="update_fin.php" method="post" enctype="multipart/form-data">

          タイトル<br/>
          <input type="text" name="title" value="<?php echo($book['title']); ?>"><br/><br/>

          著者を入力<br/>
          <select name="author_no">
            <?php while($author = $authors->fetch()): ?>
              <?php if($book['author_id'] == $author['author_id']): ?>
              <option value="<?php echo($author['author_id']) ?>" selected><?php echo($author['author_name']); ?></option>
            <?php else: ?>
              <option value="<?php echo($author['author_id']) ?>"><?php echo($author['author_name']); ?></option>
            <?php endif; ?>
            <?php endwhile; ?>
          </select><br/><br/>

          出版社を入力<br/>
          <?php
          $company_array = explode(',',$book['company_id']);
          ?>
            <?php foreach($companylist as $company): ?>
              <input type="checkbox" name="company_no[]" value="<?php echo($company['company_id']); ?>"
              <?php if(!empty($book['company_id'])): ?>
                <?php foreach($company_array as $valu ): ?>
                  <?php if($company['company_id'] == $valu): ?>
                    <?php echo  "checked"; ?>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php endif; ?>
              ><?php echo($company['company_name']); ?>
            <?php endforeach; ?>
            <br/><br/>

          カテゴリーを選ぶ</br>
          <?php $category_array = explode(',',$book['category_id']); ?>

          <?php foreach($categorylist as $category):  ?>
            <input type="checkbox" name="category_no[]" value="<?php echo($category['category_id']); ?>"
            <?php if(!empty($book['category_id'])): ?>
              <?php foreach($category_array as $valu): ?>
                <?php if($category['category_id'] == $valu): ?>
                  <?php echo "checked"; ?>
                <?php endif; ?>
              <?php endforeach; ?>
            <?php endif; ?>
            ><?php echo($category['category_name']); ?>
            <?php endforeach; ?>
            <br/><br/>

          週刊誌or月刊誌<br/>
          <?php if($book['class'] == '週刊誌'): ?>
          <input type="radio" name="class" value="週刊誌" checked>週刊誌
          <input type="radio" name="class" value="月刊誌">月刊誌
          <?php else: ?>
          <input type="radio" name="class" value="週刊誌">週刊誌
          <input type="radio" name="class" value="月刊誌" checked>月刊誌
          <?php endif; ?>
          <br/><br/>

          画像ファイルの添付<br/>
          <?php if(!empty($book['image'])): ?>
          登録画像：<?php echo $book['image']  ?><br/>
          <input type="file" name="image"><br/>
          <?php else: ?>
          <input type="file" name="image" >
          <?php endif; ?>
          <br/><br/>

          <button type="submit">変更</button>
        </form>
        <br/>

        <form action="list.php" method="post">
          <button type="submit">戻る</button>
        </form>

      </div>


</body>
</html>
