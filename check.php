<!DOCTYPE html>
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

      session_start();

      $_SESSION['title'] = $_POST['title'];
      $title = $_SESSION['title'];

      $_SESSION['author'] = $_POST['author'];
      $author = $_SESSION['author'];

      $_SESSION['company'] = $_POST['company'];
      $company = $_SESSION['company'];

      

      $title = htmlspecialchars($title);
      $author = htmlspecialchars($author);
      $company = htmlspecialchars($company);

      print 'タイトル:';
      print $title;
      print '<br/>';
      print '著者:';
      print $author;
      print '<br/>';
      print '出版社:';
      print $company;


      if($title == '' || $author == '' || $company == ''){
        print '<form>';
        print '<input type= "button" onclick ="history.back() value = "戻る">';
        print '</form>';
      }else{
        print '<form method="post" action="save.php">';

        // print '<input name="title" type="hidden" value="'.$title.'">';
        // print '<input name="author" type="hidden"  value="'.$author.'">';
        // print '<input name="company" type="hidden" value="'.$company.'">';

        print '<input type= "button" onclick = "history.back()" value = "戻る">';
        print '<input type= "submit" value="登録">';

        print '</form>';

      }

      ?>
</body>
</html>
