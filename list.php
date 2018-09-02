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
      // $books = $dbh->query('SELECT * FROM book_list ORDER BY id');
      $books = $dbh->prepare('SELECT *
                            FROM book_list
                            LEFT JOIN author
                            ON book_list.author_id = author.author_id
                            ');
      $books->execute();


      $companys = $dbh->prepare('SELECT * FROM company');
      $companys->execute();
      $companylist = $companys->fetchAll(PDO::FETCH_ASSOC);

      $categorys = $dbh->prepare('SELECT * FROM category');
      $categorys->execute();
      $categorylist = $categorys->fetchAll(PDO::FETCH_ASSOC);

      //データベース接続解除
      $dbh = null;
    ?>

    <?php while($book = $books->fetch()): ?>

      <dl>
        <dt>●<?php echo($book['title']); ?></dt>
        <dd>ー<?php echo($book['author_name']); ?></dd>
        <dd>
          <?php  $company_array = explode(',',$book['company_id']); ?>

          <?php foreach($companylist as $company): ?>
            <?php foreach ($company_array as $valu): ?>
              <?php if($company['company_id'] == $valu): ?>
                ー<?php echo $company['company_name']. "  " ;?>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php endforeach; ?>

          </dd>

          <dd>
            <?php $category_array = explode(',',$book['category_id']);  ?>

            <?php foreach ($categorylist as $category ): ?>
              <?php foreach($category_array as $valu): ?>
                <?php if($category['category_id'] == $valu): ?>
                  ー<?php echo $category['category_name'], " "; ?>
                <?php endif; ?>
              <?php endforeach; ?>
            <?php endforeach; ?>

          </dd>


        <img src="<?php echo($book['image']); ?>" alt="<?php echo($book['title']); ?>">
        <dd></dd>
        <dd>
          <form action="update.php" method="post">
            <input name="id" type="hidden" value="<?php echo $book['id'] ?>">
            <button type="submit">編集</button>
          </form>
        </dd>
        <dd>
          <form action="delete.php" method="post">
            <input name="id" type="hidden" value="<?php echo $book['id'] ?>">
            <button type="submit">削除</button>
          </form>
        </dd>
      </dl>
        <?php endwhile; ?>
        <a href="index.html">TOPに戻る</a>

</body>
</html>
