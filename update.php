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
      $id = $_GET['id'];
      $_SESSION['id'] = $_GET['id'];

      $books = $dbh->prepare('SELECT *
                            FROM book_list
                            LEFT JOIN author
                            ON book_list.author_id = author.author_id
                            LEFT JOIN company
                            ON book_list.company_id = company.company_id
                            WHERE id=?');
      $books->execute(array($id));
      $book = $books->fetch();

      $authors = $dbh->query('SELECT * FROM author');
      $companys = $dbh->query('SELECT * FROM company');

      //データベース接続解除
      $dbh = null;
      ?>

      <div>
        <form action="update_fin.php" method="post">

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
            <?php while($company = $companys->fetch()): ?>
              <?php if($book['company_id'] == $company['company_id']): ?>
                <input type="checkbox" name="company_no" value="<?php echo($company['company_id']); ?>" checked>
                <?php echo($company['company_name']); ?>
              <?php else: ?>
                <input type="checkbox" name="company_no" value="<?php echo($company['company_id']); ?>">
                <?php echo($company['company_name']); ?>
              <?php endif; ?>
            <?php endwhile; ?>
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

          <button type="submit">変更</button>
        </form>
        <br/>

        <form action="list.php" method="post">
          <button type="submit">戻る</button>
        </form>

      </div>


</body>
</html>
