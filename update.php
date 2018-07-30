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

      $books = $dbh->prepare('SELECT *
                            FROM book_list
                            LEFT JOIN author
                            ON book_list.author_id = author.author_id
                            LEFT JOIN company
                            ON book_list.company_id = company.company_id
                            WHERE id=?');
      $books->execute(array($id));
      $book = $books->fetch();

      //データベース接続解除
      $dbh = null;
      ?>

      <div>
        <form action="update_fin.php" method="post">
          <input type="hidden" name="id" value="<?php echo($id); ?>">

          タイトル<br/>
          <textarea name="title">
            <?php echo($book['title']); ?>
          </textarea><br/>


          著者を入力<br/>
          <select name="author_no">

              <option value="<?php echo($book['author_id']) ?>" checked>
                <?php echo($book['author_name']); ?></option>

          </select><br/><br/>

          出版社を入力<br/>
              <input type="checkbox" name="company_no" value="<?php echo($company['company_id']); ?>">
              <?php echo($book['company_name']); ?>
          <br/><br/>

          週刊誌or月刊誌<br/>
          <input type="radio" name="class" value="<?php echo($book['class']) ?>"><?php echo($book['class']) ?>
          <br/><br/>
          <input type="button"  onclick = "history.back()" value = "戻る">

          <button type="submit">変更</button>
        </form>
      </div>


</body>
</html>
