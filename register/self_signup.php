<?php
    session_start();
    require('../functions.php');

    v($_POST, '$_POST');

    $validations = array();
    $name = '';
    $name1 = '';
    $gender = '';
    $date = '';
    $pref = '';
    $adress = '';
    $tel = '';
    $email = '';
    $jobs = '';
    $password = '';
    $password_sub = '';
    $img_name = '';

    if (!empty($_POST)) {

        $name = $_POST['name'];
        $name1 = $_POST['name1'];
        $date = $_POST['date'];
        $pref = $_POST['pref'];
        $adress = $_POST['adress'];
        $tel = $_POST['tel'];
        $email = $_POST['email'];
        $jobs = $_POST['jobs'];
        $password = $_POST['password'];
        $password_sub = $_POST['password_sub'];

        //バリデーション
        //ユーザー名の空
        if ($name == '') {
            $validations['name'] = 'blank';
        }
        if ($name1 == '') {
            $validations['name1'] = 'blank';
        }
        if ($gender == '') {
            $validations['gender'] = 'blank';
        }
        if ($date == '') {
            $validations['date'] = 'blank';
        }
        if ($pref == '') {
            $validations['pref'] = 'blank';
        }
        if ($adress == '') {
            $validations['adress'] = 'blank';
        }
        if ($tel == '') {
            $validations['tel'] = 'blank';
        }
        //メールアドレスの空
        if ($email == '') {
            $validations['email'] = 'blank';
        }
        if ($jobs == '') {
            $validations['jobs'] = 'blank';
        }
        if ($password_sub == '') {
            $validations['password_sub'] = 'blank';
        }

        $c = strlen($password);
        //パスワードの空
        if ($password == '') {
            $validations['password'] = 'blank';
        }elseif ($c < 4 || 16 < $c) {
            $validations['password'] = 'length';
        }

        $file_name = $_FILES['img_name']['name'];
        v($file_name, '$file_name');
        if ($file_name == '') {
            $validations['img_name'] = 'blank';
        }

        if (empty($validations)) {

            //画像アップロード処理
            v($_FILES, '$_FILES');

            //move_uploaded_file(送りたいファイルデータ, 送信先);
            $tmp_file = $_FILES['img_name']['tmp_name'];//選択した画像データ
            $file_name = date('YmdHis') . $_FILES['img_name']['name'];
            $destination = '../user_profile_img/'. $file_name;//登録先と保存名
            move_uploaded_file($tmp_file, $destination);

            $_SESSION['46_LearnSNS']['name'] = $name;
            $_SESSION['46_LearnSNS']['email'] = $email;
            $_SESSION['46_LearnSNS']['password'] = $password;
            $_SESSION['46_LearnSNS']['file_name'] = $file_name;

            header('Location: self_check.php');
            exit();
        }
    }

    $pref = array('北海道','青森県','岩手県','宮城県','秋田県','山形県','福島県','茨城県','栃木県','群馬県','埼玉県','千葉県','東京都','神奈川県','新潟県','富山県','石川県','福井県','山梨県','長野県','岐阜県','静岡県','愛知県','三重県','滋賀県','京都府','大阪府','兵庫県','奈良県','和歌山県','鳥取県','島根県','岡山県','広島県','山口県','徳島県','香川県','愛媛県','高知県','福岡県','佐賀県','長崎県','熊本県','大分県','宮崎県','鹿児島県','沖縄県');

    $jobs = array('高校生','大学生','公務員','大学教授','民間企業','フリーター');


  //②前回選択し送信された都道府県の値を保持
    $pref_num = -1; //0以外のデータを初期化
    $jobs_num = -1; //0以外のデータを初期化

    if (!empty($_POST)) {
        $pref_num = $_POST['pref'];
        $jpbs_num = $_POST['jobs'];
    }
    $c = count($pref);
    $d = count($jobs);

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
  <h1>ユーザー登録</h1>
  <form method="POST" action="" enctype="multipart/form-data">

    <div>
      ユーザー名<br>
      <input type="text" name="name" value="" placeholder="山田 太郎">
      <?php if(isset($validations['name']) && $validations['name'] == 'blank'): ?>
        <span class="error_msg">ユーザー名を入力してください</span>
      <?php endif; ?>
    </div>

    <h3></h3>

    <div>
      ユーザー名（フリガナ）<br>
      <input type="text" name="name1" value="" placeholder="ヤマダ タロウ">
      <?php if(isset($validations['name1']) && $validations['name1'] == 'blank'): ?>
        <span class="error_msg">ユーザー名（フリガナ）を入力してください</span>
      <?php endif; ?>
    </div>

    <h3></h3>

    <div>
      性別<br>
      <input type="radio" name="gender1" value="男" /> 男　
      <input type="radio" name="gender2" value="女" /> 女
      <?php if (isset($validations['gender']) && $validations['gender1'] == 'blank' && $validations['gender2'] == 'blank'): ?>
        <span class="error_msg">性別を選択して下さい</span>
      <?php endif; ?>
    </div>

    <h3></h3>

    <div>
      誕生日<br>
      <input type="date" name="date" value="">
      <?php if(isset($validations['date']) && $validations['date'] == 'blank'): ?>
        <span class="error_msg">生年月日を入力してください</span>
      <?php endif; ?>
    </div>

    <h3></h3>

    <div>
      住所<br>
      都道府県
      <select name="pref">
        <option value="-1">選択してください</option>
        <?php if(isset($validations['pref']) && $validations['pref'] == 'blank'): ?>
          <span class="error_msg">都道府県を入力してください</span>
        <?php endif; ?>
        <?php for($i=0; $i < $c; $i++): ?>
          <?php if ($i == $pref_num): ?>
            <!--前回選択されたvalue（都道府県）なのでoptionタグにselected属性をつける　-->
            <option value="<?php echo $i; ?>" selected><?php echo $pref[$i]; ?></option>
          <?php else: ?>
            <!--前回選択されたvalueと一致しないもしくはそもそもPOST送信されていないのでoptionタグをそのまま表示-->
            <option value="<?php echo $i; ?>"><?php echo $pref[$i]; ?></option>
          <?php endif; ?>
        <?php endfor; ?>
      </select>
      市区町村以下
      <input type="address" name="adress" value="">
      <?php if(isset($validations['adress']) && $validations['adress'] == 'blank'): ?>
        <span class="error_msg">市町村以下を入力してください</span>
      <?php endif; ?>
    </div>

    <h3></h3>

    <div>
      電話番号<br>
      <input type="tel" name="tel" value="" placeholder="0123456789">
      <?php if(isset($validations['tel']) && $validations['tel'] == 'blank'): ?>
        <span class="error_msg">電話番号を入力してください</span>
      <?php endif; ?>
    </div>

    <h3></h3>

    <div>
      メールアドレス<br>
      <input type="email" name="email" value="" placeholder="example@gmail.com">
      <?php if(isset($validations['email']) && $validations['email'] == 'blank'): ?>
        <span class="error_msg">メールアドレスを入力してください</span>
      <?php endif; ?>
    </div>

    <h3></h3>

    <div>
      職業<br>
      <select name="jobs">
        <option value="-1">選択してください</option>
        <?php if(isset($validations['jobs']) && $validations['jobs'] == 'blank'): ?>
          <span class="error_msg">職業を入力してください</span>
        <?php endif; ?>
        <?php for($i=0; $i < $d; $i++): ?>
          <?php if ($i == $jobs_num): ?>
            <!--前回選択されたvalue（都道府県）なのでoptionタグにselected属性をつける　-->
            <option value="<?php echo $i; ?>" selected><?php echo $jobs[$i]; ?></option>
          <?php else: ?>
            <!--前回選択されたvalueと一致しないもしくはそもそもPOST送信されていないのでoptionタグをそのまま表示-->
            <option value="<?php echo $i; ?>"><?php echo $jobs[$i]; ?></option>
          <?php endif; ?>
        <?php endfor; ?>
      </select>
    </div>

    <h3></h3>

    <div>
      パスワード<br>
      <input type="password" name="password" value="" placeholder="4文字以上16以内">
      <?php if(isset($validations['password']) && $validations['password'] == 'blank'): ?>
        <span class="error_msg">パスワードを入力してください</span>
      <?php endif; ?>
      <?php if(isset($validations['password']) && $validations['password'] == 'length'): ?>
        <span class="error_msg">パスワードは4〜16文字で入力してください</span>
      <?php endif; ?>
    </div>

    <h3></h3>

    <div>
      パスワード（確認用）<br>
      <input type="password" name="password_sub" value="" placeholder="4文字以上16以内">
      <?php if(isset($validations['password_sub']) && $validations['password_sub'] == $validations['password']): ?>
        <span class="error_msg">正しいパスワードを入力してください</span>
      <?php endif; ?>
    </div>

    <h3></h3>

    <div>
      プロフィール画像<br>
      <input type="file" name="img_name" accept="image/*">
      <?php if(isset($validations['img_name']) && $validations['img_name'] == 'blank'): ?>
        <span class="error_msg">画像を選択してください</span>
      <?php endif; ?>
    </div>

    <h3></h3>

    <input type="submit" value="確認">
  </form>
</body>
</html>