<?php 
    session_start();
    require('functions.php');
    require('dbconnect.php');

    //v($_SESSION["id"], '$_SESSION["id"]');

    //ユーザー情報の取得
    $sql = 'SELECT * FROM `users` WHERE `id` = ?';
    $data = array($_SESSION['id']);

    $stmt = $dbh->prepare($sql);//アロー演算子の左側をオブジェクトという
    $stmt->execute($data);
    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);

    v($signin_user, '$signin_user');


    $validations = array();
    $feed = '';

    if (!empty($_POST)) {
        $feed = $_POST['feed'];

        if ($feed == '') {
            $validations['feed'] = 'blank';
        }else{
            //データベースに投稿データを保存
            //DB登録処理
            //usersテーブルにユーザー情報の登録処理
            $sql = 'INSERT INTO `feeds` SET `user_id` = ?, `feed` = ?, `created` = NOW()';
            $stmt = $dbh->prepare($sql);
            $data = array($signin_user['id'], $feed);
            $stmt->execute($data);
        }
    }

    

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <title></title>
  <meta charset="utf-8">
  <style>
    .error_msg {
      color: red;
      font-size: 12px;
    }
  </style>
</head>
<body>
  ユーザー情報<br>
  <img width="100" src="user_profile_img/<?php echo $signin_user['img_name']; ?>"><br>
  <?php echo $signin_user['name']; ?><br>
  <a href="signout.php">サインアウト</a>
  <form method="POST" action="" enctype="multipart/form-data">
    <textarea rows="5" name="feed"></textarea>
    <input type="submit" value="投稿"><br>
    <?php if(isset($validations['feed']) && $validations['feed'] == 'blank'): ?>
      <span class="error_msg">投稿データを入力してください</span>
    <?php endif; ?>
  </form>
</body>
</html>