<?php 
    session_start();
    require('../functions.php');

    $validations = array();

    if (!empty($_POST)) {
        $name = $_POST['input_name'];
        $email = $_POST['input_email'];
        $password = $_POST['input_password'];

        $count = strlen($password);

        if ($name == '') {
            $validations['name'] = 'blank';
        }

        if ($email == '') {
            $validations['email'] = 'blank';
        }

        if ($password == '') {
            $validations['password'] = 'blank';
        }elseif ($count < 4 || $count >16) {
            $validations['password'] = 'length';
        }

        $file_name = $_FILES['input_img_name']['name'];
        if (!empty($file_name)) {
          # code...
        }else{
            $validations['img_name'] = 'blank';
        }

        if (!empty($file_name)) {
            $file_type = substr($file_name, -3);
            $file_type = strtolower($file_type);
            if ($file_type != 'jpg' && $file_type != 'png' && $file_type != 'gif') {
                $validations['img_name'] = 'type';
            }
        }else{
            $validations['img_name'] = 'blank';
        }

        if (empty($validations)) {
            date_default_timezone_set('Asia/Manila');
            $date_str = date('YmdHis');
            $submit_file_name = $date_str . $file_name;
            move_uploaded_file($_FILES['input_img_name']['tmp_name'], '../user_profile_img/' . $submit_file_name);

            $_SESSION['register']['name'] = $_POST['input_name'];
            $_SESSION['register']['email'] = $_POST['input_email'];
            $_SESSION['register']['password'] = $_POST['input_password'];
            $_SESSION['register']['img_name'] = $submit_file_name;

            header('Location: self_check2.php');
            exit();
        }

    }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>Learn SNS</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
  <style>
    .content_header{
      border-bottom: 1px solid #E6E6E6;
    }
  </style>
</head>
<body style="margin-top: 60px">
  <div class="container">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <h2 class="text-center content_header">アカウント作成</h2>
          <form method="POST" action="self_signup1.php" enctype="multipart/form-data">
            <div class="form-group">
              <label for="name">ユーザー名</label>
              <input type="text" name="input_name" class="form-control" id="name" placeholder="山田太郎">
              <?php if(isset($validations['name']) && $validations['name'] == 'blank'): ?>
                <p class="text-danger">ユーザー名を入力してください</p>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="email">メールアドレス</label>
              <input type="email" name="input_email" class="form-control" id="email" placeholder="example@gmail.com">
              <?php if(isset($validations['email']) && $validations['email'] == 'blank'): ?>
                <p class="text-danger">メールアドレスを入力してください</p>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="password">パスワード</label>
              <input type="password" name="input_password" class="form-control" id="password" placeholder="4〜16文字のパスワード">
              <?php if(isset($validations['password']) && $validations['password'] == 'blank'): ?>
                <p class="text-danger">パスワードを入力してください</p>
              <?php elseif(isset($validations['password']) && $validations['password'] == 'length'): ?>
                <p class="text-danger">パスワードは4〜16文字で入力してください</p>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="img_name">プロフィール画像</label>
              <input type="file" name="input_img_name" class="form-control" id="img_name" accept="image/*">
              <?php if (isset($validations['img_name']) && $validations['img_name'] == 'blank'): ?>
                <p class="text-danger">画像を入力してください</p>
              <?php elseif(isset($validations['img_name']) && $validations['img_name'] == 'type'): ?>
                <p class="text-danger">拡張子が「jpg」「png」「gif」の画像を選択してください</p>
              <?php endif; ?>
            </div>
            <input type="submit" class="btn btn-default" value="確認">
            <a href="../self_signin.php" style="float: right; padding-top: 6px;" class="text-success">サインイン</a>
          </form>
      </div>

    </div>
  </div>
  <script src="../assets/js/jquery-3.1.1.js"></script>
  <script src="../assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="../assets/js/bootstrap.js"></script>

</body>
</html>