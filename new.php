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
    <input name="title" type="text"><br/><br/>

    著者を入力<br/>
    <select name="author_no">
      <?php while($author = $authors->fetch()): ?>
        <option value="<?php echo($author['author_id']) ?>"><?php echo($author['author_name']); ?></option>
      <?php endwhile; ?>
    </select><br/><br/>

    出版社を入力<br/>
      <?php while($company = $companys->fetch()): ?>
        <input type="checkbox" name="company_no" value="<?php echo($company['company_id']); ?>">
        <?php echo($company['company_name']); ?>
      <?php endwhile; ?><br/><br/>

    週刊誌or月刊誌<br/>
    <input type="radio" name="class" value="週刊">週刊
    <input type="radio" name="class" value="月刊">月間
    <br/><br/>
    <input type="submit" value="確認">
  </form>
    <br/>
  <a href="index.html">TOPに戻る</a>



</body>
</html>
