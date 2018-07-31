<!DOCTYPE html>
<?php
  session_start();
 ?>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>漫画新規登録</title>
</head>
<body>
  <h2>漫画新規登録</h2>
  <?php
      $_SESSION['check'] = false;

      //データベース接続
      $dsn = 'mysql:dbname=mybooks;host:localhost;charset=utf8';
      $user ='root';
      $password = '';
      $dbh = new PDO($dsn,$user,$password);
      $dbh->query('SET NAMES utf8');


      //データベースから取得
      $authors = $dbh->query('SELECT * FROM author');
      $companys = $dbh->query('SELECT * FROM company');

      //データベース接続解除
      $dbh = null;
      ?>


  <form method="post" action="check.php">
    タイトルを入力<br/>
    <?php if(isset($_SESSION['title'])): ?>
    <input type="text" name="title" value="<?php echo($_SESSION['title']); ?>">
    <?php else: ?>
    <input name="title" type="text">
    <?php endif; ?>
    <br/><br/>

    著者を入力<br/>
    <select name="author_no">
      <?php while($author = $authors->fetch()): ?>
      <?php if(isset($_SESSION['author_no']) && ($_SESSION['author_no'] == $author['author_id'])): ?>
        <option value="<?php echo($author['author_id']) ?>" selected><?php echo($author['author_name']); ?></option>
      <?php else: ?>
        <option value="<?php echo($author['author_id']) ?>"><?php echo($author['author_name']); ?></option>
      <?php endif; ?>
      <?php endwhile; ?>
    </select><br/><br/>

    出版社を入力<br/>
      <?php while($company = $companys->fetch()): ?>
        <?php if(isset($_SESSION['company_no']) && ($_SESSION['company_no'] == $company['company_id'])): ?>
        <input type="checkbox" name="company_no" value="<?php echo($company['company_id']); ?>" checked>
        <?php echo($company['company_name']); ?>
        <?php else: ?>
        <input type="checkbox" name="company_no" value="<?php echo($company['company_id']); ?>">
        <?php echo($company['company_name']); ?>
        <?php endif; ?>
      <?php endwhile; ?><br/><br/>

    週刊誌or月刊誌<br/>
    <?php if(isset($_SESSION['class']) && ($_SESSION['class'] == '週刊誌')): ?>
    <input type="radio" name="class" value="週刊誌" checked>週刊誌
    <input type="radio" name="class" value="月刊誌">月刊誌
    <?php else: ?>
    <input type="radio" name="class" value="週刊誌">週刊誌
    <input type="radio" name="class" value="月刊誌" checked>月刊誌
    <?php endif; ?>

    <br/><br/>
    <button type="submit">確認</button>
  </form>
    <br/>
  <a href="index.html">TOPに戻る</a>



</body>
</html>
