<?php
    session_start();
    require('../functions.php');
    require('../dbconnect.php');

    $sql = 'SELECT * FROM `users` WHERE `id` = ? ';
    $data = array($_SESSION['id']);
    


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title></title>
  <meta charset="utf-8">
</head>
<body>

</body>
</html>