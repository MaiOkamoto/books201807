<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>漫画新規登録</title>

</head>
<body>
<?php
  session_start();
  $_SESSION['check'] = false;
 ?>
  <h2>漫画新規登録</h2>
  <form method="post" action="check.php">
    タイトルを入力<br/>
    <input name="title" type="text"><br/>
    著者を入力<br/>
    <input name="author" type="text"><br/>
    出版社を入力<br/>
    <input name="company" type="text"><br/><br/>
    <input type="submit" value="確認">
  </form>

</body>
</html>
